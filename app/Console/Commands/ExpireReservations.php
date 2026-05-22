<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Reservation;

class ExpireReservations extends Command
{
    /**
     * Nom de la commande Artisan.
     * Usage : php artisan reservations:expire
     */
    protected $signature = 'reservations:expire';

    protected $description = 'Passe en "expiré" toutes les réservations en attente dont la date limite de réservation est dépassée.';

    public function handle(): int
    {
        $now = Carbon::now();

        /**
         * On sélectionne les réservations qui sont :
         *   - en statut "en_attente"
         *   - dont la visite associée a une date_limite_reservation dépassée
         *
         * On utilise whereHas pour filtrer via la relation Visit.
         * La mise à jour est faite en masse (update de masse Eloquent) pour la performance.
         */
        $count = Reservation::where('status', Reservation::STATUS_PENDING)
            ->whereHas('visit', function ($query) use ($now) {
                $query->where('date_limite_reservation', '<', $now);
            })
            ->update(['status' => Reservation::STATUS_EXPIRED]);

        $this->info("[{$now->format('d/m/Y H:i')}] {$count} réservation(s) expirée(s).");

        return Command::SUCCESS;
    }
}
