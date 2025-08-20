<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoriqueTest;
use App\Models\Souscription;

class CheckFreeTests
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('auth.connexion')
                ->with('error', 'Veuillez vous connecter pour accéder aux tests.');
        }

        $freeTestsUsed = HistoriqueTest::where('user_id', $user->id)
            ->where('is_free', true)
            ->count();

        $hasActiveSubscription = Souscription::where('user_id', $user->id)
            ->where('date_debut', '<=', now())
            ->where('date_fin', '>=', now())
            ->exists();

        if ($freeTestsUsed >= 2 && !$hasActiveSubscription) {
            return redirect()->route('client.paiement')
                ->with('error', 'Vous avez atteint la limite de tests gratuits.');
        }

        return $next($request);
    }
}