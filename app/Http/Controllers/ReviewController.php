<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Visit;
use App\Models\Reservation;

class ReviewController extends Controller
{
    public function store(Request $request, Visit $visit)
    {
        // 1. Validation
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3',
        ]);

        // 2. Sécurité : Vérifier si l'utilisateur a une réservation confirmée pour cette visite
        $hasReservation = Reservation::where('user_id', auth()->id())
            ->where('visit_id', $visit->id)
            ->where('status', 'confirmé')
            ->exists();

        if (!$hasReservation) {
            return redirect()->back()->with('error', 'Vous devez avoir effectué cette visite (réservation confirmée) pour laisser un avis.');
        }

        // 3. Enregistrer l'avis
        Review::create([
            'user_id' => auth()->id(),
            'visit_id' => $visit->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Merci pour votre avis !');
    }
}
