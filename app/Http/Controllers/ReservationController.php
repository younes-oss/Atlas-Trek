<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reservation;
use App\Models\Visit;
use App\Http\Requests\StoreReservationRequest;

class ReservationController extends Controller
{
    // ═══════════════════════════════════════════════════════════════════
    //  STORE — Création d'une réservation par un voyageur
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Règles métier vérifiées avant de créer la réservation :
     *   1. La visite ne doit pas avoir déjà démarré (date_depart > now)
     *   2. La date limite de réservation ne doit pas être dépassée
     *   3. Les places restantes doivent suffire
     *
     * On utilise lockForUpdate() pour sécuriser contre la concurrence.
     */
    public function store(StoreReservationRequest $request, Visit $visit)
    {
        // ── Règle 1 : Visite déjà passée ?
        if ($visit->hasStarted()) {
            return redirect()->back()->withErrors([
                'reservation' => 'Impossible de réserver : cette visite a déjà démarré.',
            ]);
        }

        // ── Règle 2 : Date limite de réservation dépassée ?
        if (!$visit->isOpenForReservation()) {
            return redirect()->back()->withErrors([
                'reservation' => 'La date limite de réservation est dépassée. Les réservations sont fermées.',
            ]);
        }

        // ── Règle 3 : Une seule réservation par jour par voyageur
        $alreadyReservedToday = Reservation::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->exists();

        if ($alreadyReservedToday) {
            return redirect()->back()->withErrors([
                'reservation' => 'Vous avez déjà effectué une réservation aujourd\'hui. Vous pouvez en faire une nouvelle à partir de demain.',
            ]);
        }

        // ── Règle 4 : Vérification des places (avec protection contre la concurrence)
        try {
            DB::transaction(function () use ($request, $visit) {

                // On verrouille la visite en écriture pour ce calcul
                $visitLock = Visit::lockForUpdate()->findOrFail($visit->id);

                $remainingPlaces = $visitLock->availablePlaces();

                if ($request->number_of_people > $remainingPlaces) {
                    throw new \Exception(
                        "Désolé, il reste seulement {$remainingPlaces} place(s) disponible(s) pour cette visite."
                    );
                }

                Reservation::create([
                    'user_id'          => auth()->id(),
                    'visit_id'         => $visitLock->id,
                    'date'             => $visitLock->date_depart,
                    'number_of_people' => $request->number_of_people,
                    'status'           => Reservation::STATUS_PENDING,
                ]);
            });

            return redirect()
                ->route('visits.show', $visit)
                ->with('success', 'Votre réservation a été envoyée avec succès. En attente de confirmation.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['reservation' => $e->getMessage()]);
        }
    }

    // ═══════════════════════════════════════════════════════════════════
    //  INDEX — Liste des réservations du guide connecté
    // ═══════════════════════════════════════════════════════════════════

    public function index()
    {
        $reservations = Reservation::whereHas('visit', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with(['user', 'visit'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guide.reservations', compact('reservations'));
    }

    // ═══════════════════════════════════════════════════════════════════
    //  UPDATE STATUS — Confirmation ou annulation par le guide
    // ═══════════════════════════════════════════════════════════════════

    /**
     * Règles métier pour la CONFIRMATION :
     *   1. Seul le guide propriétaire de la visite peut confirmer
     *   2. La visite ne doit pas avoir déjà démarré (date_depart > now)
     *   3. La réservation doit être en statut "en_attente" (pas déjà traitée)
     *   4. Le nombre de places doit suffire
     *
     * Transaction + lockForUpdate pour éviter les doublons concurrent.
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        // ── Autorisation : seul le guide créateur de la visite peut agir
        if ($reservation->visit->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'status' => 'required|in:confirmé,annulé',
        ]);

        $newStatus = $request->status;

        // ══ Branche CONFIRMATION ══
        if ($newStatus === Reservation::STATUS_CONFIRMED) {
            try {
                DB::transaction(function () use ($reservation) {

                    // ── Verrouillage pessimiste : visit + reservation
                    $visit           = Visit::lockForUpdate()->findOrFail($reservation->visit_id);
                    $reservationLock = Reservation::lockForUpdate()->findOrFail($reservation->id);

                    // ── Règle 1 : La visite a-t-elle déjà démarré ?
                    if ($visit->hasStarted()) {
                        throw new \Exception(
                            'Impossible de confirmer : la date de départ de cette visite est déjà passée ('
                            . $visit->date_depart->format('d/m/Y H:i') . ').'
                        );
                    }

                    // ── Règle 2 : Statut encore en attente ?
                    if ($reservationLock->status !== Reservation::STATUS_PENDING) {
                        throw new \Exception(
                            'Cette réservation a déjà été traitée (statut : ' . $reservationLock->status . ').'
                        );
                    }

                    // ── Règle 3 : Places suffisantes ?
                    // On recalcule les places occupées par TOUTES les autres réservations
                    $otherOccupiedPlaces = $visit->reservations()
                        ->whereIn('status', ['confirmé', 'en_attente'])
                        ->where('id', '!=', $reservationLock->id)
                        ->sum('number_of_people');

                    $remainingPlaces = $visit->max_places - $otherOccupiedPlaces;

                    if ($reservationLock->number_of_people > $remainingPlaces) {
                        throw new \Exception(
                            "Places insuffisantes. Places restantes : {$remainingPlaces}, "
                            . "demandées : {$reservationLock->number_of_people}."
                        );
                    }

                    // ── Tout est OK → on confirme
                    $reservationLock->update(['status' => Reservation::STATUS_CONFIRMED]);
                });

                return redirect()->back()->with('success', 'Réservation confirmée avec succès.');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }

        // ══ Branche ANNULATION ══
        // L'annulation ne nécessite pas de vérification de places ni de dates.
        $reservation->update(['status' => Reservation::STATUS_CANCELLED]);

        return redirect()->back()->with('success', 'Réservation annulée avec succès.');
    }
}
