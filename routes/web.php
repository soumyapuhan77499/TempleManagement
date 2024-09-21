<?php


use Illuminate\Support\Facades\Route;
## Home Controller


## Temple user Controller
use App\Http\Controllers\TempleUser\TempleUserController;
use App\Http\Controllers\TempleUser\TempleRegistrationController;
use App\Http\Controllers\TempleUser\SocialMediaController;
use App\Http\Controllers\TempleUser\TrustMemberController;
use App\Http\Controllers\TempleUser\TempleFestivalController;
use App\Http\Controllers\TempleUser\TempleNewsController;
use App\Http\Controllers\TempleUser\TempleDarshanController;

use App\Http\Controllers\TempleUser\TempleBankController;
use App\Http\Controllers\TempleUser\TempleDailyRitualController;
use App\Http\Controllers\TempleUser\TempleYearlyRitualController;




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
        Route::put('/temple-about-details', 'updateTempleDetails')->name('temple_about_details.update');
    });
    Route::controller(SocialMediaController::class)->group(function() {
        Route::get('/social-media', 'socialmedia')->name('templeuser.socialmedia');
        Route::put('/temple-social-media/{temple_id}','updateTempleSocialMedia')->name('temple_social_media.update');
    });
    Route::controller(TrustMemberController::class)->group(function() {
        Route::get('/add-trust-member', 'addtrustmember')->name('templeuser.addtrustmember');
        Route::post('/add-trust-member', 'storedata')->name('templeuser.storeTrustMember');
        Route::get('/manage-trust-member', 'managetrustmember')->name('templeuser.managetrustmember');
        Route::get('/trust-member/edit/{id}', 'edit')->name('templeuser.editTrustMember'); // Edit route
        Route::put('/trust-member/update/{id}', 'update')->name('templeuser.updateTrustMember'); // Update route
        Route::delete('/trust-member/delete/{id}', 'destroy')->name('templeuser.deleteTrustMember'); // Delete route
        
    });
    Route::controller(TempleFestivalController::class)->group(function() {
        Route::get('/add-temple-festival', 'addFestival')->name('templefestival.addFestival');
        Route::post('/add-temple-festival', 'storedata')->name('templefestival.storeFestival');
        Route::get('/manage-festivals', 'managefestivals')->name('templefestival.managefestivals');
        Route::get('/festival/{id}/edit', 'edit')->name('templefestival.edit');
        Route::put('/festival/{id}', 'update')->name('templefestival.update');
        Route::delete('/festival/{id}', 'destroy')->name('templefestival.destroy');
    });
    Route::controller(TempleNewsController::class)->group(function() {
        Route::get('/add-temple-news', 'addNews')->name('templenews.addNews');
        Route::post('/store-temple-news', 'storeNews')->name('templenews.storeNews');
        Route::get('/manage-temple-news', 'manageNews')->name('templenews.manageNews');
        Route::get('/edit-temple-news/{id}', 'editNews')->name('templenews.editNews');
        Route::post('/update-temple-news/{id}', 'updateNews')->name('templenews.updateNews');
        Route::delete('/delete-temple-news/{id}', 'destroyNews')->name('templenews.destroyNews');
       
    });

    Route::controller(TempleBankController::class)->group(function() {
        Route::get('/temple-bank', 'bankdetails')->name('templeuser.bankdetails');
        Route::post('/savebankdetails', 'savebankdetails');
    });

    Route::controller(TempleDailyRitualController::class)->group(function() {
        Route::get('/daily-ritual', 'dailyritual')->name('templeuser.add-dailyritual');
        Route::post('/savetempleritual',  'saveTempleRitual')->name('templeuser.savetempleritual');
        Route::get('/manage-daily-ritual', 'manageDailyRitual')->name('templeuser.manage-dailyritual');
        Route::get('/daily-rituals/{id}/edit','edit')->name('edit.daily-ritual');
        Route::post('/updateRituals', 'updateRituals')->name('templeuser.updateRituals');
        Route::post('/deleteRitual', 'deleteRitual')->name('templeuser.deleteRitual');
    });

    Route::controller(TempleYearlyRitualController::class)->group(function() {
        Route::get('/yearly-ritual', 'yearlyritual')->name('templeuser.add-yearlyritual');
        Route::get('/manage-yearly-ritual', 'manageYearlyRitual')->name('templeuser.manage-yearlyritual');
        Route::post('/savespecialritual', 'saveSpecialRitual')->name('templeuser.savespecialritual');
        Route::get('/yearly-rituals/{id}/edit','editYearlyRitual')->name('edit.yearly-ritual');
        Route::delete('/yearly-rituals/{id}',  'deletYearlyRitual')->name('delete.yearly-ritual');
        Route::put('/updateyearlyritual/{id}',  'updateYearlyRitual')->name('update.yearly-ritual');
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




