<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsGuideVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isGuide() && auth()->user()->is_verified) {
            return $next($request);
        }

        abort(403, 'Votre compte de guide n\'est pas encore vérifié par l\'administrateur.');
    }
}
