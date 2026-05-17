<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $response = Http::withHeaders([
            'x-api-key'         => config('services.anthropic.key'),
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model'      => 'claude-haiku-4-5-20251001',
            'max_tokens' => 300,
            'system'     => 'You are Halzanîn Assistant, a helpful AI for the Kurdistan Region Passport Directorate document tracking system. You help citizens understand what documents they need, how to track their applications, and answer questions about the passport process. Keep answers short, clear, and friendly. You can respond in both English and Kurdish (Sorani). If asked in Kurdish, respond in Kurdish. Common questions: passport renewal needs (original passport, national ID, 2 photos, fee receipt), new passport needs (birth certificate, national ID, 2 photos), tracking instructions (use tracking code from QR receipt at /track/YOUR-CODE). Never make up information. If unsure, say to visit the directorate.',
            'messages'   => [
                ['role' => 'user', 'content' => $request->message],
            ],
        ]);

        $data = $response->json();

        return response()->json([
            'reply' => $data['content'][0]['text'] ?? 'Sorry, I could not process your request.',
        ]);
    }
}
