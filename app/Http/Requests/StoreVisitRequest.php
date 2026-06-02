<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Visit;

class StoreVisitRequest extends FormRequest
{
    /**
     * Seuls les guides vérifiés peuvent créer des visites.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'guide';
    }

    public function rules(): array
    {
        return [
            'title'                   => 'required|string|max:255',
            'description'             => 'required|string',
            'location'                => 'required|string|max:255',
            'price'                   => 'required|numeric|min:0',
            'duration'                => 'required|integer|min:1',
            'difficulty'              => 'required|in:facile,moyen,difficile',
            'image'                   => 'required|image|mimes:jpeg,png,jpg|max:20480',
            'max_places'              => 'required|integer|min:1',

            // Dates — toutes en format datetime, dans le futur
            'date_depart'             => 'required|date|after:now',
            'date_fin'                => 'nullable|date|after:date_depart',
            'date_limite_reservation' => 'required|date|after:now|before:date_depart',
        ];
    }

    public function messages(): array
    {
        return [
            'date_depart.required'              => 'La date de départ est obligatoire.',
            'date_depart.after'                 => 'La date de départ doit être dans le futur.',
            'date_fin.after'                    => 'La date de fin doit être postérieure à la date de départ.',
            'date_limite_reservation.required'  => 'La date limite de réservation est obligatoire.',
            'date_limite_reservation.after'     => 'La date limite de réservation doit être dans le futur.',
            'date_limite_reservation.before'    => 'La date limite de réservation doit être avant la date de départ.',
        ];
    }

    /**
     * Validation personnalisée après les règles de base :
     * Vérifie si le guide a déjà une visite dont les horaires se chevauchent.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any()) return; // Skip si déjà des erreurs

            $guideId     = auth()->id();
            $dateDepart  = Carbon::parse($this->date_depart);
            $dateFin     = $this->date_fin
                ? Carbon::parse($this->date_fin)
                : $dateDepart->copy()->addHours(2); // Durée minimale par défaut

            // Récupère l'ID de la visite en cours de modification (null si création)
            $excludeId = $this->route('visit')?->id;

            // Détecte les chevauchements avec d'autres visites du même guide.
            // Deux intervalles [A, B] et [C, D] se chevauchent si : A < D && C < B
            $overlap = Visit::where('user_id', $guideId)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->where('date_depart', '<', $dateFin)
                ->where(function ($q) use ($dateDepart) {
                    // date_fin est nullable → on prend date_depart + 2h si absent
                    $q->whereRaw('COALESCE(date_fin, DATE_ADD(date_depart, INTERVAL 2 HOUR)) > ?', [
                        $dateDepart->toDateTimeString()
                    ]);
                })
                ->exists();

            if ($overlap) {
                $validator->errors()->add(
                    'date_depart',
                    'Vous avez déjà une visite planifiée sur ce créneau horaire. Veuillez choisir des dates différentes.'
                );
            }
        });
    }
}
