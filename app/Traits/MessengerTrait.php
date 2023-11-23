<?php

namespace App\Traits;

use Exception;
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
            $response = Http::post(self::$apiURL, [
                'recipient' => [
                    'id' => $senderPSID,
                ],
                "sender_action" => "typing_on"
            ]);

            // Decode the JSON response
            $responseData = [
                'response' => $response->json(),
                'status' => 200
            ];

        } catch (Exception $e) {
            $responseData = [
                'response' =>  $e->getMessage(),
                'status' => 500,
            ];
        }

        // Return the response data or handle it as needed
        Log::debug($responseData);
        return $responseData;
    }

}
