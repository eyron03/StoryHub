<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class ElevenLabsService
{
    /**
     * Create a new class instance.
     */
    protected $apiKey;
    protected $baseUrl;
    public function __construct()
    {
        //

        $this->apiKey = config('services.elevenlabs.api_key'); // Store your API key in config/services.php
        $this->baseUrl = 'https://api.elevenlabs.io/v1';
    }
    public function textToSpeech($text, $voiceId)
    {
        $response = Http::withHeaders([
            'xi-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/text-to-speech/{$voiceId}", [
            'text' => $text,
        ]);

        return $response->json();
    }
}
