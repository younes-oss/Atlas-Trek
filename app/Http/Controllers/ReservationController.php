<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Reservation;
use App\Models\Visit;

class ReservationController extends Controller
{
    public function store(Request $request, Visit $visit)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'number_of_people' => 'required|integer|min:1',
        ]);

        $totalReserved = $visit->reservations()->where('status', 'confirmé')->sum('number_of_people');
        
        if ($totalReserved + $request->number_of_people > $visit->max_places) {
            return redirect()->back()->withErrors(['number_of_people' => 'Désolé, il n\'y a pas assez de places disponibles pour cette visite.']);
        }

        Reservation::create([
            'user_id' => auth()->id(),
            'visit_id' => $visit->id,
            'date' => $request->date,
            'number_of_people' => $request->number_of_people,
            'status' => 'en_attente',
        ]);

        return redirect()->route('visits.show', $visit)->with('success', 'Votre réservation a été envoyée avec succès.');
    }

    public function index()
    {
        $reservations = Reservation::whereHas('visit', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->orderBy('created_at', 'desc')
        ->with(['user', 'visit'])
        ->get();

        return view('guide.reservations', compact('reservations'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        if ($reservation->visit->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:confirmé,annulé'
        ]);

        $newStatus = $request->status;

        if ($newStatus === 'confirmé') {
            try {
                DB::transaction(function () use ($reservation) {
                    // Lock the visit row to prevent concurrent confirmation checks from other transactions
                    $visit = Visit::lockForUpdate()->findOrFail($reservation->visit_id);

                    // Also lock the reservation row to ensure a fresh, consistent status
                    $reservationLock = Reservation::lockForUpdate()->findOrFail($reservation->id);

                    // Safety check: is it already confirmed?
                    if ($reservationLock->status === 'confirmé') {
                        throw new \Exception("Cette réservation est déjà confirmée.");
                    }

                    // Count total people for already confirmed reservations on this visit
                    $confirmedPlaces = $visit->reservations()
                        ->where('status', 'confirmé')
                        ->sum('number_of_people');

                    // Calculate remaining capacity
                    $remainingPlaces = $visit->max_places - $confirmedPlaces;

                    // If the current reservation exceeds the remaining capacity, abort
                    if ($reservationLock->number_of_people > $remainingPlaces) {
                        throw new \Exception(
                            "Places insuffisantes pour confirmer cette réservation. " .
                            "Places restantes : {$remainingPlaces}, demandées : {$reservationLock->number_of_people}."
                        );
                    }

                    // Update the reservation status to confirmed
                    $reservationLock->update([
                        'status' => 'confirmé'
                    ]);
                });

                return redirect()->back()->with('success', 'La réservation a été confirmée avec succès.');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            // Standard cancel update without pessimistic lock requirement on Visit
            $reservation->update([
                'status' => 'annulé'
            ]);

            return redirect()->back()->with('success', 'La réservation a été annulée avec succès.');
        }
    }
}
