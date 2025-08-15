<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // N'oubliez pas d'importer la façade HTTP

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        // Récupérez le message de l'utilisateur
        $userMessage = $request->input('message');

        // URL de l'API DeepSeek
        $deepseekApiUrl = 'https://openrouter.ai/api/v1/chat/completions';

        // Données pour l'API DeepSeek
        // Notez que le format est similaire à OpenAI, mais c'est toujours bien de le vérifier
        $data = [
            'model' => 'deepseek-chat', // C'est le modèle pour le chat
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $userMessage,
                ],
            ],
            'stream' => false,
        ];

        // Appel de l'API de DeepSeek
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('DEEPSEEK_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post($deepseekApiUrl, $data);

            // Gérer la réponse de l'API
            if ($response->successful()) {
                $botReply = $response->json()['choices'][0]['message']['content'];
            } else {
                // En cas d'échec, renvoyer le message d'erreur de l'API ou un message générique
                $botReply = "Désolé, une erreur est survenue : " . $response->json()['error']['message'];
            }
        } catch (\Exception $e) {
            // Gérer les erreurs de connexion
            $botReply = "Une erreur est survenue lors de la communication avec l'IA. Veuillez vérifier votre clé API.";
        }

        // Renvoie la réponse du bot au format JSON
        return response()->json(['reply' => $botReply]);
    }
}