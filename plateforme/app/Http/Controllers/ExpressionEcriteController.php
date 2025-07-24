<?php

namespace App\Http\Controllers;

use App\Models\ExpressionEcrite;
use App\Models\ExpressionEcriteReponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ExpressionEcriteController extends Controller
{
    // Affiche le test d’expression écrite avec une question aléatoire
    public function afficherTest()
    {
        $user = Auth::user();
        if (!$user) {
            $user = User::find(1); // fallback pour test
        }


        // ✅ On récupère la dernière question sur laquelle il a travaillé
        $last = ExpressionEcriteReponse::where('user_id', $user->id)->latest()->first();

        if ($last) {
            $question = ExpressionEcrite::find($last->expression_ecrite_id);
        } else {
            // ✅ Sinon, on tire une nouvelle question et on crée le premier message IA

            $question = ExpressionEcrite::inRandomOrder()->first();

            if (!$question) {
                return response()->json(['error' => 'Aucune question trouvée.'], 404);
            }


            $intro = "Bonjour ! Voici le sujet sur lequel nous allons échanger aujourd'hui. Prenez le temps de bien lire la consigne et n'hésitez pas à commencer quand vous êtes prêt.";

            ExpressionEcriteReponse::create([
                'user_id' => $user->id,
                'expression_ecrite_id' => $question->id,
                'prompt' => $intro,
                'reponse' => null, // aucune réponse encore
                'question' => $question->contexte_texte ?? '',
            ]);
        }


        $question = ExpressionEcrite::inRandomOrder()->first();

        if (!$question) {
            return response()->json(['error' => 'Aucune question trouvée.'], 404);
        }

        $reponses = ExpressionEcriteReponse::where('user_id', $user->id)
            ->where('expression_ecrite_id', $question->id)
            ->orderBy('created_at')
            ->get();

        $score = null;
        $commentaire = null;

        return view('test.expression_ecrite', compact('question', 'reponses', 'score', 'commentaire'));
    }


    // Envoie le message de l'utilisateur à l'IA et enregistre la réponse
    public function envoyerMessage(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            $user = User::find(1); // fallback pour test
        }


        $validated = $request->validate([
            'message' => 'required|string',
            'expression_ecrite_id' => 'required|exists:expression_ecrites,id',
        ]);

        $question = ExpressionEcrite::findOrFail($validated['expression_ecrite_id']);

        // Historique des échanges (limité aux 5 derniers)
        $history = ExpressionEcriteReponse::where('user_id', $user->id)
            ->where('expression_ecrite_id', $question->id)
            ->latest()
            ->take(5)
            ->get()
            ->reverse();

        $messages = [];

        $messages[] = [
            'role' => 'system',
            'content' => "Tu es un correcteur humain bienveillant, qui échange avec un étudiant dans un test d'expression écrite, sois clair, pas de long texte, ni de suggestion. tu pose juste des question pour en savoir plus afin que l'élève puis continuer à écrire...

Contexte : " . ($question->contexte_texte ?? 'Aucun') . "
Consigne : " . ($question->consigne ?? 'Aucune') . "

Tu parles normalement, comme un enseignant ou un formateur. Pas de formules IA, pas de mots comme 'je suis une intelligence artificielle'. Tu l’encourages à s’exprimer et tu échanges de façon fluide, comme une vraie personne, sois clair, pas de long texte, ni de suggestion. tu pose juste des question pour en savoir plus afin que l'élève puis continuer à écrire..."
        ];


        // Puis l’historique
        foreach ($history as $h) {
            $messages[] = ['role' => 'user', 'content' => $h->reponse];
            $messages[] = ['role' => 'assistant', 'content' => $h->prompt];
        }

        // Enfin, le nouveau message de l’utilisateur
        $messages[] = ['role' => 'user', 'content' => $validated['message']];


        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post(env('OPENROUTER_API_URL'), [
                        'model' => 'deepseek/deepseek-r1-0528:free',
                        'messages' => $messages,
                    ]);

            if ($response->failed()) {
                \Log::error('Erreur API IA :', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return response()->json(['reply' => "L'IA n'a pas répondu correctement."], 500);
            }

            $data = $response->json();
            $reply = $data['choices'][0]['message']['content'] ?? "Réponse IA introuvable.";

            // Sauvegarde dans la base
            ExpressionEcriteReponse::create([
                'user_id' => $user->id,
                'expression_ecrite_id' => $validated['expression_ecrite_id'],
                'prompt' => $reply,
                'reponse' => $validated['message'],
                'question' => $question->contexte_texte ?? 'Non défini',
            ]);

            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            \Log::error('Exception API IA :', ['message' => $e->getMessage()]);
            return response()->json(['reply' => "Erreur serveur : " . $e->getMessage()], 500);
        }
    }

    // Vue de fin de test avec score
    public function resultat()
    {
        $user = Auth::user();
        if (!$user) {
            $user = User::find(1); // fallback pour test
        }


        $lastAnswer = ExpressionEcriteReponse::where('user_id', $user->id)->latest()->first();

        if (!$lastAnswer) {
            return redirect()->route('expression_ecrite')->with('error', 'Aucune réponse trouvée.');
        }

        $question = ExpressionEcrite::find($lastAnswer->expression_ecrite_id);

        $reponses = ExpressionEcriteReponse::where('user_id', $user->id)
            ->where('expression_ecrite_id', $question->id)
            ->orderBy('created_at')
            ->get();

        $score = min(100, 60 + rand(0, 40));
        $commentaire = "Votre réponse est pertinente. Quelques fautes d’orthographe à corriger. Travail à améliorer en structuration.";

        return view('test.expression_ecrite_resultat', compact('question', 'reponses', 'score', 'commentaire'));
    }
}
