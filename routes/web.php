<?php


use Illuminate\Support\Facades\Route;
## Home Controller


## Temple user Controller
use App\Http\Controllers\TempleUser\TempleUserController;
use App\Http\Controllers\TempleUser\TempleRegistrationController;

## Superadmin COntroller
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Superadmin\TempleRequestController;



## Home pages Routes
Route::get('/', function () {
    return view('index');
});


## Temple User Routes

Route::controller(TempleRegistrationController::class)->group(function() {
    Route::get('templeuser/temple-register', 'templeregister')->name('templeregister');
    Route::post('/temple-register','registerTemple');
});

Route::controller(TempleUserController::class)->group(function () {
    // Public routes (accessible without authentication)
    Route::get('userlogin', 'userlogin')->name('userlogin');
    Route::post('/send-otp', 'sendOtp');
    Route::post('/verify-otp', 'verifyOtp');

    // Protected routes (accessible only after authentication)
    Route::middleware('auth:temples')->group(function () {
        Route::get('user/user-dashboard', 'userdashboard')->name('userdashboard');
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




