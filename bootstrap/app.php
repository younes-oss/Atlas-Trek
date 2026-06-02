<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsGuide;
use App\Http\Middleware\IsGuideVerified;
use App\Http\Middleware\IsVoyageur;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => IsAdmin::class,
            'guide' => IsGuide::class,
            'guide.verified' => IsGuideVerified::class,
            'voyageur' => IsVoyageur::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        // Expire automatiquement les réservations en attente
        // dont la date limite est dépassée — toutes les 15 minutes
        $schedule->command('reservations:expire')->everyFifteenMinutes();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
