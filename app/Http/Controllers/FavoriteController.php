<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function toggle(Visit $visit)
    {
        $userId = auth()->id();
        
        $favorite = Favorite::where('user_id', $userId)
                            ->where('visit_id', $visit->id)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Visite retirée de vos favoris.';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'visit_id' => $visit->id,
            ]);
            $message = 'Visite ajoutée à vos favoris avec succès ';
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $favorites = auth()->user()->favoriteVisits()->get();
        return view('voyageur.favorites', compact('favorites'));
    }
}
