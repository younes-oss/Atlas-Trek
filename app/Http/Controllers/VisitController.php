<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    /**
     * WELCOME — Affiche la page d'accueil avec les dernières visites à venir.
     */
    public function welcome()
    {
        // On n'affiche que les visites dont la date de départ est dans le futur
        $visits  = Visit::upcoming()->orderBy('date_depart', 'asc')->take(6)->get();
        $reviews = \App\Models\Review::with(['user', 'visit'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('visits', 'reviews'));
    }

    /**
     * INDEX — Dashboard du guide : liste ses propres visites.
     */
    public function index()
    {
        $userId = auth()->id();

        $visits = Visit::where('user_id', $userId)
            ->orderBy('date_depart', 'asc')
            ->get();

        $reservationsQuery = Reservation::whereHas('visit', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        $recentReservations = (clone $reservationsQuery)
            ->with(['user', 'visit'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_visits'           => $visits->count(),
            'total_reservations'     => (clone $reservationsQuery)->count(),
            'pending_reservations'   => (clone $reservationsQuery)->where('status', Reservation::STATUS_PENDING)->count(),
            'confirmed_reservations' => (clone $reservationsQuery)->where('status', Reservation::STATUS_CONFIRMED)->count(),
        ];

        return view('guide.dashboard', compact('visits', 'recentReservations', 'stats'));
    }

    /**
     * SHOW — Affiche les détails d'une visite.
     */
    public function show(Visit $visit)
    {
        $canReview = false;
        if (auth()->check()) {
            $canReview = Reservation::where('user_id', auth()->id())
                ->where('visit_id', $visit->id)
                ->where('status', Reservation::STATUS_CONFIRMED)
                ->exists();
        }

        return view('visits.show', compact('visit', 'canReview'));
    }

    /**
     * CREATE — Affiche le formulaire de création d'une visite.
     */
    public function create()
    {
        return view('visits.create');
    }

    /**
     * STORE — Enregistre une nouvelle visite avec validation des dates.
     * La validation du chevauchement est gérée dans StoreVisitRequest::withValidator().
     */
    public function store(StoreVisitRequest $request)
    {
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('visits', 'public');
        }

        Visit::create([
            'title'                   => $request->title,
            'description'             => $request->description,
            'location'                => $request->location,
            'price'                   => $request->price,
            'duration'                => $request->duration,
            'difficulty'              => $request->difficulty,
            'image'                   => $path,
            'user_id'                 => auth()->id(),
            'max_places'              => $request->max_places,
            'date_depart'             => $request->date_depart,
            'date_fin'                => $request->date_fin,
            'date_limite_reservation' => $request->date_limite_reservation,
            'logement'                => $request->logement,
            'transport'               => $request->transport,
            'repas'                   => $request->repas,
        ]);

        return redirect()
            ->route('guide.dashboard')
            ->with('success', 'Visite créée avec succès !');
    }

    /**
     * EDIT — Affiche le formulaire d'édition d'une visite existante.
     */
    public function edit(Visit $visit)
    {
        if ($visit->user_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez pas modifier une visite qui ne vous appartient pas.');
        }

        return view('visits.edit', compact('visit'));
    }

    /**
     * UPDATE — Met à jour une visite avec validation des dates et des chevauchements.
     * StoreVisitRequest exclut automatiquement la visite courante du check de chevauchement.
     */
    public function update(UpdateVisitRequest $request, Visit $visit)
    {
        if ($visit->user_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez pas modifier une visite qui ne vous appartient pas.');
        }

        $data = [
            'title'                   => $request->title,
            'description'             => $request->description,
            'location'                => $request->location,
            'price'                   => $request->price,
            'duration'                => $request->duration,
            'difficulty'              => $request->difficulty,
            'max_places'              => $request->max_places,
            'date_depart'             => $request->date_depart,
            'date_fin'                => $request->date_fin,
            'date_limite_reservation' => $request->date_limite_reservation,
            'logement'                => $request->logement,
            'transport'               => $request->transport,
            'repas'                   => $request->repas,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('visits', 'public');
        }

        $visit->update($data);

        return redirect()
            ->route('guide.dashboard')
            ->with('success', 'Visite mise à jour avec succès !');
    }

    /**
     * DESTROY — Supprime une visite.
     */
    public function destroy(Visit $visit)
    {
        if ($visit->user_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez pas supprimer une visite qui ne vous appartient pas.');
        }

        $visit->delete();

        return redirect()
            ->route('guide.dashboard')
            ->with('success', 'Visite supprimée avec succès !');
    }
}
