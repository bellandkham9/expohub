<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
<<<<<<< HEAD
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('auth.connexion');
        }
        return null;
=======
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('auth.connexion'); // ta route de connexion personnalisée
        }
>>>>>>> 08732e26cc269c5ffb80aae87775bcfd99b1805c
    }
}
