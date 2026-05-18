<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $systemPrompt = 'You are Halzanîn Assistant, a helpful AI for the Kurdistan Region Passport Directorate document tracking system. You help citizens understand what documents they need, how to track their applications, and answer questions about the passport process. Keep answers short, clear, and friendly. You can respond in both English and Kurdish (Sorani). If asked in Kurdish, respond in Kurdish. Common questions: passport renewal needs (original passport, national ID, 2 photos, fee receipt), new passport needs (birth certificate, national ID, 2 photos), tracking instructions (use tracking code from QR receipt at /track/YOUR-CODE). Never make up information. If unsure, say to visit the directorate.';

        $apiKey = config('services.mistral.key');

        try {
            $response = Http::withToken($apiKey)->timeout(60)->post(
                "https://api.mistral.ai/v1/chat/completions",
                [
                    'model' => 'mistral-small-latest',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $request->message],
                    ],
                    'max_tokens'  => 300,
                    'temperature' => 0.7,
                ]
            );

            if ($response->failed()) {
                $error = $response->json();
                $errorMessage = $error['message'] ?? $response->body() ?? 'Unknown API error occurred.';
                \Log::error('Mistral API error: ' . $errorMessage);
                return response()->json(['reply' => 'Sorry, I\'m having trouble connecting right now. Please try again shortly.']);
            }

            $data  = $response->json();
            $reply = $data['choices'][0]['message']['content']
                     ?? 'Sorry, I could not process your request.';

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            \Log::error('Mistral connection error: ' . $e->getMessage());
            return response()->json(['reply' => 'Connection error. Please try again.']);
        }
    }
}
