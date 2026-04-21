<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsGuide
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isGuide()) {
            return $next($request);
        }

        abort(403, 'Accès réservé aux guides.');
    }
}
