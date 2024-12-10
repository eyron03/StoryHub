<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class ElevenLabsService
{
    protected $client;
    protected $apiUrl = 'https://api.elevenlabs.io/v1/text-to-speech/'; // Check if this URL is correct
    protected $apiKey = 'sk_2a750a0ca67f4f96ab950eee6d72ca44637b51dd484a028c'; // Replace with your actual API key

    public function __construct()
    {
        $this->client = new Client();
    }

    public function generateAudio($text)
    {
        try {
            // Prepare the request data
            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'text' => $text,  // The text to be converted to speech
                    'voice' => 'onwK4e9ZLuTAKqWW03F9',  // Replace with the actual voice ID you want
                    'speed' => 1,  // Adjust speed if needed (optional)
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,  // Use your API key in the authorization header
                ]
            ]);

            // Check if response is successful (status code 200)
            if ($response->getStatusCode() === 200) {
                // Assuming the API returns binary audio data in the response body
                $audioData = $response->getBody()->getContents();

                // Generate a unique filename for the audio file
                $audioFilename = 'audio_' . uniqid() . '.mp3';
                $audioFilePath = public_path('storyhub/audios/') . $audioFilename;

                // Save the audio data locally
                file_put_contents($audioFilePath, $audioData);

                // Log the success
                Log::info('Audio generated successfully for text: ' . $text);

                // Return the relative path to the audio file
                return 'storyhub/audios/' . $audioFilename;
            } else {
                // Log failure to get a valid response
                Log::error('API request failed. Status code: ' . $response->getStatusCode());
                return false;
            }
        } catch (RequestException $e) {
            // Log any exception errors
            Log::error('Error in Eleven Labs API request: ' . $e->getMessage());
            return false;
        }
    }
}
