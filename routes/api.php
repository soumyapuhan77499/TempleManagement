<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TempleRegisterController;
use App\Http\Controllers\Api\TempleLoginController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TempleRegisterController::class)->group(function() {
  Route::post('/register-temple',  'registerTemple');
});

Route::controller(TempleLoginController::class)->group(function() {
    Route::post('/send-otp',  'sendOtp');
    Route::post('/verify-otp', 'verifyOtp');
});