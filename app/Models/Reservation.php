<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'visit_id',
        'date',
        'number_of_people',
        'status',
    ];

    /**
     * Les statuts possibles d'une réservation.
     * On les centralise ici pour éviter les "magic strings" partout dans le code.
     */
    const STATUS_PENDING   = 'en_attente';
    const STATUS_CONFIRMED = 'confirmé';
    const STATUS_CANCELLED = 'annulé';
    const STATUS_EXPIRED   = 'expiré';

    // ─────────────────────────────────────────
    // Relations
    // ─────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    // ─────────────────────────────────────────
    // Helpers de statut
    // ─────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    // ─────────────────────────────────────────
    // Scopes Eloquent
    // ─────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }
}
