<?php

namespace App\Http\Controllers;

use App\Traits\MessengerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        Log::debug($data);
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
        if (isset($event['postback'])) {
            $payloadData = $event['postback']['payload'];
            if($payloadData === 'GET_STARTED') {
                $this->sendWelcomeGeneric($senderPSID);
            }
            Log::info('postback is called');
        } else {
            $message = $event['message']['text'];
            $this->sendSenderAction($senderPSID, 'typing_on');
            $this->sendText($senderPSID, 'Hello , This is from handleWebhookEvent , Your message is ' . $message);
            $this->sendSenderAction($senderPSID, 'typing_off');
        }
        return response('Successfully handled', 200);
    }

    protected function sendWelcomeGeneric($senderPSID)
    {
        $content = [
            [
                'title' => 'ကံစမ်းမဲ ဝယ်ရန်',
                'subtitle' => 'ကံစမ်းမဲ ဝယ်နည်းများကို အသေးစိတ်ကြည့်မည်',
                'image_url' => Storage::disk('public')->url('images/buying_ticket_guide.png'),
                "default_action" => [
                    "type" => "postback",
                    "payload" => "DEFAULT_ACTION_PAYLOAD"
                ]
            ],
            [
                'title' => 'ကံစမ်းမဲ လက်မှတ် စစ်ရန်',
                'subtitle' => 'ဝယ်ယူထားသော ကံစမ်းမဲ လက်မှတ် များကို စစ်ဆေးမည်',
                'image_url' => Storage::disk('public')->url('images/check_ticket_guide.png'),
                'buttons' => [
                    [
                        'type' => 'postback',
                        'title' => 'View Detail',
                        'payload' => 'VIEW_CHECK_TICKET_GUIDE_DETAIL'
                    ]
                ]
            ],
            [
                'title' => 'ကံစမ်း နှင့် ဆက်သွယ်ရန်',
                'subtitle' => 'ကံစမ်း Messenger Bot အဖွဲ့ နှင့် တိုက်ရိုက် ဆက်သွယ်ရန်မည်',
                'image_url' => Storage::disk('public')->url('images/contact_us_guide.png'),
                'buttons' => [
                    [
                        'type' => 'postback',
                        'title' => 'View Detail',
                        'payload' => 'VIEW_CONTACT_US_GUIDE_DETAIL'
                    ]
                ]
            ]
        ];

        Log::debug($content);

        $this->sendGeneric($senderPSID, $content);
    }
}
