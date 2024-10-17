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
use App\Http\Controllers\Api\TempleNewsController;
use App\Http\Controllers\Api\TempleSocialMediaController;

use App\Http\Controllers\Api\TempleMandapController;



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
Route::controller(TempleSocialMediaController::class)->group(function() {
  Route::get('/social-media', 'socialmedia');
  Route::post('/social-media/update', 'updateSocialMediaUrls');
  Route::post('/update-photos-videos',  'updatePhotosvideos');
  Route::get('/temple-photos-videos', 'getTemplePhotos');

});
Route::controller(TempleBankController::class)->group(function() {
  Route::post('/save-bank-details', 'saveBankDetails');
  Route::get('/get-bank-details', 'getBankDetails');
  Route::put('/update-bank-details/{id}', 'updateBank');
  Route::delete('/delete-bank/{id}', 'deleteBank');
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

Route::controller(TempleNewsController::class)->group(function() {
  Route::post('/store-news', 'storeNews');
  Route::get('/manage-news', 'manageNews');
  Route::put('/news/{id}', 'updateNews');
  Route::delete('/delete-news/{id}', 'destroyNews');
});

Route::controller(TempleMandapController::class)->group(function() {
  Route::post('/add-mandap', 'storeMandap');
  Route::get('/mandaps',  'manageMandap');
  Route::put('/mandaps/{id}',  'update');
  Route::delete('/mandaps/{id}',  'destroy');
});

