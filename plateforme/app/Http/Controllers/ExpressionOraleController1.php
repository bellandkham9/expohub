<?php

namespace App\Http\Controllers;

use App\Models\abonnement;
use App\Models\ExpressionOrale;
use App\Models\ExpressionOraleReponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Niveau;
use Illuminate\Support\Facades\DB;
use App\Models\Souscription;
use Illuminate\Support\Carbon;
use App\Models\ComprehensionEcrite;
use App\Models\ComprehensionEcriteResultat;
use App\Models\ComprehensionOraleReponse;
use App\Models\ExpressionEcriteReponse;

class ExpressionOraleController1 extends Controller
{
    public function afficherTest()
    {
        $user = auth()->user();

        $taches = collect();

    foreach ([1, 2, 3] as $numero) {
        $tache = ExpressionOrale::where('numero', $numero)->inRandomOrder()->first();

        if ($tache) {
            $taches->push($tache);
        }
    }

    

        $test_type = abonnement::where('examen', 'TCF')->firstOrFail();

        if ($taches->isEmpty()) {
            return back()->with('error', 'Aucune tâche disponible pour le moment.');
        }

        if ($taches->isEmpty()) {
            return view('test.indisponible', [
                'test' => 'Comprehension Ecrite'
            ]);
        }
        
        $tacheActive = $taches->first();

        $reponses = ExpressionOraleReponse::where('user_id', $user->id)
            ->where('expression_orale_id', $tacheActive->id)
            ->get();

        return view('test.expression_orale1', compact('taches', 'tacheActive', 'reponses','test_type'));
    }

    public function repondre(Request $request)
{
    try {
        $user = Auth::user();
        $testType = abonnement::where('examen', 'TCF')->firstOrFail();

        $request->validate([
            'expression_orale_id' => 'required|exists:expression_orales,id',
            'audio_eleve' => 'required|string',
            'transcription_eleve' => 'required', // on accepte tout contenu
            'texte_ia' => 'required|string',
            'audio_ia' => 'required|string',
            'score' => 'nullable|numeric',
            'test_type' => 'nullable', // plus besoin de string
        ]);

        // Nettoyage de la transcription si c'est un JSON d'erreur
        $transcription = $request->transcription_eleve;
        if ($json = json_decode($transcription, true)) {
            if (isset($json['error'])) {
                $transcription = "Erreur de transcription : " . ($json['error']['message'] ?? 'Problème inconnu');
            }
        }

        $reponse = ExpressionOraleReponse::updateOrCreate(
            [
                'user_id' => $user->id,
                'expression_orale_id' => $request->expression_orale_id
            ],
            [
                'audio_eleve' => $request->audio_eleve,
                'transcription_eleve' => $transcription,
                'texte_ia' => $request->texte_ia,
                'audio_ia' => $request->audio_ia,
                'score' => $request->score ?? 0,
                'test_type' => $testType->id,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Réponse enregistrée avec succès',
            'reponse' => $reponse
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur serveur: ' . $e->getMessage()
        ], 500);
    }
}

public function handleMessage(Request $request)
{
    try {
        // Cas prompt initial
        if ($request->has('prompt_initial')) {
            $prompt = $request->input('prompt_initial');
            $texteIA = $this->genererTexteAvecIA($prompt);
            $audioIA = $this->convertirTexteEnAudio($texteIA);

            return response()->json([
                'ia_response' => $texteIA,
                'audio_url' => $audioIA,
            ]);
        }

        // Cas envoi audio élève
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $nomFichier = 'eleve_' . Str::random(10) . '.mp3';
            $chemin = $audio->storeAs('public/audios/eleves', $nomFichier);
            $urlAudio = 'audios/eleves/' . $nomFichier;

                        // Transcription
            $transcription = $this->transcrireAvecWhisper($audio);

            // Si c’est un JSON d’erreur, on le convertit en texte lisible
            if ($json = json_decode($transcription, true)) {
                if (isset($json['error'])) {
                    $transcription = "Erreur de transcription : " . ($json['error']['message'] ?? 'Problème inconnu');
                }
            }

            // Génération IA et audio
            $texteIA = $this->genererTexteAvecIA($transcription);
            $audioIA = $this->convertirTexteEnAudio($texteIA);
            $score = $this->evaluerExpressionOrale($transcription);

            return response()->json([
                'transcription' => $transcription,   // -> transcription_eleve
                'ia_response' => $texteIA,            // -> texte_ia
                'audio_path' => $urlAudio,            // -> audio_eleve
                'audio_ia_path' => $audioIA,          // -> audio_ia
                'score' => $score,
            ]);
        }

        return response()->json(['error' => 'Requête invalide'], 400);

    } catch (\Exception $e) {
        \Log::error("Erreur dans handleMessage(): " . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'userId' => Auth::id(),
        ]);

        return response()->json(['error' => 'Erreur serveur'], 500);
    }
}


    private function evaluerExpressionOrale(string $texte): int
{
    // Appel à ton API IA (OpenAI, DeepSeek, etc.)
    $prompt = "Évalue le niveau de cette réponse orale (0 à 100) selon la grammaire, fluidité, vocabulaire :\n\n\"$texte\"\n\nScore (un seul chiffre entre 0 et 100) :";

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
    ])->post(env('OPENROUTER_API_URL'), [
        'model' => 'deepseek/deepseek-chat',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.3,
        'max_tokens' => 400,
    ]);

    $textResponse = $response->json()['choices'][0]['message']['content'];

    // Extraire le score (tu peux améliorer cette extraction)
    preg_match('/\d{1,3}/', $textResponse, $matches);
    return isset($matches[0]) ? min(100, max(0, intval($matches[0]))) : 0;
}


    private function transcrireAvecWhisper($audio)
    {


        $response = Http::timeout(60)
            ->withToken(env('OPENAI_API_KEY'))
            ->attach(
                'file',
                File::get($audio),
                $audio->getClientOriginalName()
            )
            ->post('https://api.openai.com/v1/audio/transcriptions', [
                'model' => 'whisper-1',
                'language' => 'fr',
                'response_format' => 'text',
            ]);



        return $response->body();
    }

    private function genererTexteAvecIA($prompt)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('OPENROUTER_API_URL'), [
                    'model' => 'deepseek/deepseek-chat',
                    'messages' => [
                        ['role' => 'system', 'content' => "Tu es un assistant pour le test d'expression orale du TCF."],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 400,
                ]);

        return $response->json('choices.0.message.content');
    }

    private function convertirTexteEnAudio($texte)
    {
        $response = Http::timeout(60)
            ->withHeaders([
                'xi-api-key' => env('ELEVENLABS_API_KEY'),
                'Content-Type' => 'application/json',
            ])
            ->post("https://elevenlabs.io/v1/text-to-speech/EXAVITQu4vr4xnSDxMaL", [
                'text' => $texte,
                'voice_settings' => [
                    'stability' => 0.5,
                    'similarity_boost' => 0.75,
                ],
            ]);

        if (!$response->ok()) {
            throw new \Exception("Erreur lors de la conversion en audio : " . $response->body());
        }

        $nomFichier = 'ia_' . Str::random(10) . '.mp3';
        $cheminFichier = storage_path("app/public/audios/ia/{$nomFichier}");
        File::put($cheminFichier, $response->body());

        return Storage::url("public/audios/ia/{$nomFichier}");
    }

    public function changerTache(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|integer|min:1|max:3',
            'tache_id' => 'required|integer|exists:expression_orales,id'
        ], [
            'numero.required' => 'Le numéro de tâche est requis',
            'numero.integer' => 'Le numéro doit être un entier',
            'numero.min' => 'Le numéro doit être au moins 1',
            'numero.max' => 'Le numéro doit être au plus 3',
            'tache_id.required' => 'ID de tâche requis',
            'tache_id.exists' => 'Tâche non trouvée'
        ]);

        try {
            $tache = ExpressionOrale::findOrFail($validated['tache_id']);

            // Verify task number matches the ID
            if ($tache->numero != $validated['numero']) {
                return response()->json([
                    'success' => false,
                    'error' => 'Incohérence dans les données de tâche'
                ], 422);
            }

            $reponse = ExpressionOraleReponse::firstWhere([
                'user_id' => Auth::id(),
                'expression_orale_id' => $tache->id
            ]);

            return response()->json([
                'success' => true,
                'tache' => [
                    'id' => $tache->id,
                    'numero' => $tache->numero,
                    'contexte' => $tache->contexte,
                    'consigne' => $tache->consigne,
                    'duree' => $tache->duree
                ],
                'reponse' => $reponse?->reponse,
                'duree_restante' => $reponse?->temps_restant ?? $tache->duree
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur serveur',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

     private function determineNiveau(float $score): string
{
    return match (true) {
        $score >= 600 && $score <= 699 => 'C2', // Utilisateur expérimenté maîtrise, proche du bilinguisme
        $score >= 500 && $score <= 599 => 'C1', // Utilisateur expérimenté autonome, bonne compréhension des textes et dialogues complexes
        $score >= 400 && $score <= 499 => 'B2', // Utilisateur indépendant avancé, conversation spontanée sur divers sujets
        $score >= 300 && $score <= 399 => 'B1', // Utilisateur indépendant, autonome lors d'un voyage ou au travail
        $score >= 200 && $score <= 299 => 'A2', // Utilisateur élémentaire intermédiaire, capacité à parler de l'environnement quotidien
        $score >= 100 && $score <= 199 => 'A1', // Utilisateur élémentaire débutant, phrases simples liées à la vie quotidienne
        default => 'A0', // (0-99 points) : Débutant, reconnaissance de quelques mots
    };
}

    private function generateGlobalComment(float $score): string
    {
        return match (true) {
            $score >= 450 => 'Excellent travail ! Votre maîtrise de la langue est remarquable.',
            $score >= 350 => 'Très bon travail avec quelques erreurs mineures à perfectionner.',
            $score >= 250 => 'Bon niveau global avec des axes d\'amélioration identifiés.',
            $score >= 150 => 'Niveau intermédiaire, continuez à pratiquer régulièrement.',
            default => 'Des progrès sont nécessaires, révisez les bases et pratiquez davantage.'
        };
    }

    public function reinitialiserTest()
    {
        $user = Auth::user();
        
        // Supprimer toutes les réponses de l'utilisateur pour ce test
        ExpressionOraleReponse::where('user_id', $user->id)->delete();

        // Rediriger vers la page du test
        return redirect()->route('test.expression_orale');
    }


      public function enregistrerResultatFinal(Request $request)
        {
            $validated = $request->validate([
            'test_type' => 'required|string' // test_type requis ici
        ]);

        $userId = Auth::id();
        if (!$userId)
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);


        $reponses = ExpressionOraleReponse::where('user_id', $userId)
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
                'expression_orale' => $niveau, // ✅ correction ici
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
            'skill' => 'expression_orale',
            'score' => $scoreTotal,
            'niveau' => $niveau,
            'duration' => null, // ou tu peux calculer si tu veux (ex: fin - début)
            'details_route'=> 'test.expression_orale_resultat',
            'refaire_route'=> 'expression_orale.reinitialiser',
            'completed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return response()->json(['message' => 'Résultat enregistré', 'score' => $scoreTotal]);
    }

    
    public function afficherResultat()
    {
        $user = Auth::user();

        $reponses = ExpressionOraleReponse::with('question')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        $noteTotale = $reponses->sum('score');

        $niveau = $this->determineNiveau($noteTotale);
        // Ajoutez cette ligne pour récupérer les tâches
        $taches = ExpressionOrale::orderBy('numero')->take(3)->get();

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

             // Vérifier si l’utilisateur a souscrit et payé cet abonnement
            $souscriptionsPayees[$testType->examen] = Souscription::where('user_id', $user->id)
                ->where('paye', true)
                ->where('abonnement_id', $testType->id)
                ->first();
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

         
        return view('test.expression_orale_resultat', [
            'titre' => 'TCF CANADA, Expression écrite',
            'niveau' => $niveau,
            'note' => $noteTotale,
            'commentaire' => $this->generateGlobalComment($noteTotale),
            'reponses' => $reponses,
            'taches' => $taches, // Ajout de la variable taches
            'route' => 'test.expression_orale',
            'userLevels' => $userLevels,
            'completedTests' => $completedTests,
            'learningGoal' => $learningGoal,
            'testTypes' => $testTypes,
            'souscriptionsPayees'=> $souscriptionsPayees
        ]);
    }

}
