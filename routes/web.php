<?php


use Illuminate\Support\Facades\Route;
## Home Controller


## Temple user Controller
use App\Http\Controllers\TempleUser\TempleUserController;
use App\Http\Controllers\TempleUser\TempleRegistrationController;
use App\Http\Controllers\TempleUser\SocialMediaController;


## Superadmin COntroller
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Superadmin\TempleRequestController;



## Home pages Routes
Route::get('/', function () {
    return view('index');
});


## Temple User Routes

Route::controller(TempleRegistrationController::class)->group(function() {
    Route::get('templeuser/temple-register', 'templeregister')->name('temple-register');
    Route::post('templeuser/temple-register','registerTemple');
    // routes/web.php
    Route::post('/temple-logout','logout')->name('temple.logout');

});

Route::controller(TempleUserController::class)->group(function () {
    // Public routes (accessible without authentication)
    Route::get('templeuser/templelogin', 'templelogin')->name('templelogin');
    Route::post('templeuser/send-otp', 'sendOtp');
    Route::post('templeuser/verify-otp', 'verifyOtp');

});
Route::prefix('templeuser')->middleware('auth:temples')->group(function () {
    Route::controller(TempleUserController::class)->group(function() {
        Route::get('/temple-dashboard', 'templedashboard')->name('templedashboard');
    });
    Route::controller(SocialMediaController::class)->group(function() {
        Route::get('/social-media', 'socialmedia')->name('templeuser.socialmedia');
    });
  
});


## super admin Routes
Route::controller(SuperAdminController::class)->group(function() {
        
    Route::get('superadmin/', 'superadminlogin')->name('superadminlogin');
    Route::post('superadmin/authenticate', 'authenticate')->name('authenticate');
    Route::get('superadmin/dashboard', 'dashboard')->name('dashboard');
    Route::post('superadmin/logout', 'logout')->name('superadmin.logout');
});

Route::prefix('superadmin')->middleware(['superadmin'])->group(function () {
    Route::controller(TempleRequestController::class)->group(function() {
        
        Route::get('/temple-requests', 'templerequests')->name('templerequests');
    });
  
});




