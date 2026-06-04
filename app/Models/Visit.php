<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'price',
        'duration',
        'difficulty',
        'image',
        'user_id',
        'max_places',
        'date_depart',
        'date_fin',
        'date_limite_reservation',
        'logement',
        'transport',
        'repas',
    ];

    /**
     * Cast automatique des champs datetime vers des instances Carbon.
     * Carbon est le standard Laravel pour la manipulation des dates.
     */
    protected $casts = [
        'date_depart'              => 'datetime',
        'date_fin'                 => 'datetime',
        'date_limite_reservation'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * La visite est-elle encore ouverte aux réservations ?
     */
    public function isOpenForReservation(): bool
    {
        return $this->date_limite_reservation->isFuture();
    }

    /**
     * La visite a-t-elle déjà démarré (ou est passée) ?
     */
    public function hasStarted(): bool
    {
        return $this->date_depart->isPast();
    }

    /**
     * Calcul des places encore confirmables (places libres).
     */
    public function availablePlaces(): int
    {
        // On bloque les places pour les réservations confirmées ET en attente
        $occupied = $this->reservations()
            ->whereIn('status', ['confirmé', 'en_attente'])
            ->sum('number_of_people');

        return max(0, $this->max_places - $occupied);
    }

    // ─────────────────────────────────────────
    // Scopes Eloquent
    // ─────────────────────────────────────────

    /**
     * Scope : ne retourne que les visites dont la réservation est encore ouverte.
     */
    public function scopeOpenForReservation($query)
    {
        return $query->where('date_limite_reservation', '>', now());
    }

    /**
     * Scope : ne retourne que les visites à venir.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date_depart', '>', now());
    }

    // ─────────────────────────────────────────
    // Favoris
    // ─────────────────────────────────────────

    public function isFavoritedBy($user): bool
    {
        if (!$user) return false;
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
