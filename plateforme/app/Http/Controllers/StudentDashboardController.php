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
        /* $souscriptionActive = Souscription::where('user_id', $user->id)
                                          ->where('date_fin', '>=', Carbon::now())
                                          ->with('abonnement') // Charger la relation 'abonnement'
                                          ->get(); */

        // Si aucune souscription active n'est trouvée

        // Récupérer la souscription active de l'utilisateur avec l'abonnement associé
        $souscriptionActive = Souscription::where('user_id', $user->id)
            ->where('date_fin', '>=', Carbon::now())
            ->with('abonnement') // Charger la relation 'abonnement'
            ->get();


        if (!$souscriptionActive) {
            return dd('error', 'Votre abonnement est épuisé. Veuillez souscrire à un nouvel abonnement pour accéder à ce contenu.');
        }

        $tousLesAbonnements = abonnement::all();

        // Récupérer la souscription active de l'utilisateur avec l'abonnement associé
        $souscriptionActives = Souscription::where('user_id', $user->id)
            ->where('date_fin', '>=', Carbon::now())
            ->with('abonnement') // Charger la relation 'abonnement'
            ->get();


        // 3. Fusionner les deux collections et marquer les abonnements payés
        $testTypes = $tousLesAbonnements->map(function ($abonnement) use ($souscriptionActives) {
            $abonnement->paye = $souscriptionActives->contains(function ($souscription) use ($abonnement) {
                return $souscription->abonnement_id == $abonnement->id;
            });
            return $abonnement;
        });


        // 1. Récupération des niveaux par test
        $userLevels = [];


        foreach ($testTypes as $testType) {
            // Récupérer le TestType en fonction de l'examen
            $niveau = Niveau::where('user_id', $user->id)
                ->where('test_type', $testType->id)
                ->first();
            $key = $testType->examen . '_' . $testType->nom_du_plan;

            $userLevels[$key] = $niveau ? [
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
            ->take(3)
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
                    'details_route' => $test->details_route,
                    'refaire_route' => $test->refaire_route,
                ];
            });



        $learningGoal = [
            'target_level' => 'C1',
            'current_progress' => 65,
            'target_date' => Carbon::now()->addMonths(3)
        ];

        $testTypes1 = abonnement::all();

        return view('client.dashboard', compact(
            'userLevels',
            'completedTests',
            'learningGoal',
            'testTypes',
            'testTypes1',
            'souscriptionsPayees',
            'souscriptionActive',
            'niveau'
        ));
    }


    public function verifierAcces()
    {
        $testsGratuits = HistoriqueTest::where('user_id', Auth::id())
            ->where('is_free', true)
            ->count();

        if ($testsGratuits >= 5) {
            return response()->json([
                'has_free_tests' => false,
                'nombre' => $testsGratuits
            ]);
        }

        return response()->json([
            'has_free_tests' => true
        ]);
    }


}
