<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlutterwaveDirectCharge
{
    public function __construct(private readonly string $secretKey) {}

    public function getEncryptionKey(): string
    {
        $hashedKey = md5($this->secretKey);
        $hashedKeyLast12 = substr($hashedKey, -12);
        $secretKeyAdjusted = str_replace('FLWSECK-', '', $this->secretKey);
        $secretKeyFirst12 = substr($secretKeyAdjusted, 0, 12);

        return $secretKeyFirst12.$hashedKeyLast12;
    }

    public function encryptPayload(array $payload): string
    {
        $key = $this->getEncryptionKey();
        $encrypted = openssl_encrypt(json_encode($payload), 'DES-EDE3', $key, OPENSSL_RAW_DATA);

        return base64_encode($encrypted);
    }

    public function charge(array $payload): array
    {
        $response = Http::withToken($this->secretKey)
            ->post('https://api.flutterwave.com/v3/charges?type=card', [
                'client' => $this->encryptPayload($payload),
            ]);

        if (! $response->successful()) {
            Log::channel('flutterwave')->error('Direct charge request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return $response->json() ?? [];
    }

    public function validateCharge(string $otp, string $flwRef): array
    {
        $response = Http::withToken($this->secretKey)
            ->post('https://api.flutterwave.com/v3/validate-charge', [
                'otp' => $otp,
                'flw_ref' => $flwRef,
                'type' => 'card',
            ]);

        return $response->json() ?? [];
    }

    public function verifyTransaction(int $transactionId): array
    {
        $response = Http::withToken($this->secretKey)
            ->get("https://api.flutterwave.com/v3/transactions/{$transactionId}/verify");

        return $response->json() ?? [];
    }
}
