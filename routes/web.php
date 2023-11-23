<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/webhook', [WebhookController::class,'getWebhook']);
Route::post('/webhook', [WebhookController::class,'postWebhook']);
