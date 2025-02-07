<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SessionExpiredMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !$request->session()->has('last_activity')) {
            // Si la sesión ha expirado
            Auth::logout();
            return response()->json(['error' => 'session_expired'], 401);
        }

        $request->session()->put('last_activity', now());
        return $next($request);
    }
}
