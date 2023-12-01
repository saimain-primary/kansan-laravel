<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\TalkToAdmin;
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
        $this->sendSenderAction($senderPSID, 'typing_on');
        if (isset($event['postback'])) {
            $payloadData = $event['postback']['payload'];
            if($payloadData === 'GET_STARTED') {
                $this->sendWelcomeGeneric($senderPSID);
            } elseif($payloadData === 'VIEW_CONTACT_US_GUIDE_DETAIL') {
                $this->sendContactUsContent($senderPSID);
            } elseif($payloadData === 'TALK_TO_ADMIN') {
                $this->talkToAdmin($senderPSID);
            }
            Log::info('postback is called');
        } else {
            $message = $event['message']['text'];
            $this->sendText($senderPSID, 'Hello , This is from handleWebhookEvent , Your message is ' . $message);
        }
        $this->sendSenderAction($senderPSID, 'typing_off');

        return response('Successfully handled', 200);
    }

    protected function sendWelcomeGeneric($senderPSID)
    {
        $content = [
            [
                'title' => 'ကံစမ်းမဲ ဝယ်ရန်',
                'subtitle' => 'ကံစမ်းမဲ ဝယ်နည်းများကို အသေးစိတ်ကြည့်မည်',
                'image_url' => Storage::disk('public')->url('images/buying_ticket_guide.png'),
                'buttons' => [
                    [
                        'type' => 'web_url',
                        'title' => 'ကံစမ်းမဲ ဝယ်နည်း',
                        "url" => "https://kansan.yataicheng.info/tickets/1/orders",
                        "webview_height_ratio" => "full",
                        "messenger_extensions" => true,
                        "webview_share_button" => 'hide'
                    ]
                        // [
                        //     'type' => 'postback',
                        //     'title' => 'ကံစမ်းမဲ ဝယ်နည်း',
                        //     'payload' => 'VIEW_BUY_TICKET_GUIDE_DETAIL'
                        // ]
                    ]
            ],
            [
                'title' => 'ကံစမ်းမဲ လက်မှတ် စစ်ရန်',
                'subtitle' => 'ဝယ်ယူထားသော ကံစမ်းမဲ လက်မှတ် များကို စစ်ဆေးမည်',
                'image_url' => Storage::disk('public')->url('images/check_ticket_guide.png'),
                'buttons' => [
                    [
                        'type' => 'postback',
                        'title' => 'လက်မှတ် စစ်နည်း',
                        'payload' => 'VIEW_CHECK_TICKET_GUIDE_DETAIL'
                    ]
                ]
            ],
            [
                'title' => 'ကံစမ်း နှင့် ဆက်သွယ်ရန်',
                'subtitle' => 'ကံစမ်း Messenger Bot အဖွဲ့ နှင့် တိုက်ရိုက် ဆက်သွယ်မည်',
                'image_url' => Storage::disk('public')->url('images/contact_us_guide.png'),
                'buttons' => [
                    [
                        'type' => 'postback',
                        'title' => 'ဆက်သွယ်ရန်',
                        'payload' => 'VIEW_CONTACT_US_GUIDE_DETAIL'
                    ]
                ]
            ]
        ];


        $this->sendGeneric($senderPSID, $content);
    }

    protected function sendContactUsContent($senderPSID)
    {
        $contact = Contact::first();
        $message = "🍀 မင်္ဂလာပါ" . PHP_EOL . PHP_EOL . $contact->description . PHP_EOL . PHP_EOL . 'ဖုန်းနံပါတ် : ' . $contact->phone . PHP_EOL . 'အီးမေးလ် : ' . $contact->email . PHP_EOL . 'လိပ်စာ : ' . $contact->address;

        $this->sendButtonTemplate($senderPSID, $message, [
            [
                'type' => 'postback',
                'title' => 'တိုက်ရိုက် စကားပြောမည်',
                'payload' => 'TALK_TO_ADMIN'
            ]
        ]);
    }

    protected function talkToAdmin($senderPSID)
    {
        $this->associatingTheTalkToAdminLabel($senderPSID);
        $this->sendText($senderPSID, 'မင်္ဂလာရှိသော နေ့လေးဖြစ်ပါစေ 🍀' . PHP_EOL . PHP_EOL . 'ကံစမ်း အဖွဲ့ အား သင်နှင့် တိုက်ရိုက်ဆက်သွယ် ပေးရန်အတွက် အကြောင်းကြားပြီးပါပြီ။');
    }


}
