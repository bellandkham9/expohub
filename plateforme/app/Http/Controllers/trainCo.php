<?php

namespace App\Http\Controllers;

use App\Models\ComprehensionOrale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TrainCo extends Controller
{
    public function formGenerer()
    {
        $questions = ComprehensionOrale::latest()->take(2)->get();
        return view('Admin.train_CO', compact('questions'));
    }

    public function genererNouvellesQuestions(Request $request)
    {
        // Permet exécution jusqu'à 5 min
        set_time_limit(300);

        $request->validate([
            'nb_questions' => 'required|integer|min:1|max:20',
        ]);

        // Récupération d'exemples existants
        $exemples = ComprehensionOrale::inRandomOrder()->take(5)->get()->toArray();

        $prompt = <<<EOT
Tu es un créateur de questions de compréhension orale en français.

Voici 5 exemples :
{$this->jsonSafe($exemples)}

Ta tâche : Génère EXACTEMENT {$request->nb_questions} nouvelles questions au format JSON suivant :

[
  {
    "contexte_texte": "Description de la situation",
    "question": "La question à poser à l'oral",
    "proposition_1": "Réponse A",
    "proposition_2": "Réponse B",
    "proposition_3": "Réponse C",
    "proposition_4": "Réponse D",
    "bonne_reponse": "1"
  }
]

⚠️ Règles :
- Retourne UNIQUEMENT le JSON, pas de texte avant ou après.
- "bonne_reponse" est une chaîne ("1" à "4").
- Chaque champ est obligatoire et non vide.
EOT;

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Content-Type' => 'application/json',
            ])
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-chat',
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu es un générateur de questions pour un test de compréhension orale.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 400
            ]);

        if ($response->failed()) {
            return back()->with('error', 'Erreur API IA : ' . $response->body());
        }

        // Contenu brut renvoyé par l'IA
        $rawContent = $response->json()['choices'][0]['message']['content'] ?? null;

        // 🔍 DEBUG — afficher ou logguer le contenu
        \Log::info("Réponse brute IA:", ['content' => $rawContent]);
        // dd($rawContent); // <-- à activer si tu veux voir direct dans le navigateur

        // On continue seulement après avoir vu le contenu
        $jsonContent = trim($rawContent);

        // Petit nettoyage si jamais il y a des ```json ... ```
        $jsonContent = preg_replace('/^```json\s*/', '', $jsonContent);
        $jsonContent = preg_replace('/```$/', '', $jsonContent);

        $questions = json_decode($jsonContent, true);

        if (!is_array($questions)) {
            return back()->with('error', 'Réponse IA invalide après nettoyage : ' . $jsonContent);
        }


        foreach ($questions as $q) {
            if (empty($q['contexte_texte']) || empty($q['question']) || empty($q['bonne_reponse'])) {
                continue;
            }

            // Création en DB
            $question = ComprehensionOrale::create([
                'contexte_texte' => $q['contexte_texte'],
                'question_audio' => '', // sera rempli après TTS
                'proposition_1' => $q['proposition_1'],
                'proposition_2' => $q['proposition_2'],
                'proposition_3' => $q['proposition_3'],
                'proposition_4' => $q['proposition_4'],
                'bonne_reponse' => $q['bonne_reponse'],
            ]);

            // Génération audio immédiate (ElevenLabs, OpenAI TTS, etc.)
            $audioFile = $this->genererAudio($q['question']);

            if ($audioFile && Storage::disk('public')->exists($audioFile)) {
                $question->update(['question_audio' => $audioFile]);
            } else {
                // Log pour debug
                \Log::error("⚠️ Échec de génération audio pour la question ID {$question->id}");

                // Optionnel : affichage direct pour le développeur
                echo "<script>alert('Erreur : génération audio échouée pour la question ID {$question->id}');</script>";
            }

        }

        return back()->with([
            'success' => 'Audios générés avec succès.',
            'generated_section' => 'comprehension_orale',
            'generated_audios' => $question
        ]);


    }

    private function jsonSafe($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    private function genererAudio($texte)
    {
        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'xi-api-key' => env('ELEVENLABS_API_KEY'),
                    'Accept' => 'audio/mpeg', // ✅ Force le retour en MP3
                    'Content-Type' => 'application/json',
                ])
                ->post("https://api.elevenlabs.io/v1/text-to-speech/" . env('ELEVENLABS_VOICE_ID'), [
                    'text' => $texte,
                    'voice_settings' => [
                        'stability' => 0.5,
                        'similarity_boost' => 0.75,
                    ],
                ]);

            if ($response->successful()) {
                $audioPath = 'comprehension_orale/' . uniqid() . '.mp3';
                Storage::disk('public')->put($audioPath, $response->body()); // ✅ Stocker le binaire
                return $audioPath;
            } else {
                \Log::error("Erreur ElevenLabs : " . $response->status() . " - " . $response->body());
                return null;
            }


            if ($response->successful()) {
                $fileName = 'audios/questions/' . uniqid() . '.mp3';
                Storage::disk('public')->put($fileName, $response->body());
                return $fileName;
            }
        } catch (\Exception $e) {
            \Log::error("Erreur API ElevenLabs : " . $response->status() . " - " . $response->body());

        }
        return null;
    }
}
