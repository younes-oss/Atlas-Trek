<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$reservations = App\Models\Reservation::with('visit')->get();
foreach ($reservations as $r) {
    echo "ID: {$r->id} | Status: {$r->status} | Limite: {$r->visit->date_limite_reservation} | Now: " . \Carbon\Carbon::now() . "\n";
}
