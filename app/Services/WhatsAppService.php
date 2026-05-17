<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function send(string $phone, string $message): bool
    {
        // Format phone: remove 0 prefix, add 964 (Iraq country code)
        $formatted = '964' . ltrim($phone, '0');
        $apiKey = config('services.callmebot.key');

        $response = Http::get('https://api.callmebot.com/whatsapp.php', [
            'phone'  => $formatted,
            'text'   => $message,
            'apikey' => $apiKey,
        ]);

        return $response->successful();
    }
}
