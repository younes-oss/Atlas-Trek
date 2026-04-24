<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * WELCOME — Affiche la page d'accueil avec les dernières visites.
     */
    public function welcome()
    {
        $visits = Visit::orderBy('created_at', 'desc')->take(6)->get();
        return view('welcome', compact('visits'));
    }

    /**
     * INDEX — Affiche la liste de toutes les visites du guide connecté.
     *
     * On récupère uniquement les visites créées par l'utilisateur connecté.
     * auth()->id() retourne l'ID de l'utilisateur actuellement connecté.
     */
    public function index()
    {
        // Récupère toutes les visites du guide connecté, triées par date de création (la plus récente en premier)
        $visits = Visit::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Passe la variable $visits à la vue
        return view('guide.dashboard', compact('visits'));
    }

    /**
     * CREATE — Affiche le formulaire pour créer une nouvelle visite.
     *
     * Cette méthode n'a pas de logique : elle affiche juste le formulaire.
     */
    public function create()
    {
        return view('visits.create');
    }

    /**
     * STORE — Enregistre la nouvelle visite en base de données.
     *
     * Laravel reçoit les données du formulaire via $request.
     * On valide d'abord, puis on enregistre.
     */
   public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'location'    => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'duration'    => 'required|integer|min:1',
        'difficulty'  => 'required|in:facile,moyen,difficile',
        'image'       => 'required|image|mimes:jpeg,png,jpg|max:6000',
    ]);

    $path = null;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('visits', 'public');
    }

    Visit::create([
        'title'       => $request->title,
        'description' => $request->description,
        'location'    => $request->location,
        'price'       => $request->price,
        'duration'    => $request->duration,
        'difficulty'  => $request->difficulty,
        'image'       => $path, 
        'user_id'     => auth()->id(),
    ]);

    return redirect()->route('visits.index')
                     ->with('success', 'Visite créée avec succès !');
}
    /**
     * EDIT — Affiche le formulaire pour modifier une visite existante.
     *
     * Laravel trouve automatiquement la visite grâce à l'ID dans l'URL.
     * On vérifie que la visite appartient bien au guide connecté (sécurité).
     */
    public function edit(Visit $visit)
    {
        // Sécurité : s'assurer que seul le créateur peut modifier sa visite
        if ($visit->user_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez pas modifier une visite qui ne vous appartient pas.');
        }

        return view('visits.edit', compact('visit'));
    }

    /**
     * UPDATE — Met à jour la visite en base de données.
     *
     * Similaire à store(), mais on utilise $visit->update() au lieu de Visit::create().
     */
    public function update(Request $request, Visit $visit)
    {
        // Sécurité : seul le créateur peut modifier
        if ($visit->user_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez pas modifier une visite qui ne vous appartient pas.');
        }

        // Validation — mêmes règles que store()
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'required|integer|min:1',
            'difficulty'  => 'required|in:facile,moyen,difficile',
        ]);

        // Mise à jour de la visite (on ne change pas user_id)
        $visit->update([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'price'       => $request->price,
            'duration'    => $request->duration,
            'difficulty'  => $request->difficulty,
        ]);

        return redirect()->route('visits.index')->with('success', 'Visite mise à jour avec succès !');
    }

    /**
     * DESTROY — Supprime une visite.
     *
     * Le formulaire dans la vue envoie une requête DELETE vers cette méthode.
     */
    public function destroy(Visit $visit)
    {
        // Sécurité : seul le créateur peut supprimer
        if ($visit->user_id !== auth()->id()) {
            abort(403, 'Vous ne pouvez pas supprimer une visite qui ne vous appartient pas.');
        }

        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Visite supprimée avec succès !');
    }
}
