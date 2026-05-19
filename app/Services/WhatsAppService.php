<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function send(string $phone, string $message): bool
    {
        $apiKey = config('services.callmebot.key');

        if (blank($phone) || blank($apiKey)) {
            return false;
        }

        // Format phone: remove 0 prefix, add 964 (Iraq country code)
        $formatted = '964' . ltrim($phone, '0');

        try {
            $response = Http::timeout(10)->get('https://api.callmebot.com/whatsapp.php', [
                'phone'  => $formatted,
                'text'   => $message,
                'apikey' => $apiKey,
            ]);

            return $response->successful();
        } catch (\Throwable $e) {
            Log::warning('WhatsApp notification failed.', [
                'phone' => $formatted,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
