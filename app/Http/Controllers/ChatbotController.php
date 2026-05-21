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

        $systemPrompt = 'You are Halzanîn Assistant — the official AI guide for the Kurdistan Region Government Services Portal. You help citizens understand government services, required documents, and how to apply online. Keep answers short (2–4 sentences), clear, and helpful. Respond in Kurdish (Sorani) when the user writes in Kurdish, otherwise respond in English. Never invent fees, legal rules, or contact details not listed below.';

        $krgPassportRulesPrompt = implode("\n", [
            '=== HALZANIN PORTAL — SERVICE KNOWLEDGE BASE ===',
            '',
            'PORTAL: halzanin.gov.krd — Kurdistan Region e-Government Portal covering 5 ministries.',
            'TRACKING: Citizens track applications at /track/TRACKING-CODE using the code on their QR receipt.',
            '',
            '--- CIVIL REGISTRY (تۆماری مەدەنی) ---',
            'National ID Card (slug: national-id) — ACTIVE:',
            '  Required docs: National ID (old), Birth certificate (scanned), Family registry book, Recent passport photo.',
            '  Process: Submitted → Documents Verified → Under Processing → Ready for Pickup → Completed. Est. 7 days.',
            'Birth Certificate (slug: birth-certificate) — ACTIVE:',
            '  Required docs: Parents\' National ID cards (scanned), Hospital birth record or midwife statement, Family registry book (scanned).',
            '  Process: Submitted → Documents Verified → Under Processing → Ready For Pickup → Completed. Est. 7 days.',
            'Passport Application — COMING SOON.',
            'Marriage Certificate — COMING SOON.',
            '',
            '--- TRAFFIC POLICE (پۆلیسی ترافیک) ---',
            'Driving License (slug: driving-license) — ACTIVE:',
            '  Required docs: National ID, Medical certificate from licensed clinic, Passport photo, Old license (if renewal).',
            '  Form fields: License type (motorcycle/car/heavy), New or renewal, Medical clinic name.',
            '  Process: Submitted → Docs Verified → Theory Test Scheduled → Theory Passed → Practical Test Scheduled → License Ready → Collected. Est. 21 days.',
            'Vehicle Registration — COMING SOON.',
            'Traffic Fine Payment — COMING SOON.',
            '',
            '--- ELECTRICITY DIRECTORATE (بەرپرسایەتی کارەبا) ---',
            'New Connection Application (slug: electricity-connection) — ACTIVE:',
            '  Required docs: National ID, Property deed or rental contract, Building completion certificate.',
            '  Form fields: Property address, Property type (residential/commercial), Requested KW load, Owner or tenant.',
            '  Process: Submitted → Docs Reviewed → Inspection Scheduled → Inspection Completed → Fee Assessed → Installation Scheduled → Connected. Est. 30 days.',
            '',
            '--- WATER DIRECTORATE (بەرپرسایەتی ئاو) ---',
            'New Water Connection (slug: water-connection) — ACTIVE:',
            '  Required docs: National ID, Property deed or rental contract.',
            '  Form fields: Property address, Property type, Water usage type.',
            '  Process: Submitted → Docs Reviewed → Inspection Scheduled → Approved → Installation Scheduled → Connected. Est. 21 days.',
            '',
            '--- BUSINESS REGISTRATION (تۆماری بازرگانی) ---',
            'Business License (slug: business-license) — ACTIVE:',
            '  Required docs: National ID (all owners), Lease or property agreement, Criminal record clearance.',
            '  Form fields: Business name (EN + Kurdish), Business type, Activity description, Address, Capital amount.',
            '  Process: Submitted → Name Check → Under Legal Review → Approved → Fee Pending → License Ready → Completed. Est. 14 days.',
            '',
            '=== RULES ===',
            '1) All services are free for citizens.',
            '2) Applications are submitted online; citizens visit the office only to pick up physical documents.',
            '3) Never invent requirements, fees, timelines, or legal details not listed above.',
            '4) If uncertain, advise the user to visit the relevant directorate.',
            '5) Application tracking code starts with HZ- (e.g., HZ-ABCD1234).',
        ]);
        $messageForApi = $this->appendRulesToQuery($request->message, $krgPassportRulesPrompt);

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
                            ['role' => 'user', 'content' => $messageForApi],
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

        if (Str::contains($text, ['national id', 'ناسنامە', 'هویت'])) {
            return $isKurdish
                ? 'بۆ کارتی ناسنامەی نەتەوەیی پێویستتە: ناسنامەی کۆن، بڕوانامەی لەدایکبوون، دەفتەری خێزانی، و وێنەی ئەخیر. کات داواکاری لە /services/national-id.'
                : 'For a National ID card you need: old ID, birth certificate, family registry book, and a recent photo. Apply at /services/national-id.';
        }

        if (Str::contains($text, ['birth cert', 'birth certificate', 'بڕوانامەی لەدایکبوون', 'لەدایکبوون'])) {
            return $isKurdish
                ? 'بۆ بڕوانامەی لەدایکبوون پێویستتە: ناسنامەی دایک و باوک، بڕوانامەی لەدایکبووی نەخۆشخانە، و دەفتەری خێزانی. کات داواکاری لە /services/birth-certificate.'
                : 'For a birth certificate you need: parents\' national IDs, hospital birth record, and family registry book. Apply at /services/birth-certificate.';
        }

        if (Str::contains($text, ['driving', 'license', 'licence', 'مۆڵەتی شۆفێری', 'مۆڵەتی'])) {
            return $isKurdish
                ? 'بۆ مۆڵەتی شۆفێری پێویستتە: ناسنامەی نەتەوەیی، بڕوانامەی پزیشکی، وێنە، و مۆڵەتی کۆن (ئەگەر نوێکردنەوەیە). کات داواکاری لە /services/driving-license.'
                : 'For a driving license you need: national ID, medical certificate, passport photo, and old license if renewal. Apply at /services/driving-license.';
        }

        if (Str::contains($text, ['electric', 'electricity', 'connection', 'کارەبا', 'پەیوەندی'])) {
            return $isKurdish
                ? 'بۆ پەیوەندی کارەبای نوێ پێویستتە: ناسنامەی نەتەوەیی، سەند یان گرێبەستی بنبست، و بڕوانامەی تەواوبوونی بینا. کات داواکاری لە /services/electricity-connection.'
                : 'For a new electricity connection you need: national ID, property deed or rental contract, and building completion certificate. Apply at /services/electricity-connection.';
        }

        if (Str::contains($text, ['water', 'ئاو'])) {
            return $isKurdish
                ? 'بۆ پەیوەندی ئاوی نوێ پێویستتە: ناسنامەی نەتەوەیی و سەند یان گرێبەستی بنبست. کات داواکاری لە /services/water-connection.'
                : 'For a new water connection you need: national ID and property deed or rental contract. Apply at /services/water-connection.';
        }

        if (Str::contains($text, ['business', 'license', 'company', 'بازرگانی', 'مۆڵەتی بازرگانی'])) {
            return $isKurdish
                ? 'بۆ مۆڵەتی بازرگانی پێویستتە: ناسنامەی هەموو خاوەنەکان، گرێبەستی بینا، و بڕوانامەی پاکبوونی پەیوەندی تاوانی. کات داواکاری لە /services/business-license.'
                : 'For a business license you need: National IDs of all owners, lease agreement, and criminal record clearance. Apply at /services/business-license.';
        }

        if (Str::contains($text, ['renew', 'renewal', 'نوێکردنەوە', 'پاسپۆرت'])) {
            return $isKurdish
                ? 'خزمەتگوزاری پاسپۆرت بەم زوانەی دێت. بۆ داواکارییە بەردەستەکان سەردانی /services بکە.'
                : 'Passport services are coming soon. Visit /services for currently available services.';
        }

        if (Str::contains($text, ['track', 'tracking', 'status', 'شوێنکەوتن', 'بارودۆخ'])) {
            return $isKurdish
                ? 'بۆ شوێنکەوتنی داواکاری، کۆدی پشوانی HZ- لەسەر QR receipt بەکاربهێنە لە /track/کۆدەکەت.'
                : 'To track your application, use the HZ- tracking code from your QR receipt at /track/YOUR-CODE.';
        }

        if (Str::contains($text, ['services', 'خزمەتگوزاری', 'what can'])) {
            return $isKurdish
                ? 'ئێستا 6 خزمەتگوزاری بەردەستە: ناسنامەی نەتەوەیی، بڕوانامەی لەدایکبوون، مۆڵەتی شۆفێری، پەیوەندی کارەبا، پەیوەندی ئاو، و مۆڵەتی بازرگانی. هەموویان لە /services بینە.'
                : '6 services are currently active: National ID, Birth Certificate, Driving License, Electricity Connection, Water Connection, and Business License. Browse all at /services.';
        }

        if (Str::contains($text, ['speak in kurdish', 'kurdish', 'کوردی'])) {
            return 'بەڵێ، دەتوانم بە زمانی کوردی وەڵام بدەم. تکایە پرسیارەکەت بنووسە.';
        }

        return $isKurdish
            ? 'ئێستا پەیوەندی AI لاوازە، بەڵام دەتوانم یارمەتیت بدەم لە خزمەتگوزارییە بەردەستەکان، بەلگەنامە پێویستەکان، و شوێنکەوتنی داواکاری.'
            : 'The AI connection is temporarily unavailable, but I can still help with available services, required documents, and application tracking. What do you need?';
    }

    private function appendRulesToQuery(string $userQuery, string $rulesPrompt): string
    {
        return trim($rulesPrompt) . "\n\nCitizen query:\n" . trim($userQuery);
    }
}
