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

        $apiKey = config('services.gemini.key');

        try {
            $response = Http::post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
                [
                    'system_instruction' => [
                        'parts' => [['text' => $systemPrompt]],
                    ],
                    'contents' => [
                        [
                            'role'  => 'user',
                            'parts' => [['text' => $request->message]],
                        ],
                    ],
                    'generationConfig' => [
                        'maxOutputTokens' => 300,
                        'temperature'     => 0.7,
                    ],
                ]
            );

            if ($response->failed()) {
                $error = $response->json();
                $errorMessage = $error['error']['message'] ?? 'Unknown API error occurred.';
                return response()->json(['reply' => 'API Error: ' . $errorMessage]);
            }

            $data = $response->json();
            $reply = $data['candidates'][0]['content']['parts'][0]['text']
                     ?? 'Sorry, I could not process your request.';

            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            return response()->json(['reply' => 'Connection Error: ' . $e->getMessage()]);
        }
    }
}
