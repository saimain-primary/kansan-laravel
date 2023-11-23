<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\ClientException;

trait MessengerTrait
{
    protected $accessToken;
    protected $apiURL;
    protected $apiVersion;
    protected $pageId;
    protected $httpClient;

    // Boot method for the trait
    protected function bootMessengerTrait()
    {
        // Retrieve the value from .env, or use a default value
        $this->accessToken = config('app.fb_access_token');
        $this->apiVersion = config('app.fb_api_version');
        $this->pageId = config('app.fb_page_id');
        $this->apiURL = "https://graph.facebook.com/" . $this->apiVersion . "/" . $this->pageId . "/messages?access_token=" . $this->accessToken;
        $this->httpClient = new Client();
    }


    protected function sendSenderAction($senderPSID, $action)
    {
        try {
            $response = Http::post($this->apiURL, [
                'recipient' => [
                    'id' => $senderPSID,
                ],
                "sender_action" => $action
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

    protected function sendText($senderPSID, $text, $messageType = null)
    {
        try {
            $response = Http::post($this->apiURL, [
                'recipient' => [
                    'id' => $senderPSID,
                ],
                "message_type" => $messageType,
                "message" => [
                    'text' => $text
                ]
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
        Log::debug($responseData);
        return $responseData;
    }

}
