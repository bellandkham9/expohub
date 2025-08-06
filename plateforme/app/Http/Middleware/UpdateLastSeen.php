<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class UpdateLastSeen
{
    
public function handle(Request $request, Closure $next): Response
{
     Log::info('✅ Middleware atteint');
    if (Auth::check()) {
        $user = Auth::user();
        $user->last_seen_at = now();
        $user->save();
    }

    return $next($request);
}

}
