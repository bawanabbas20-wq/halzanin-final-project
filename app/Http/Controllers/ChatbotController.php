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
            'PORTAL: Halzanîn (halzanin.gov.krd) — Kurdistan Region e-Government Portal covering 6 ministries/directorates.',
            'TRACKING: Citizens track applications at /track using the HZ- code printed on their QR receipt.',
            'LANGUAGE: Respond in Kurdish (Sorani) when the user writes in Kurdish, otherwise respond in English.',
            '',
            '--- 1. CIVIL REGISTRY DIRECTORATE (بەرێوەبەرایەتیی تۆماری مەدەنی) ---',
            'Ministry page: /ministry/civil-registry',
            '',
            'National ID Card (slug: national-id) — ACTIVE:',
            '  Required docs: Old National ID (scanned), Birth certificate (scanned), Family registry book (scanned), Recent passport photo.',
            '  Process: Submitted → Documents Verified → Under Processing → Ready for Pickup → Completed.',
            '  Estimated time: 7 days. Free.',
            '',
            'Birth Certificate (slug: birth-certificate) — ACTIVE:',
            '  Required docs: Both parents\' National IDs (scanned), Hospital birth record or midwife statement, Family registry book (scanned).',
            '  Process: Submitted → Documents Verified → Under Processing → Ready for Pickup → Completed.',
            '  Estimated time: 7 days. Free.',
            '',
            'Passport Application — COMING SOON.',
            'Marriage Certificate — COMING SOON.',
            '',
            '--- 2. TRAFFIC POLICE DIRECTORATE (بەرێوەبەرایەتیی پۆلیسی ترافیک) ---',
            'Ministry page: /ministry/traffic-police',
            'Office locations: Erbil HQ (100 Meter Road), Sulaymaniyah (Mawlawi Street), Duhok (Zakho Road), Halabja (Freedom Square).',
            '',
            'Driving License (slug: driving-license) — ACTIVE:',
            '  Required docs: National ID, Medical certificate from a licensed clinic, Passport photo, Old license (if renewal).',
            '  Form fields: License type (motorcycle / car / heavy vehicle), New application or renewal, Medical clinic name.',
            '  Process: Submitted → Docs Verified → Theory Test Scheduled → Theory Passed → Practical Test Scheduled → License Ready → Collected.',
            '  Estimated time: 21 days. Free.',
            '',
            'Vehicle Registration (slug: vehicle-registration) — COMING SOON.',
            'Traffic Fine Payment (slug: traffic-fine-payment) — COMING SOON.',
            'Special Road Permit (slug: special-road-permit) — COMING SOON.',
            '',
            '--- 3. MINISTRY OF ELECTRICITY (وەزارەتی کارەبا) ---',
            'Ministry page: /ministry/electricity',
            'Emergency line: 115 (available 24/7 from any line).',
            'Office locations: Erbil HQ (Ankawa Road), Sulaymaniyah (Kirkuk Road), Duhok (Mosul Road), Halabja (Industrial Zone).',
            '',
            'New Electricity Connection (slug: electricity-connection) — ACTIVE:',
            '  Required docs: National ID, Property deed or rental contract, Building completion certificate.',
            '  Form fields: Property address, Property type (residential/commercial), Requested KW load, Owner or tenant.',
            '  Process: Submitted → Docs Reviewed → Inspection Scheduled → Inspection Completed → Fee Assessed → Installation Scheduled → Connected.',
            '  Estimated time: 30 days. Free (installation fee may apply).',
            '',
            'Smart Meter Upgrade — COMING SOON.',
            '',
            '--- 4. WATER AUTHORITY (دەزگای ئاو) ---',
            'Ministry page: /ministry/water',
            'Emergency leak line: 116 (available 24/7).',
            'Office locations: Erbil HQ (Dream City Road), Sulaymaniyah (Salim Street), Duhok (Semel Road), Halabja (Shahidan Square).',
            '',
            'New Water Connection (slug: water-connection) — ACTIVE:',
            '  Required docs: National ID, Property deed or rental contract, Building permit (approved), Plumbing plan/site sketch.',
            '  Process: Submitted → Docs Reviewed → Inspection Scheduled → Approved → Installation Scheduled → Connected.',
            '  Estimated time: 10–14 days. Free.',
            '',
            'Meter Reading Request (slug: meter-reading) — COMING SOON.',
            'Leak Report (slug: water-leak-report) — COMING SOON. (For urgent leaks call 116 now.)',
            'Water Quality Complaint (slug: water-quality-complaint) — COMING SOON.',
            '',
            '--- 5. MINISTRY OF HEALTH (وەزارەتی تەندروستی) ---',
            'Ministry page: /ministry/health',
            'Emergency: 115 (24/7). Portal handles administrative services only — for medical emergencies call 115 directly.',
            'Office locations: Erbil HQ (Gulan Street), Sulaymaniyah (Bakhtiari Street), Duhok (Mazi Street), Halabja (Martyrs Square).',
            '',
            'Health Card (slug: health-card) — COMING SOON.',
            'Medical Referral (slug: medical-referral) — COMING SOON.',
            'Health Birth Certificate (slug: birth-certificate-health) — COMING SOON.',
            'Death Certificate (slug: death-certificate) — COMING SOON.',
            '',
            '--- 6. BUSINESS REGISTRATION (تۆماری بازرگانی) ---',
            'Business License (slug: business-license) — ACTIVE:',
            '  Required docs: National ID of all owners, Lease or property agreement, Criminal record clearance.',
            '  Form fields: Business name (English + Kurdish), Business type, Activity description, Address, Capital amount.',
            '  Process: Submitted → Name Check → Under Legal Review → Approved → Fee Pending → License Ready → Completed.',
            '  Estimated time: 14 days. Free.',
            '',
            '=== PORTAL RULES ===',
            '1) All portal services are free for citizens unless explicitly noted otherwise.',
            '2) Applications are submitted online via Halzanîn; citizens only visit an office to collect physical documents.',
            '3) Never invent requirements, fees, timelines, phone numbers, or legal details not listed above.',
            '4) If uncertain about anything, advise the citizen to visit the relevant directorate office or call their published number.',
            '5) Tracking codes start with HZ- (e.g., HZ-ABCD1234). Citizens track at /track.',
            '6) The portal currently has 6 active services: National ID, Birth Certificate, Driving License, New Electricity Connection, New Water Connection, Meter Reading, Leak Report, Water Quality Complaint, and Business License.',
            '7) Health ministry services are coming soon — advise users to visit the ministry directly for now.',
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

        // Greetings / small talk — respond warmly and offer guidance.
        if (Str::contains($text, ['hi', 'hello', 'hey', 'hallo', 'salam', 'good morning', 'good evening', 'سڵاو', 'سلاو', 'چۆنی', 'بەخێربێیت'])) {
            return $isKurdish
                ? 'سڵاو! 👋 من یاریدەدەری هەڵژانینم. دەتوانم یارمەتیت بدەم لەسەر خزمەتگوزارییە حکومییەکان، بەڵگەنامە پێویستەکان، و شوێنکەوتنی داواکارییەکانت. چی پێویستتە؟'
                : 'Hello! 👋 I\'m the Halzanîn Assistant. I can help you with government services, required documents, and tracking your applications. What would you like to know?';
        }

        // Thanks
        if (Str::contains($text, ['thank', 'thanks', 'سوپاس', 'زۆر سوپاس'])) {
            return $isKurdish
                ? 'سەرچاوە! 😊 ئەگەر شتێکی تر پێویستت بوو، لێرەم.'
                : 'You\'re welcome! 😊 If you need anything else, I\'m here to help.';
        }

        if (Str::contains($text, ['national id', 'ناسنامە', 'هویت'])) {
            return $isKurdish
                ? 'بۆ کارتی ناسنامەی نەتەوەیی پێویستتە: ناسنامەی کۆن، بڕوانامەی لەدایکبوون، دەفتەری خێزانی، و وێنەی ئەخیر. داواکاری لە /services/national-id بکە.'
                : 'For a National ID card you need: old ID, birth certificate, family registry book, and a recent photo. Apply at /services/national-id.';
        }

        if (Str::contains($text, ['birth cert', 'birth certificate', 'بڕوانامەی لەدایکبوون', 'لەدایکبوون'])) {
            return $isKurdish
                ? 'بۆ بڕوانامەی لەدایکبوون پێویستتە: ناسنامەی دایک و باوک، بڕوانامەی لەدایکبووی نەخۆشخانە، و دەفتەری خێزانی. داواکاری لە /services/birth-certificate بکە.'
                : 'For a birth certificate you need: parents\' national IDs, hospital birth record, and family registry book. Apply at /services/birth-certificate.';
        }

        if (Str::contains($text, ['driving', 'licence', 'مۆڵەتی شۆفێری']) || (Str::contains($text, ['license']) && !Str::contains($text, ['business']))) {
            return $isKurdish
                ? 'بۆ مۆڵەتی شۆفێری پێویستتە: ناسنامەی نەتەوەیی، بڕوانامەی پزیشکی، وێنە، و مۆڵەتی کۆن (ئەگەر نوێکردنەوەیە). داواکاری لە /services/driving-license بکە.'
                : 'For a driving license you need: national ID, medical certificate, passport photo, and old license if renewal. Apply at /services/driving-license.';
        }

        if (Str::contains($text, ['electric', 'electricity', 'کارەبا', 'برق'])) {
            return $isKurdish
                ? 'بۆ پەیوەندی کارەبای نوێ پێویستتە: ناسنامەی نەتەوەیی، سەند یان گرێبەستی بنبست، و بڕوانامەی تەواوبوونی بینا. داواکاری لە /services/electricity-connection بکە. فریاگوزاری: ١١٥ (٢٤/٧).'
                : 'For a new electricity connection you need: national ID, property deed or rental contract, and building completion certificate. Apply at /services/electricity-connection. Emergency line: 115 (24/7).';
        }

        if (Str::contains($text, ['leak', 'لیک', 'water quality', 'کوالێتی ئاو'])) {
            return $isKurdish
                ? 'خزمەتگوزاری ڕاپۆرتی لیک و گیلۆپەی کوالێتی ئاو بەم زووانەی دێن. بۆ فریاگوزاری ئێستا ١١٦ پەیوەندی بکە (٢٤/٧).'
                : 'Online leak reporting and water quality complaint services are coming soon. For emergencies call 116 (24/7).';
        }

        if (Str::contains($text, ['meter read', 'meter reading', 'خوێندنەوەی مێتەر', 'مێتەر'])) {
            return $isKurdish
                ? 'خزمەتگوزاری داوای خوێندنەوەی مێتەر بەم زووانەی دێت. بۆ ئێستا پەیوەندی بکە بە نزیکترین نوسینگەی دەزگای ئاو.'
                : 'Meter reading request service is coming soon. For now please contact your nearest Water Authority office.';
        }

        if (Str::contains($text, ['water', 'ئاو', 'ئاوی'])) {
            return $isKurdish
                ? 'بۆ پەیوەندی ئاوی نوێ پێویستتە: ناسنامەی نەتەوەیی، سەند یان گرێبەستی بنبست، مۆڵەتی بینا، و نەخشەی بۆریی. داواکاری لە /services/water-connection بکە. فریاگوزاری لیک: ١١٦ (٢٤/٧).'
                : 'For a new water connection you need: national ID, property deed or rental contract, building permit, and plumbing plan. Apply at /services/water-connection. Leak emergencies: 116 (24/7).';
        }

        if (Str::contains($text, ['health', 'health card', 'medical', 'referral', 'تەندروستی', 'کارتی تەندروستی', 'پزیشک'])) {
            return $isKurdish
                ? 'خزمەتگوزارییەکانی وەزارەتی تەندروستی بەم زووانەی دێن. بۆ فریاگوزاری پزیشکی ئێستا ١١٥ بپەیوەندە (٢٤/٧).'
                : 'Health ministry services are coming soon on the portal. For medical emergencies call 115 (24/7).';
        }

        if (Str::contains($text, ['death cert', 'death certificate', 'بڕوانامەی مردن', 'مردن'])) {
            return $isKurdish
                ? 'خزمەتگوزاری بڕوانامەی مردن بەم زووانەی دێت لە پۆرتاڵ. بۆ ئێستا سەردانی نزیکترین نوسینگەی تەندروستی بکە.'
                : 'Death certificate service is coming soon on the portal. For now please visit your nearest Health Ministry office.';
        }

        if (Str::contains($text, ['business', 'company', 'بازرگانی', 'مۆڵەتی بازرگانی', 'کۆمپانیا'])) {
            return $isKurdish
                ? 'بۆ مۆڵەتی بازرگانی پێویستتە: ناسنامەی هەموو خاوەنەکان، گرێبەستی بینا، و بڕوانامەی پاکبوونی تاوانی. داواکاری لە /services/business-license بکە.'
                : 'For a business license you need: national IDs of all owners, lease agreement, and criminal record clearance. Apply at /services/business-license.';
        }

        if (Str::contains($text, ['passport', 'پاسپۆرت', 'marriage', 'زەواج'])) {
            return $isKurdish
                ? 'ئەم خزمەتگوزارییە بەم زووانەی دێت. بۆ داواکارییە بەردەستەکان سەردانی /services بکە.'
                : 'This service is coming soon. Visit /services to see all currently available services.';
        }

        if (Str::contains($text, ['track', 'tracking', 'status', 'application status', 'شوێنکەوتن', 'بارودۆخ'])) {
            return $isKurdish
                ? 'بۆ شوێنکەوتنی داواکاری، کۆدی HZ- لەسەر QR receipt بەکاربهێنە لە /track.'
                : 'To track your application, use the HZ- code from your QR receipt at /track.';
        }

        if (Str::contains($text, ['services', 'what services', 'available', 'خزمەتگوزاری', 'what can'])) {
            return $isKurdish
                ? 'پۆرتاڵی هەڵژانین ٦ وەزارەت/بەرێوەبەرایەتی دەگرێتەوە: تۆماری مەدەنی، پۆلیسی ترافیک، کارەبا، ئاو، تەندروستی، و تۆماری بازرگانی. ٦ خزمەتگوزاری ئێستا چالاکن: ناسنامەی نەتەوەیی، بڕوانامەی لەدایکبوون، مۆڵەتی شۆفێری، پەیوەندی کارەبا، پەیوەندی ئاو، و مۆڵەتی بازرگانی.'
                : 'Halzanîn covers 6 directorates: Civil Registry, Traffic Police, Electricity, Water, Health, and Business Registration. 6 services are currently active: National ID, Birth Certificate, Driving License, Electricity Connection, Water Connection, and Business License.';
        }

        if (Str::contains($text, ['speak in kurdish', 'kurdish', 'کوردی'])) {
            return 'بەڵێ، دەتوانم بە زمانی کوردی وەڵام بدەم. تکایە پرسیارەکەت بنووسە.';
        }

        return $isKurdish
            ? 'دەتوانم یارمەتیت بدەم لەسەر خزمەتگوزارییە حکومییەکان وەک ناسنامەی نەتەوەیی، مۆڵەتی شۆفێری، پەیوەندی ئاو و کارەبا، و مۆڵەتی بازرگانی — هەروەها بەڵگەنامە پێویستەکان و شوێنکەوتنی داواکارییەکانت. تکایە ناوی خزمەتگوزارییەک بنووسە یان پرسیار بکە.'
            : 'I can help with government services like National ID, Driving License, Water and Electricity connections, and Business License — plus the documents you\'ll need and how to track your applications. Try asking about a specific service, or type a service name.';
    }

    private function appendRulesToQuery(string $userQuery, string $rulesPrompt): string
    {
        return trim($rulesPrompt) . "\n\nCitizen query:\n" . trim($userQuery);
    }
}
