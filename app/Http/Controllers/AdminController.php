<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Visit;
use App\Models\Reservation;

class AdminController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_visits'       => Visit::count(),
            'total_reservations' => Reservation::count(),
            'pending_guides'     => User::where('role', 'guide')->where('is_verified', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // ─── Guides ───────────────────────────────────────────────────────────────
    public function guides()
    {
        $pendingGuides = User::where('role', 'guide')
            ->where('is_verified', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $verifiedGuides = User::where('role', 'guide')
            ->where('is_verified', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.guides', compact('pendingGuides', 'verifiedGuides'));
    }

    public function verifyGuide(User $user)
    {
        if ($user->role !== 'guide') abort(403);

        $user->update(['is_verified' => true]);
        return back()->with('success', "Le guide {$user->name} a été validé avec succès.");
    }

    public function rejectGuide(User $user)
    {
        if ($user->role !== 'guide') abort(403);

        $user->delete();
        return back()->with('success', "Le guide a été refusé et supprimé.");
    }

    // ─── Visites ──────────────────────────────────────────────────────────────
    public function visits(Request $request)
    {
        $query = Visit::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('guide_id')) {
            $query->where('user_id', $request->guide_id);
        }

        $visits = $query->get();
        $guides  = User::where('role', 'guide')->where('is_verified', true)->get();

        return view('admin.visits', compact('visits', 'guides'));
    }

    public function deleteVisit(Visit $visit)
    {
        $visit->delete();
        return back()->with('success', "La visite \"{$visit->title}\" a été supprimée.");
    }

    // ─── Réservations ─────────────────────────────────────────────────────────
    public function reservations(Request $request)
    {
        $query = Reservation::with(['user', 'visit'])->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->get();

        return view('admin.reservations', compact('reservations'));
    }

    // ─── Utilisateurs ─────────────────────────────────────────────────────────
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();
        return back()->with('success', "L'utilisateur {$user->name} a été supprimé.");
    }
}
