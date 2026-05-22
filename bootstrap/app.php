<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'guide' => \App\Http\Middleware\IsGuide::class,
            'guide.verified' => \App\Http\Middleware\IsGuideVerified::class,
            'voyageur' => \App\Http\Middleware\IsVoyageur::class,
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
