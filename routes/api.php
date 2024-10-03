<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TempleRegisterController;
use App\Http\Controllers\Api\TempleLoginController;
use App\Http\Controllers\Api\TempleAboutController;
use App\Http\Controllers\Api\TempleBankController;
use App\Http\Controllers\Api\TrustMemberController;
use App\Http\Controllers\Api\TempleDailyRitualController;
use App\Http\Controllers\Api\TempleDarshanController;
use App\Http\Controllers\Api\TempleFestivalController;
use App\Http\Controllers\Api\SpecialRitualController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(TempleRegisterController::class)->group(function() {
  Route::post('/register-temple',  'registerTemple');
});

Route::controller(TempleLoginController::class)->group(function() {
    Route::post('/send-otp',  'sendOtp');
    Route::post('/verify-otp', 'verifyOtp');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/update-temple-details', [TempleAboutController::class, 'updateTempleDetails']);
});

Route::controller(TempleBankController::class)->group(function() {
  Route::post('/save-bank-details',  'saveBankDetails');
});

Route::controller(TrustMemberController::class)->group(function() {
  Route::post('/save-trust-member',  'storedata');
});

Route::controller(TempleDailyRitualController::class)->group(function() {
  Route::post('/save-daily-rituals',  'saveTempleRitual');
  Route::get('/show-daily-rituals',  'apiManageDailyRitual');
  Route::put('/update-daily-rituals', 'apiUpdateRituals');
  Route::delete('/delet-daily-rituals/{id}', 'apiDeleteRitual');
});

Route::controller(TempleDarshanController::class)->group(function() {
  Route::post('/save-darshans', 'apiSaveTempleDarshan');
});

Route::controller(TempleFestivalController::class)->group(function() {
  Route::post('/save-festival', 'apiStoreFestival');
  Route::get('/manage-festival', 'apiManageFestivals');
  Route::put('/update-festival/{id}',  'apiUpdateFestival');
});

Route::controller(SpecialRitualController::class)->group(function() {
  Route::post('/save-special-ritual', 'apiSaveSpecialRitual');
  Route::get('/manage-special-rituals', 'manageSpecialRitual');
  Route::put('/update-special-rituals/{id}', 'updateSpecialRitual');
  Route::delete('/delet-special-rituals/{id}','deleteSpecialRitual');
});
