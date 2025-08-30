<?php

// app/Http/Controllers/ExpressionEcriteController.php

namespace App\Http\Controllers;

use App\Models\ComprehensionEcrite;
use App\Models\ComprehensionEcriteResultat;
use App\Models\ComprehensionOraleReponse;
use App\Models\ExpressionEcriteReponse;
use App\Models\ExpressionOraleReponse;
use App\Models\Niveau;
use App\Models\Souscription;
use App\Models\abonnement;
use App\Models\TestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class ComprehensionEcriteController extends Controller
{
    public function index(Request $request)
    {
        $questions = ComprehensionEcrite::orderBy('numero')->get();
        $test_type = abonnement::where('examen', 'TCF')->firstOrFail();

        if ($questions->isEmpty()) {
            return view('test.indisponible', [
                'test' => 'Comprehension Ecrite'
            ]);
        }


    return view('test.comprehension_ecrite', compact('questions','test_type'));
    }

    public function enregistrerReponse(Request $request)
    {
        $userId = Auth::id();
        if (!$userId)
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);

        $question = ComprehensionEcrite::findOrFail($request->question_id);
        $reponseUtilisateur = strtoupper($request->reponse);
        $isCorrect = $reponseUtilisateur === strtoupper($question->reponse);

       
        $typeTest = $typeTest['examen'] ?? 'INCONNU'; // tu gardes que "TCF" par ex.
 
  
        DB::table('comprehension_ecrite_user_answers')->updateOrInsert(
            [
                'user_id' => $userId,
                'question_id' => $question->id
            ],
            [
                'reponse' => $reponseUtilisateur,
                'is_correct' => $isCorrect,
                'test_type' =>  $typeTest,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        return response()->json([
            'success' => true,
            'correct' => $isCorrect
        ]);
    }

    public function enregistrerResultatFinal()
    {
        $userId = Auth::id();
        if (!$userId)
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);

        $reponses = DB::table('comprehension_ecrite_user_answers')
            ->where('user_id', $userId)
            ->get();

        $score = $reponses->where('is_correct', true)->count();
        $total = $reponses->count();

        DB::table('comprehension_ecrite_resultats')->insert([
            'user_id' => $userId,
            'score' => $score,
            'total' => $total,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
                // récupérer test_type_id par exemple 'tcf_canada'
        $testType = abonnement::where('examen', 'TCF')->firstOrFail();

        // calculer le niveau pour la compétence "comprehension_ecrite"
        $niveauComp = $this->determineNiveau($score);

        // mettre à jour ou créer la ligne niveau de l'utilisateur pour ce test
        Niveau::updateOrCreate(
            [
                'user_id' => $userId,
                'test_type' => $testType->id,
            ],
            [
                'comprehension_ecrite' => $niveauComp,
                // ne touche pas aux autres colonnes compétences
                'updated_at' => now(),
            ]
        );

                    // Vérifier si l'utilisateur a un abonnement valide
            $hasActiveSubscription = Souscription::where('user_id', $userId)
                ->where('date_debut', '<=', now())
                ->where('date_fin', '>=', now())
                ->exists();

            // Vérifier le nombre de tests gratuits déjà utilisés
            $freeTestsUsed = DB::table('historique_tests')
                ->where('user_id', $userId)
                ->where('is_free', true)
                ->count();

            $isFree = false;

            // Si pas d'abonnement actif ET moins de 5 tests gratuits utilisés
            if (!$hasActiveSubscription && $freeTestsUsed < 5) {
                $isFree = true;
            }

            // Insertion dans historique_tests
        DB::table('historique_tests')->insert([
            'user_id' => $userId,
            'is_free' => $isFree, // On marque si c'est un test gratuit
            'test_type' => 'TCF', // champ string, donc on met le nom
            'skill' => 'comprehension_ecrite',
            'score' => $score,
            'niveau' => $niveauComp,
            'duration' => null, // ou tu peux calculer si tu veux (ex: fin - début)
            'details_route'=> 'test.comprehension_ecrite_resultat',
            'refaire_route'=> 'comprehension_ecrite.reinitialiser',
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        


        return response()->json(['message' => 'Résultat enregistré', 'score' => $score, 'total' => $total]);
    }
    
  private function determineNiveau(float $score): string
    {
        return match (true) {
            $score >= 450 => 'C2',
            $score >= 350 => 'C1',
            $score >= 250 => 'B2',
            $score >= 150 => 'B1',
            $score >= 75 => 'A2',
            default => 'A1'
        };
    }

    public function reinitialiserTest()
{
    $user = Auth::user();
    
    // Supprimer toutes les réponses de l'utilisateur pour ce test
    ComprehensionEcriteResultat::where('user_id', $user->id)->delete();

    // Rediriger vers la page du test
    return redirect()->route('test.comprehension_ecrite');
}

    public function resultat()
    {
        $user = Auth::user();
        if (!$user)
            abort(403, 'Non authentifié');

        $reponses = DB::table('comprehension_ecrite_user_answers')
            ->join('comprehension_ecrite', 'comprehension_ecrite.id', '=', 'comprehension_ecrite_user_answers.question_id')
            ->where('comprehension_ecrite_user_answers.user_id', $user->id)
            ->select(
                'comprehension_ecrite.numero',
                'comprehension_ecrite.situation',
                'comprehension_ecrite.question',
                'comprehension_ecrite.reponse as bonne_reponse',
                'comprehension_ecrite_user_answers.reponse as reponse_utilisateur',
                'comprehension_ecrite_user_answers.is_correct'
            )
            ->orderBy('comprehension_ecrite.numero')
            ->get();

        $score = $reponses->where('is_correct', true)->count();
        $total = $reponses->count();

        DB::table('comprehension_ecrite_resultats')->insert([
            'user_id' => $user->id,
            'score' => $score,
            'total' => $total,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

         $historique = DB::table('comprehension_ecrite_resultats')
            ->where('user_id', $user)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($item) {
                $item->created_at = \Carbon\Carbon::parse($item->created_at);
                return $item;
            });

            $totalPoints = 0;
            $bonnesReponses = 0;
            $mauvaisesReponses = 0;

            foreach ($reponses as $reponse) {
                if ($reponse->is_correct) {
                    $totalPoints += 3;
                    $bonnesReponses++;
                } else {
                    $totalPoints -= 2;
                    $mauvaisesReponses++;
                }
            }

            // Détermination du niveau
            if ($totalPoints >= 450) {
                $niveau = 'C2';
            } elseif ($totalPoints >= 350) {
                $niveau = 'C1';
            } elseif ($totalPoints >= 250) {
                $niveau = 'B2';
            } elseif ($totalPoints >= 150) {
                $niveau = 'B1';
            } elseif ($totalPoints >= 75) {
                $niveau = 'A2';
            } else {
                $niveau = 'A1';
            }
        
        $route='test.comprehension_ecrite';

        $testTypes = abonnement::all();

        $userLevels = [];
        foreach ($testTypes as $testType) {
            // Récupérer le niveau global pour ce test (en tenant compte des compétences)
            $niveau = Niveau::where('user_id', $user->id)
                ->where('test_type', $testType->id)
                ->first();

            $userLevels[$testType->nom] = $niveau ? [
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
        $ceTestType = abonnement::where('examen', 'TCF')->first();
        if ($ceTestType) {
            foreach (ComprehensionEcriteResultat::where('user_id', $user->id)
                ->latest()->take(5)->get() as $reponse) {
                $completedTests[] = [
                    'id' => $reponse->id,
                    'test_type' => $ceTestType->label,
                    'skill' => 'Compréhension Écrite',
                    'date' => $reponse->created_at,
                    'duration' => 360,
                    'score' => $reponse->score,
                    'max_score' => 699,
                    'level' => $reponse->niveau,
                    'correct_answers' => $reponse->nb_bonnes_reponses,
                    'total_questions' => $reponse->nb_total_questions,
                ];
            }
        }

        // Même principe pour Compréhension Orale
        $coTestType = abonnement::where('examen', 'TCF')->first();
        if ($coTestType) {
            foreach (ComprehensionOraleReponse::where('user_id', $user->id)
                ->latest()->take(5)->get() as $reponse) {
                $completedTests[] = [
                    'id' => $reponse->id,
                    'test_type' => $coTestType->label,
                    'skill' => 'Compréhension Orale',
                    'date' => $reponse->created_at,
                    'duration' => 160,
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

        return view('test.comprehension_ecrite_resultat', [
            'titre' => 'TCF CANADA, Compréhension écrite',
            'reponses' => $reponses,
            'score' => $score,
            'total' => $total,
            'historique' => $historique,
            'totalPoints' => $totalPoints,
            'bonnesReponses' => $bonnesReponses,
            'mauvaisesReponses' => $mauvaisesReponses,
            'niveau' => $niveau,
            'route'=> $route,
            'userLevels' => $userLevels,
            'completedTests' => $completedTests,
            'learningGoal' => $learningGoal,
            'testTypes' => $testTypes,
        ]);
    }

    
}
