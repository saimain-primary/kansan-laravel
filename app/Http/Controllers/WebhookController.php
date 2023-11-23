<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
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
        Log::debug($request->all());
    }
}
