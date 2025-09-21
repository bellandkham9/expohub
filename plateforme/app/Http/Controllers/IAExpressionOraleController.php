<?php

namespace App\Http\Controllers;

use App\Models\ExpressionOrale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class IAExpressionOraleController extends Controller
{
    public function formGenerer()
    {
        $taches = ExpressionOrale::latest()->take(2)->get();
        return view('Admin.train_EO', compact('taches'));
    }

    public function genererNouvellesTaches(Request $request)
    {
        set_time_limit(600); // 10 minutes pour être large

        $request->validate([
            'nb_taches' => 'required|integer|min:1|max:10',
        ]);

        // 1️⃣ Générer de nouvelles tâches via IA
        $exemples = ExpressionOrale::inRandomOrder()->take(3)->get()->toArray();

        $prompt = <<<EOT
Tu es un concepteur de tests d'expression orale pour le français.

Voici 3 exemples de tâches déjà existantes :
{$this->jsonSafe($exemples)}

Ta tâche : Génère EXACTEMENT {$request->nb_taches} nouvelles tâches au même format JSON.

FORMAT STRICT :
[
  {
    "numero": 1,
    "type": "tcf-canada",
    "contexte": "Texte ou situation à lire",
    "consigne": "Instruction à suivre pour l'élève"
  }
]

⚠️ Retourne uniquement du JSON valide, rien d'autre.
EOT;

        $response = Http::timeout(120)
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Content-Type' => 'application/json',
            ])
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat',
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu renvoies uniquement du JSON valide.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 400
            ]);

        if ($response->failed()) {
            return back()->with('error', 'Erreur API IA : ' . $response->body());
        }

        $jsonContent = $response->json()['choices'][0]['message']['content'] ?? $response->body();
        $taches = json_decode($jsonContent, true);

        if (!is_array($taches)) {
            return back()->with('error', "Réponse IA invalide : {$jsonContent}");
        }

        foreach ($taches as $t) {
            if (!isset($t['numero'], $t['type'], $t['contexte'], $t['consigne'])) {
                return back()->with('error', "Objet IA incomplet : " . json_encode($t));
            }

            ExpressionOrale::create([
                'numero' => $t['numero'],
                'type' => $t['type'],
                'skill' => 'expression orale',
                'contexte' => $t['contexte'],
                'consigne' => $t['consigne'],
                'consigne_audio' => '', // audio à générer
            ]);
        }

        // 2️⃣ Génération audio pour toutes les tâches sans audio
        $tasksSansAudio = ExpressionOrale::whereNull('consigne_audio')
            ->orWhere('consigne_audio', '')
            ->get();

        foreach ($tasksSansAudio as $task) {
            try {
                $audioResponse = Http::timeout(60)->withHeaders([
                    'xi-api-key' => env('ELEVENLABS_API_KEY'),
                    'Accept' => 'audio/mpeg',
                    'Content-Type' => 'application/json',
                ])->post("https://api.elevenlabs.io/v1/text-to-speech/" . env('ELEVENLABS_VOICE_ID'), [
                            "text" => $task->consigne,
                            "model_id" => "eleven_multilingual_v2",
                            "voice_settings" => [
                                "stability" => 0.4,
                                "similarity_boost" => 0.8,
                            ],
                        ]);

                if ($audioResponse->successful()) {
                    $audioPath = 'expression_orale/' . uniqid() . '.mp3';
                    Storage::disk('public')->put($audioPath, $audioResponse->body());
                    $task->consigne_audio = $audioPath;
                    $task->save();
                } else {
                    Log::error('Échec génération audio', [
                        'task_id' => $task->id,
                        'status' => $audioResponse->status(),
                        'body' => $audioResponse->body(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Exception génération audio', [
                    'task_id' => $task->id,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        return back()->with([
            'success' => 'Tâches générées avec succès.',
            'generated_section' => 'expression_orale',
            'generated_taches_orales' => $taches
        ]);
    }


    private function jsonSafe($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
