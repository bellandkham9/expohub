<?php

namespace App\Http\Controllers;

use App\Models\ExpressionEcrite;
use App\Models\ExpressionEcriteReponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ComprehensionEcriteResultat;
use App\Models\ComprehensionOraleReponse;
use App\Models\ExpressionOraleReponse;
use App\Models\Niveau;
use App\Models\abonnement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Souscription;


class ExpressionEcriteController extends Controller
{
    public function afficherTest()
    {
       
        $user = Auth::user();

        $taches = collect();

        foreach ([1, 2, 3] as $numero) {
            $tache = ExpressionEcrite::where('numero_tache', $numero)->inRandomOrder()->first();

            if ($tache) {
                $taches->push($tache);
            }
        }

        $test_type = abonnement::where('examen', 'TCF')->firstOrFail();

        if ($taches->isEmpty()) {
            return back()->with('error', 'Aucune tâche disponible pour le moment.');
        }

        return view('test.expression_ecrite', [
            'taches' => $taches,
            'tacheActive' => $taches->first(),
            'test_type'=> $test_type->examen,
            'reponses' => ExpressionEcriteReponse::where('user_id', $user->id)
                ->where('expression_ecrite_id', $taches->first()->id)
                ->get()
        ]);
    }

    public function changerTache(Request $request)
    {
        $request->validate([
            'numero_tache' => 'required|integer|min:1|max:3'
        ]);

        $tache = ExpressionEcrite::where('numero_tache', $request->numero_tache)->first();

        if (!$tache) {
            return response()->json(['error' => 'Tâche non trouvée'], 404);
        }

        $reponse = ExpressionEcriteReponse::where('user_id', Auth::id())
            ->where('expression_ecrite_id', $tache->id)
            ->first();

        return response()->json([
            'tache' => $tache,
            'reponse' => $reponse?->reponse,
        ]);
    }


    private function fallbackEvaluation(string $reponse): array
{
    try {
        $prompt = "Voici une réponse d'élève à une tâche d'expression écrite. Attribue une note sur 20 et donne un commentaire constructif.\n\nRéponse :\n" . $reponse;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'deepseek/deepseek-r1-0528:free',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.4,
        ]);

        $texte = $response->json('choices.0.message.content');

        // Extraction de la note (regex simple)
        preg_match('/([0-9]{1,2})\s*\/\s*20/', $texte, $matches);
        $note = isset($matches[1]) ? intval($matches[1]) : 10;

        return [
            'note' => $note,
            'commentaire' => $texte,
        ];
    } catch (\Throwable $e) {
        // Si même ça échoue, on renvoie une note fixe
        return [
            'note' => 10,
            'commentaire' => "L’évaluation IA a échoué deux fois. Note par défaut attribuée.",
        ];
    }
    }



    public function submitReponse(Request $request)
{
    $validated = $request->validate([
        'reponse' => [
            'required',
            'string',
            'max:5000',
            function ($attribute, $value, $fail) {
                if (str_word_count($value) < 10) {
                    $fail('Votre réponse doit contenir au moins 10 mots.');
                }
            }
        ],
        'expression_ecrite_id' => 'required|exists:expression_ecrites,id',
        'test_type' => 'required|string' // test_type requis ici
    ]);

    $user = Auth::user();
    $question = ExpressionEcrite::findOrFail($validated['expression_ecrite_id']);

    $existingResponse = ExpressionEcriteReponse::where('user_id', $user->id)
        ->where('expression_ecrite_id', $question->id)
        ->first();

    if ($existingResponse) {
        return response()->json([
            'error' => 'Vous avez déjà soumis une réponse pour cette tâche.',
            'existing_score' => $existingResponse->score,
            'existing_comment' => $existingResponse->commentaire
        ], 422);
    }

    $promptIA = $this->generateIAPrompt($question, $validated['reponse']);
    if (strlen($promptIA) > 6000) {
        $promptIA = $this->generateShortIAPrompt($question, $validated['reponse'] ?? '');
    }

    

    DB::beginTransaction();
    try {
        $evaluation = $this->fallbackEvaluation($validated['reponse']);
        $testType = abonnement::where('examen', 'TCF')->firstOrFail();
        try {
            $iaResponse = $this->callIAApi($promptIA);
            $evaluation = $this->parseIAResponse($iaResponse);
        } catch (\Exception $e) {
            Log::warning('Échec appel IA: ' . $e->getMessage());
        }

        ExpressionEcriteReponse::create([
            'user_id' => $user->id,
            'expression_ecrite_id' => $question->id,
            'reponse' => $validated['reponse'],
            'prompt' => $promptIA,
            'score' => $evaluation['note'],
            'commentaire' => $evaluation['commentaire'],
            'test_type' => $testType->id,
        ]);

        // ✅ Maintenant on calcule et enregistre le score final
        $reponses = ExpressionEcriteReponse::where('user_id', $user->id)
            ->where('test_type', $validated['test_type'])
            ->get();

        $scoreTotal = $reponses->sum('score');
        $nombreReponses = $reponses->count();
        $niveau = $this->determineNiveau($scoreTotal);



        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Réponse enregistrée et score final mis à jour.',
            'score_question' => $evaluation['note'],
            'commentaire' => $evaluation['commentaire'],
            'score_total' => $scoreTotal,
            'total_reponses' => $nombreReponses,
            'niveau' => $niveau,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Erreur critique: ' . $e->getMessage());

        return response()->json([
            'error' => 'Erreur serveur lors de l\'enregistrement.',
            'retry_possible' => true
        ], 500);
    }
    }


    public function afficherResultat()
    {
        $user = Auth::user();
        
        $reponses = ExpressionEcriteReponse::with('question')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        $noteTotale = $reponses->sum('score');

        $niveau = $this->determineNiveau($noteTotale);
         // Ajoutez cette ligne pour récupérer les tâches
        $taches = ExpressionEcrite::orderBy('numero_tache')->take(3)->get();
        
        $route='test.expression_ecrite';

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
        $ceTestType = abonnement::where('examen', 'TCF')->firstOrFail();
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
        $coTestType = abonnement::where('examen', 'TCF')->firstOrFail();
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
        
        return view('test.expression_ecrite_resultat', [
            'titre' => 'TCF CANADA, Expression écrite',
            'niveau' => $niveau,
            'note' => $noteTotale,
            'commentaire' => $this->generateGlobalComment($noteTotale),
            'reponses' => $reponses,
            'taches' => $taches, // Ajout de la variable taches
            'route' =>$route,
            'userLevels' => $userLevels,
            'completedTests' => $completedTests,
            'learningGoal' => $learningGoal,
            'testTypes' => $testTypes,
        ]);
    }
    
    public function reinitialiserTest()
    {
        $user = Auth::user();
        
        // Supprimer toutes les réponses de l'utilisateur pour ce test
        ExpressionEcriteReponse::where('user_id', $user->id)->delete();

        // Rediriger vers la page du test
        return redirect()->route('test.expression_ecrite');
    }
  
    private function generateIAPrompt($question, $reponse): string
    {
        return "En tant que correcteur TCF, évalue cette réponse sur 20 selon ces critères :
        - Adéquation à la consigne (5 pts)
        - Correction linguistique (5 pts)
        - Richesse du vocabulaire (5 pts)
        - Cohérence et structure (5 pts)

        Consigne : {$question->consigne}
        Réponse : {$reponse}

        Format de réponse strict :
        Note: X/20
        Commentaire: [votre analyse détaillée]";
    }

   private function callIAApi(string $prompt): string
{
    $response = Http::timeout(60)
        ->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('OPENROUTER_API_URL'), [
                    'model' => 'deepseek/deepseek-r1-0528:free',
            'messages' => [
                ['role' => 'system', 'content' => "Tu es un correcteur pour le test d'expression écrite du TCF."],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]);

    if (!$response->successful()) {
        Log::error('Erreur API OpenRouter', [
            'status' => $response->status(),
            'response' => $response->body()
        ]);
        throw new \Exception("Erreur API OpenRouter: " . $response->body());
    }

    return $response->json()['choices'][0]['message']['content'];
}

    private function parseIAResponse(string $response): array
    {
        preg_match('/Note\s*:\s*(\d+)[\/20]*/i', $response, $noteMatch);
        preg_match('/Commentaire\s*:\s*(.+)/is', $response, $commentaireMatch);

        return [
            'note' => $noteMatch[1] ?? 0,
            'commentaire' => trim($commentaireMatch[1] ?? 'Pas de commentaire disponible.'),
        ];
    }

    private function determineNiveau(float $score): string
    {
        return match(true) {
            $score >= 450 => 'C2',
            $score >= 350 => 'C1',
            $score >= 250 => 'B2',
            $score >= 150 => 'B1',
            $score >= 75 => 'A2',
            default => 'A1'
        };
    }


    private function generateGlobalComment(float $score): string
    {
        return match(true) {
            $score >= 450 => 'Excellent travail ! Votre maîtrise de la langue est remarquable.',
            $score >= 350 => 'Très bon travail avec quelques erreurs mineures à perfectionner.',
            $score >= 250 => 'Bon niveau global avec des axes d\'amélioration identifiés.',
            $score >= 150 => 'Niveau intermédiaire, continuez à pratiquer régulièrement.',
            default => 'Des progrès sont nécessaires, révisez les bases et pratiquez davantage.'
        };
    }


  public function enregistrerResultatFinal(Request $request)
{
    $validated = $request->validate([
        'test_type' => 'required|string'
    ]);

    $userId = Auth::id();
    if (!$userId) {
        return response()->json(['error' => 'Utilisateur non authentifié'], 401);
    }

    $reponses = ExpressionEcriteReponse::where('user_id', $userId)
        ->where('test_type', $validated['test_type'])
        ->get();

    $scoreTotal = $reponses->sum('score');
    $niveau = $this->determineNiveau($scoreTotal);

    $testType = abonnement::where('examen', 'TCF')->firstOrFail();

    Niveau::updateOrCreate(
        [
            'user_id' => $userId,
            'test_type' => $testType->id,
        ],
        [
            'expression_ecrite' => $niveau,
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
        'skill' => 'expression_ecrite',
        'score' => $scoreTotal,
        'niveau' => $niveau,
        'duration' => null, // ou tu peux calculer si tu veux (ex: fin - début)
        'details_route'=> 'test.expression_ecrite_resultat',
        'refaire_route'=> 'expression_ecrite.reinitialiser',
        'completed_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);


    return response()->json(['message' => 'Résultat enregistré', 'score' => $scoreTotal]);
}




}