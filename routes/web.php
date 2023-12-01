<?php

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhookController;

Route::get('/', [OrderController::class,'generateTicket']);
Route::get('tickets/{id}/orders', [OrderController::class,'placeOrder']);
