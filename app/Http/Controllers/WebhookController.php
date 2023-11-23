<?php

namespace App\Http\Controllers;

use App\Traits\MessengerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    use MessengerTrait;

    public function __construct()
    {
        $this->bootMessengerTrait();
    }


    public function getWebhook(Request $request)
    {
        Log::info('get webhook called');
        Log::debug($request->all());

        $verifyToken = config('app.fb_verify_token');

        $challenge = $request->hub_challenge;
        $mode = $request->hub_mode;
        $vToken = $request->hub_verify_token;

        if ($mode && $vToken) {
            if ($mode === "subscribe" && $vToken === $verifyToken) {
                Log::info('Webhook Verified');
                return response($challenge, 200);
            } else {
                Log::info('Verification Failed');
                return response(null, 403);
            }
        }
    }

    public function postWebhook(Request $request)
    {
        Log::info('post webhook called');
        $data = $request->all();
        if ($data['object'] === "page") {
            foreach ($data['entry'] as $ent) {
                $webhookEvent = $ent['messaging'][0];
                $this->handleWebhookEvent($webhookEvent);
            }
            return response('Event Received', 200);
        } else {
            return response(null, 403);
        }
    }

    protected function handleWebhookEvent($event)
    {
        Log::debug($event);
        $senderPSID = $event['sender']['id'];
        $message = $event['message']['text'];
        $this->sendSenderAction($senderPSID, 'typing_on');
        $this->sendText($senderPSID, 'Hello , This is from handleWebhookEvent , Your message is ' . $message);
        ;
        $this->sendSenderAction($senderPSID, 'typing_off');
        return response('Successfully handled', 200);
    }
}
