<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // Security check: ensure the reservation belongs to a visit owned by the authenticated guide
        if ($reservation->visit->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:confirmé,annulé'
        ]);

        $reservation->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Le statut de la réservation a été mis à jour.');
    }
}
