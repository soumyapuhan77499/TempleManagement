<?php


use Illuminate\Support\Facades\Route;
## Home Controller


## Temple user Controller


## Superadmin COntroller
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Superadmin\TempleRequestController;



## Home pages Routes
Route::get('/', function () {
    return view('index');
});


## Temple User Routes



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




