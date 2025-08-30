<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié et s'il est super admin
        if (Auth::check() && Auth::user()->role === 'super_admin') {
            return $next($request);
        }

        // Si l'utilisateur n'est pas super admin
        return redirect('/')->with('error', 'Accès réservé au super administrateur.');
    }
}
