<?php

namespace App\Traits;

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
        ;
    }


    protected function sendTypingAction($senderPSID)
    {
        try {
            $response = $this->httpClient->request("POST", $this->apiURL, [
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
