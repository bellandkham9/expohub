<?php

namespace App\Http\Controllers;

use App\Models\abonnement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoriqueTest;
use Illuminate\Support\Carbon;
use App\Models\Niveau;
use App\Models\TestType;
use App\Models\ComprehensionEcriteResultat;
use App\Models\ComprehensionOraleReponse;
use App\Models\ExpressionEcriteReponse;
use App\Models\ExpressionOraleReponse;
use App\Models\Souscription;

class HistoriqueTestController extends Controller
{
    public function index()
    {
       $user = Auth::user();
        $testTypes = abonnement::all();

        // 1. Récupération des niveaux par test
        $userLevels = [];
        foreach ($testTypes as $testType) {
            $niveau = Niveau::where('user_id', $user->id)
                ->where('test_type', $testType->id)
                ->first();

            $userLevels[$testType->examen] = $niveau ? [
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

            // Vérifier si l’utilisateur a souscrit et payé cet abonnement
            $souscriptionsPayees[$testType->examen] = Souscription::where('user_id', $user->id)
                ->where('paye', true)
                ->where('abonnement_id', $testType->id)
                ->first();
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


        return view('client.history', compact('userLevels',
            'completedTests',
            'learningGoal',
            'testTypes',
            'souscriptionsPayees'));
    }
}
