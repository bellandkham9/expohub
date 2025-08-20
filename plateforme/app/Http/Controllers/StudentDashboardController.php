<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Niveau;
use App\Models\TestType;
use App\Models\abonnement;
use App\Models\ComprehensionEcriteResultat;
use App\Models\ComprehensionOraleReponse;
use App\Models\ExpressionEcriteReponse;
use App\Models\ExpressionOraleReponse;
use App\Models\HistoriqueTest;
use App\Models\Souscription;

class StudentDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();


        // Récupérer la souscription active de l'utilisateur avec l'abonnement associé
        $souscriptionActive = Souscription::where('user_id', $user->id)
                                          ->where('date_fin', '>=', Carbon::now())
                                          ->with('abonnement') // Charger la relation 'abonnement'
                                          ->get();

        // Si aucune souscription active n'est trouvée
        if (!$souscriptionActive) {
            return dd('error', 'Votre abonnement est épuisé. Veuillez souscrire à un nouvel abonnement pour accéder à ce contenu.');
        }

        // Accéder directement aux informations de l'abonnement via la relation
        $testTypes = $souscriptionActive;

        // 1. Récupération des niveaux par test
        $userLevels = [];
        foreach ($testTypes as $testType) {
            $niveau = Niveau::where('user_id', $user->id)
                ->where('test_type', $testType->abonnement->id)
                ->first();

            $userLevels[$testType->abonnement->examen] = $niveau ? [
                'comprehension_ecrite' => $niveau->comprehension_ecrite,
                'comprehension_orale' => $niveau->comprehension_orale,
                'expression_ecrite' => $niveau->expression_ecrite,
                'expression_orale' => $niveau->expression_orale,
            ] : [
                'comprehension_ecrite' => 'Non défini',
                'comprehension_orale' => 'Non défini',
                'expression_ecrite' => 'Non défini',
                'expression_orale' => 'Non défini',
            ];
        }

        // 2. Regrouper tous les tests en un tableau commun
        $allTests = collect();

        $comprehensionEcrite = ComprehensionEcriteResultat::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'test_type' => $item->test_type ?? 'TCF Canada',
                'skill' => 'Compréhension Écrite',
                'date' => $item->created_at,
                'duration' => 60,
                'score' => $item->score,
                'max_score' => 699,
                'niveau' => $item->niveau,
                'correct_answers' => $item->nb_bonnes_reponses,
                'total_questions' => $item->nb_total_questions,
            ];
        });

        $comprehensionOrale = ComprehensionOraleReponse::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'test_type' => $item->test_type ?? 'TCF Québec',
                'skill' => 'Compréhension Orale',
                'date' => $item->created_at,
                'duration' => 30,
                'score' => $item->score,
                'max_score' => 699,
                'niveau' => $item->niveau,
                'correct_answers' => $item->nb_bonnes_reponses,
                'total_questions' => $item->nb_total_questions,
            ];
        });

        $expressionEcrite = ExpressionEcriteReponse::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'test_type' => $item->test_type ?? 'TCF Canada',
                'skill' => 'Expression Écrite',
                'date' => $item->created_at,
                'duration' => 60,
                'score' => $item->score,
                'max_score' => 699,
                'niveau' => $item->niveau ?? '—',
                'correct_answers' => null,
                'total_questions' => null,
            ];
        });

        $expressionOrale = ExpressionOraleReponse::where('user_id', $user->id)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'test_type' => $item->test_type ?? 'TCF Québec',
                'skill' => 'Expression Orale',
                'date' => $item->created_at,
                'duration' => 15,
                'score' => $item->score,
                'max_score' => 699,
                'niveau' => $item->niveau ?? '—',
                'correct_answers' => null,
                'total_questions' => null,
            ];
        });

         // ✅ Nouvelle récupération des tests depuis la table `historique_tests`
    $completedTests = HistoriqueTest::where('user_id', $user->id)
        ->orderByDesc('completed_at')
        ->take(2)
        ->get()
        ->map(function ($test) {
            return [
                'id' => $test->id,
                'test_type' => $test->test_type,
                'skill' => ucwords(str_replace('_', ' ', $test->skill)),
                'date' => $test->completed_at ?? $test->created_at,
                'duration' => $test->duration ?? 0,
                'score' => $test->score ?? 0,
                'max_score' => 699,
                'level' => $test->niveau ?? '—',
                'correct_answers' => null, // À adapter si tu veux stocker ça
                'total_questions' => null,
                'details_route'=> $test->details_route,
                'refaire_route'=> $test->refaire_route,
            ];
        });



        $learningGoal = [
            'target_level' => 'C1',
            'current_progress' => 65,
            'target_date' => Carbon::now()->addMonths(3)
        ];

        return view('client.dashboard', compact(
            'userLevels',
            'completedTests',
            'learningGoal',
            'testTypes'
        ));
    }


   public function verifierAcces()
{
    $testsGratuits = HistoriqueTest::where('user_id', Auth::id())
        ->where('is_free', true)
        ->count();

    if ($testsGratuits >= 4) {
        return response()->json([
            'has_free_tests' => false
        ]);
    }

    return response()->json([
        'has_free_tests' => true
    ]);
}


}

