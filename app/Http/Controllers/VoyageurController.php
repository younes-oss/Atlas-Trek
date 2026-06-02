<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class VoyageurController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        // Statistiques
        $stats = [
            'total' => Reservation::where('user_id', $userId)->count(),
            'pending' => Reservation::where('user_id', $userId)->where('status', 'en_attente')->count(),
            'confirmed' => Reservation::where('user_id', $userId)->where('status', 'confirmé')->count(),
        ];

        // Dernières réservations
        $recentReservations = Reservation::where('user_id', $userId)
            ->with('visit')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Explorer les visites (ex: les 3 dernières)
        $exploreVisits = Visit::orderBy('created_at', 'desc')->take(3)->get();

        return view('voyageur.dashboard', compact('stats', 'recentReservations', 'exploreVisits'));
    }

    public function reservations()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('visit')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('voyageur.reservations', compact('reservations'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('voyageur.profile', compact('user'));
    }

    public function destroy(Reservation $reservation)
    {
        // Vérification de sécurité : seul le propriétaire peut supprimer
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        // Seules les réservations annulées ou expirées devraient pouvoir être cachées de l'historique
        if (!in_array($reservation->status, [Reservation::STATUS_CANCELLED, Reservation::STATUS_EXPIRED])) {
            return redirect()->back()->with('error', 'Vous ne pouvez supprimer que les réservations annulées ou expirées.');
        }

        $reservation->delete();

        return redirect()->back()->with('success', 'La réservation a été supprimée de votre historique.');
    }
}
