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
}
