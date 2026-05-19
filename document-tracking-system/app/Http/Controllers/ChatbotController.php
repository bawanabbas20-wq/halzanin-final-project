<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $systemPrompt = 'You are Halzanin Assistant, a helpful AI for the Kurdistan Region Passport Directorate document tracking system. You help citizens understand what documents they need, how to track their applications, and answer questions about the passport process. Keep answers short, clear, and friendly. You can respond in both English and Kurdish (Sorani). If asked in Kurdish, respond in Kurdish. Common questions: passport renewal needs (original passport, national ID, 2 photos, fee receipt), new passport needs (birth certificate, national ID, 2 photos), tracking instructions (use tracking code from QR receipt at /track/YOUR-CODE). Never make up information. If unsure, say to visit the directorate.';

        $apiKey = config('services.mistral.key');
        if (blank($apiKey)) {
            \Log::error('Mistral API key is missing.');
            return response()->json(['reply' => $this->fallbackReply($request->message)]);
        }

        try {
            $response = Http::withToken($apiKey)
                ->connectTimeout(8)
                ->timeout(15)
                ->retry(1, 300)
                ->post(
                'https://api.mistral.ai/v1/chat/completions',
                [
                    'model' => 'mistral-small-latest',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $request->message],
                    ],
                    'max_tokens' => 300,
                    'temperature' => 0.7,
                ]
            );

            if ($response->failed()) {
                $error = $response->json();
                $errorMessage = data_get($error, 'error.message')
                    ?? data_get($error, 'message')
                    ?? strip_tags($response->body())
                    ?? 'Unknown API error occurred.';

                \Log::error('Mistral API error', [
                    'status' => $response->status(),
                    'error' => $errorMessage,
                ]);

                return response()->json(['reply' => $this->fallbackReply($request->message)]);
            }

            $data = $response->json();
            $reply = data_get($data, 'choices.0.message.content', 'Sorry, I could not process your request.');

            return response()->json(['reply' => $reply]);
        } catch (\Throwable $e) {
            \Log::error('Mistral connection error', ['message' => $e->getMessage()]);
            return response()->json(['reply' => $this->fallbackReply($request->message)]);
        }
    }

    private function fallbackReply(string $message): string
    {
        $text = mb_strtolower(trim($message));
        $isKurdish = preg_match('/[\p{Arabic}]/u', $message) === 1
            || Str::contains($text, ['kurdish', 'sorani', 'کوردی']);

        if (Str::contains($text, ['renew', 'renewal', 'نوێکردنەوە', 'پاسپۆرت'])) {
            return $isKurdish
                ? 'بۆ نوێکردنەوەی پاسپۆرت: 1) پاسپۆرتی کۆن 2) ناسنامەی نیشتیمانی 3) 2 وێنەی پاسپۆرت 4) پسووڵەی پارەدان. دەتوانیت کات بەرواری نوێ لە Book Appointment دابنێیت.'
                : 'For passport renewal you need: 1) original passport, 2) national ID, 3) 2 passport photos, and 4) fee receipt. You can book an appointment from Book Appointment.';
        }

        if (Str::contains($text, ['new passport', 'first passport', 'new application', 'پاسپۆرتی نوێ'])) {
            return $isKurdish
                ? 'بۆ داواکاری پاسپۆرتی نوێ: 1) بڕوانامەی لەدایکبوون 2) ناسنامەی نیشتیمانی 3) 2 وێنەی پاسپۆرت. پاشان لە Book Appointment کات دابنێ.'
                : 'For a new passport application, bring: 1) birth certificate, 2) national ID, and 3) 2 passport photos. Then book your appointment from Book Appointment.';
        }

        if (Str::contains($text, ['track', 'tracking', 'status', 'شوێنکەوتن', 'بارودۆخ'])) {
            return $isKurdish
                ? 'بۆ شوێنکەوتنی داواکاری، کۆدی شوێنکەوتنەکە لەسەر QR receipt بەکاربهێنە لە /track/YOUR-CODE.'
                : 'To track your application, use the tracking code on your QR receipt at /track/YOUR-CODE.';
        }

        if (Str::contains($text, ['speak in kurdish', 'kurdish', 'کوردی'])) {
            return 'بەڵێ، دەتوانم بە زمانی کوردی وەڵام بدەم. تکایە پرسیارەکەت بنووسە.';
        }

        return $isKurdish
            ? 'ئێستا پەیوەندی AI لاوازە، بەڵام دەتوانم یارمەتیت بدەم لە: نوێکردنەوەی پاسپۆرت، پاسپۆرتی نوێ، و شوێنکەوتنی داواکاری.'
            : 'The AI connection is unstable right now, but I can still help with passport renewal, new passport requirements, and application tracking.';
    }
}
