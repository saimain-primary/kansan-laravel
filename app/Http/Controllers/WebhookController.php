<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function getWebhook(Request $request)
    {
        Log::debug($request->all());

        $verifyToken = config('app.fb_verify_token');

        $mode = $request->hub_mode;
        $vToken = $request->hub_verify_token;

        if ($mode && $vToken) {
            if ($mode === "subscribe" && $vToken === $verifyToken) {
                Log::info('Webhook Verified');
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully verified'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Verification Failed'
                ], 500);
            }
        }
    }
}
