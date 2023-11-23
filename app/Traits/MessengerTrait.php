<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\ClientException;

trait MessengerTrait
{
    protected static $accessToken;
    protected static $apiURL;
    protected static $apiVersion;
    protected static $pageId;
    protected static $httpClient;

    // Boot method for the trait
    protected static function bootMessengerTrait()
    {
        // Retrieve the value from .env, or use a default value
        static::$accessToken = config('app.fb_access_token');
        static::$apiVersion = config('app.fb_api_version');
        static::$pageId = config('app.fb_page_id');
        static::$apiURL = "https://graph.facebook.com/" . static::$apiVersion . "/" . static::$pageId . "/messages?access_token=" . static::$accessToken;
        static::$httpClient = new Client();
    }


    protected function sendTypingAction($senderPSID)
    {
        try {
            $response = Http::post('http://example.com/users', [
                'name' => 'Steve',
                'role' => 'Network Administrator',
            ]);

            $response = self::$httpClient->request("POST", self::$apiURL, [
                'json' => [
                    'recipient' => [
                        'id' => $senderPSID,
                    ],
                    "sender_action" => "typing_on"
                ]
            ]);

            // Decode the JSON response
            $responseData = [
                'response' => json_decode($response->getBody(), true),
                'status' => $response->getStatusCode()
            ];

        } catch (ClientException $e) {
            // Extract the response from the exception
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            // Decode the JSON response
            $responseData = [
                'response' =>  json_decode($responseBody, true),
                'status' => $response->getStatusCode()
            ];
            // Handle the error accordingly
            // For example, you might log the error or return an error message
        }

        // Return the response data or handle it as needed
        Log::debug($responseData);
        return $responseData;
    }

}
