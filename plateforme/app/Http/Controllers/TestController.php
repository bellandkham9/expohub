<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\TestType;
use App\Models\abonnement;
use App\Models\Souscription;
use App\Models\ComprehensionEcriteResultat;
use App\Models\ComprehensionOraleReponse;
use App\Models\ExpressionEcriteReponse;
use App\Models\ExpressionOraleReponse;
use App\Models\Niveau;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
  
     public function choixTest()
    {
        $user = Auth::user();

        // Récupérer tous les types de test (ex : TCF Canada, TCF Québec, ...)
        
        
        $tousLesAbonnements = abonnement::all();

        // Récupérer la souscription active de l'utilisateur avec l'abonnement associé
        $souscriptionActives = Souscription::where('user_id', $user->id)
                                          ->where('date_fin', '>=', Carbon::now())
                                          ->with('abonnement') // Charger la relation 'abonnement'
                                          ->get();


          // 3. Fusionner les deux collections et marquer les abonnements payés
        $testTypes = $tousLesAbonnements->map(function ($abonnement) use ($souscriptionActives) {
            // Ajouter une nouvelle propriété 'paye' à chaque objet Abonnement
            $abonnement->paye = $souscriptionActives->contains($abonnement->id);

            return $abonnement;
        });


        $userLevels = [];
        foreach ($testTypes as $testType) {
            // Récupérer le niveau global pour ce test (en tenant compte des compétences)
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
        }

        // Récupérer les 5 derniers tests complétés par type et compétence
        $completedTests = [];

        // Exemple pour Comprehension Ecrite, filtrer par test_type_code 'tcf_canada' par ex.
        $ceTestType = TestType::where('examen', 'TCF')->first();
        if ($ceTestType) {
            foreach (ComprehensionEcriteResultat::where('user_id', $user->id)
                ->latest()->take(5)->get() as $reponse) {
                $completedTests[] = [
                    'id' => $reponse->id,
                    'test_type' => $ceTestType->label,
                    'skill' => 'Compréhension Écrite',
                    'date' => $reponse->created_at,
                    'duration' => 60,
                    'score' => $reponse->score,
                    'max_score' => 699,
                    'level' => $reponse->niveau,
                    'correct_answers' => $reponse->nb_bonnes_reponses,
                    'total_questions' => $reponse->nb_total_questions,
                ];
            }
        }

        // Même principe pour Compréhension Orale
        $coTestType = TestType::where('examen', 'TCF')->first();
        if ($coTestType) {
            foreach (ComprehensionOraleReponse::where('user_id', $user->id)
                ->latest()->take(5)->get() as $reponse) {
                $completedTests[] = [
                    'id' => $reponse->id,
                    'test_type' => $coTestType->label,
                    'skill' => 'Compréhension Orale',
                    'date' => $reponse->created_at,
                    'duration' => 30,
                    'score' => $reponse->score,
                    'max_score' => 699,
                    'level' => $reponse->niveau,
                    'correct_answers' => $reponse->nb_bonnes_reponses,
                    'total_questions' => $reponse->nb_total_questions,
                ];
            }
        }

        // Expression Ecrite (TCF Canada)
        if ($ceTestType) {
            foreach (ExpressionEcriteReponse::where('user_id', $user->id)
                ->latest()->take(5)->get() as $reponse) {
                $completedTests[] = [
                    'id' => $reponse->id,
                    'test_type' => $ceTestType->label,
                    'skill' => 'Expression Écrite',
                    'date' => $reponse->created_at,
                    'duration' => 60,
                    'score' => $reponse->score,
                    'max_score' => 699,
                    'level' => $reponse->niveau,
                    'correct_answers' => null,
                    'total_questions' => null,
                ];
            }
        }

        // Expression Orale (TCF Québec)
        if ($coTestType) {
            foreach (ExpressionOraleReponse::where('user_id', $user->id)
                ->latest()->take(5)->get() as $reponse) {
                $completedTests[] = [
                    'id' => $reponse->id,
                    'test_type' => $coTestType->label,
                    'skill' => 'Expression Orale',
                    'date' => $reponse->created_at,
                    'duration' => 15,
                    'score' => $reponse->score,
                    'max_score' => 699,
                    'level' => $reponse->niveau,
                    'correct_answers' => null,
                    'total_questions' => null,
                ];
            }
        }

        $learningGoal = [
            'target_level' => 'C1',
            'current_progress' => 65,
            'target_date' => Carbon::now()->addMonths(3)
        ];

        return view('test.choix_test', compact('userLevels', 'completedTests', 'learningGoal','testTypes'));
    }
}
