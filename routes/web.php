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
use App\Http\Controllers\TempleUser\TempleMandapController;
use App\Http\Controllers\TempleUser\TemplePoojaController;
use App\Http\Controllers\TempleUser\TempleDarshanController;
use App\Http\Controllers\TempleUser\TempleBannerController;
use App\Http\Controllers\TempleUser\TemplePrasadController;
use App\Http\Controllers\TempleUser\TempleInventoryController;
use App\Http\Controllers\TempleUser\TempleVendorController;
use App\Http\Controllers\TempleUser\InsideTempleController;
use App\Http\Controllers\TempleUser\TempleDevoteesController;
use App\Http\Controllers\TempleUser\TempleTrustController;
use App\Http\Controllers\TempleUser\TempleDonationController;
use App\Http\Controllers\TempleUser\TempleCommitteeController;
use App\Http\Controllers\TempleUser\TempleHundiController;


use App\Http\Controllers\TempleUser\TempleBankController;
use App\Http\Controllers\TempleUser\TempleDailyRitualController;
use App\Http\Controllers\TempleUser\TempleYearlyRitualController;
use App\Http\Controllers\TempleUser\TempleExpenditureController;

## Superadmin COntroller
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Superadmin\TempleRequestController;
use App\Http\Controllers\Superadmin\TempleTitleController;

## Home pages Routes
Route::get('/', function () {
    return view('index');
});
Route::get('/contact', function () {
    return view('contactus');
});
Route::get('/package', function () {
    return view('package');
});
Route::get('/about', function () {
    return view('about');
});


## Temple User Routes

Route::controller(TempleRegistrationController::class)->group(function() {
    Route::get('templeuser/temple-register', 'templeregister')->name('temple-register');
    Route::post('templeuser/temple-register','registerTemple');
    Route::post('/temple-logout','logout')->name('temple.logout');
});

Route::controller(TempleUserController::class)->group(function () {
    // Public routes (accessible without authentication)
    Route::get('templeuser/templelogin', 'templelogin')->name('templelogin');
    Route::post('templeuser/send-otp', 'sendOtp');
    Route::post('templeuser/verify-otp', 'verifyOtp');
});

Route::prefix('templeuser')->middleware('templeauth')->group(function () {

    Route::controller(TempleUserController::class)->group(function() {
        Route::get('/temple-dashboard', 'templedashboard')->name('templedashboard');
        Route::get('/temple-about', 'templeabout')->name('templeuser.templeAbout');
        Route::put('/temple-about-details', 'updateTempleDetails')->name('temple_about_details.update');
    });

    Route::controller(SocialMediaController::class)->group(function() {
        Route::get('/social-media', 'socialmedia')->name('templeuser.socialmedia');
        Route::put('/temple-photos-videos',  'updatePhotosvideos')->name('temple.updatePhotosvideos');
        Route::post('/remove-media',  'removeMedia')->name('remove.media');
        Route::get('/temple-photos', 'templephotos')->name('templeuser.photos');
        Route::put('/temple-social-media/update', 'updateSocialMediaUrls')->name('temple.social-media.update');
    });

    Route::controller(TrustMemberController::class)->group(function() {
        Route::get('/add-trust-member', 'addtrustmember')->name('templeuser.addtrustmember');
        Route::post('trustmembers/{id}/save-hierarchy', 'saveHierarchyPosition')->name('templeuser.saveHierarchyPosition');
        Route::post('/store-trust-member', 'storedata')->name('templeuser.storeTrustMember');
        Route::get('/manage-trust-member', 'managetrustmember')->name('templeuser.managetrustmember');
        Route::get('/manage-hierarchy', 'mnghierarchy')->name('templeuser.mnghierarchy');
        Route::post('/deactivate-trust-members',  'deactivateTrustMembers')->name('templeuser.deactivateTrustMembers');
        Route::get('/trust-member/edit/{id}', 'edit')->name('templeuser.editTrustMember'); // Edit route
        Route::put('/trust-member/update/{id}', 'update')->name('templeuser.updateTrustMember'); // Update route
        Route::delete('/trust-member/delete/{id}', 'destroy')->name('templeuser.deleteTrustMember'); // Delete route
    });

    Route::controller(TempleCommitteeController::class)->group(function() {
        Route::post('/save-temple-committee', 'saveCommittee')->name('templeuser.savecommittee');
        Route::get('/add-temple-committee', 'addnewcommittee')->name('templeuser.addnewcommittee');
        Route::get('/add-committee-member', 'addcommitteemember')->name('templeuser.addcommitteemember');
        Route::post('/add-committee-member', 'storecommitteemember')->name('templeuser.storecommitteeMember');
        Route::get('/manage-committee-hierarchy', 'mngcommitteehierarchy')->name('templeuser.mngcommitteehierarchy');
        Route::post('committeemembers/{id}/save-committee-hierarchy', 'saveCommitteeHierarchyPosition')->name('templeuser.saveCommitteeHierarchyPosition');
        Route::get('/manage-committee-member', 'managecommitteemember')->name('templeuser.managecommitteemember');
        Route::post('/deactivate-committee-members',  'deactivateCommitteeMembers')->name('templeuser.deactivateCommitteeMembers');

        Route::get('/committee-member/edit/{id}', 'editcommittemember')->name('templeuser.editcommitteeMember'); // Edit route
        Route::put('/committee-member/update/{id}', 'updatecommittemember')->name('templeuser.updatecommitteeMember'); // Update route
        Route::delete('/committee-member/delete/{id}', 'destroycommittemember')->name('templeuser.deletecommitteeMember'); // Delete route

        Route::get('/add-temple-sub-committee', 'addsubcommittee')->name('templeuser.addsubcommittee');
        Route::post('/store-temple-sub-committee', 'storesubcommittee')->name('templeuser.storesubcommittee');

        Route::post('/add-other-member', 'storeothermember')->name('templeuser.storeothermember');

       
    });

    Route::controller(TempleBankController::class)->group(function() {
        Route::get('/add-temple-bank', 'addbank')->name('templeuser.bankdetails');
        Route::get('/manage-temple-bank', 'managebank')->name('templeuser.managebank');
        Route::post('/save-temple-bank', 'savebank');
        Route::get('/edit-temple-bank/{id}',  'editbank')->name('templeuser.editbank');
        Route::delete('/delet-temple-bank/{id}', 'deletebank')->name('templeuser.deletebank');
        Route::put('/update-temple-bank/{id}', 'updatebank')->name('templeuser.updatebank');
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

    Route::controller(TempleMandapController::class)->group(function() {
        Route::get('/add-temple-mandap', 'addmandap')->name('templemandap.mandap');
        Route::post('/store-temple-mandap', 'storeMandap')->name('templemandap.storeMandap');
        Route::get('/manage-temple-mandap', 'manageMandap')->name('templemandap.managemandap');
         Route::get('/mandap/edit/{id}', 'edit')->name('templemandap.edit');
        Route::put('/mandap/update/{id}', 'update')->name('templemandap.update');
        Route::delete('/mandap/destroy/{id}', 'destroy')->name('templemandap.destroy');
    });

    Route::controller(TemplePoojaController::class)->group(function() {
        Route::get('/add-temple-pooja', 'addPooja')->name('templepooja.pooja');
        Route::post('/store-temple-pooja', 'storePooja')->name('templepooja.storepooja');
        Route::get('/edit-temple-pooja/{id}', 'editPooja')->name('templepooja.editpooja');
        Route::post('/update-temple-pooja/{id}', 'updatePooja')->name('templepooja.updatepooja');
        Route::delete('/delete-temple-pooja/{id}', 'destroyPooja')->name('templepooja.destroypooja');
        Route::get('/manage-temple-pooja', 'managePooja')->name('templepooja.managepooja');
    });

    Route::controller(TempleBannerController::class)->group(function() {
        Route::get('/add-temple-banner', 'addBanner')->name('templebanner.banner');
        Route::post('/store-temple-banner', 'storeBanner')->name('templebanner.storeBanner');
        Route::get('/edit-temple-banner/{id}', 'editBanner')->name('templebanner.editBanner');
        Route::post('/update-temple-banner/{id}', 'updateBanner')->name('templebanner.updateBanner');
        Route::delete('/delete-temple-banner/{id}', 'deleteBanner')->name('templebanner.deleteBanner');
        Route::get('/manage-temple-banner', 'manageBanner')->name('templebanner.managebanner');
    });

    Route::controller(TemplePrasadController::class)->group(function() {
        Route::get('/add-temple-prasad', 'addPrasad')->name('templeprasad.prasad');
        Route::post('/store-temple-prasad', 'store')->name('templeprasad.store');
    });

    Route::controller(TempleDonationController::class)->group(function() {
        Route::get('/add-temple-donation', 'adddonation')->name('templedonation.donation');
        Route::post('/store-temple-cash-donation', 'storeCashDonation')->name('templedonation.storeCashDonation');
        Route::get('/manage-temple-cash-donations', 'managecashDonations')->name('templedonation.manage');
        Route::get('temple-donations/{id}/edit', 'editDonation')->name('templedonation.edit');
        Route::put('temple-donations/{id}', 'updateDonation')->name('templedonation.update');
        Route::delete('temple-donations/{id}', 'deleteDonation')->name('templedonation.destroy');

        Route::post('/store-temple-online-donation', 'storeonlineDonation')->name('templedonation.storeonlineDonation');
        Route::get('/manage-temple-online-donations', 'manageonlineDonations')->name('templedonation.manageonline');
        Route::get('temple-donations-online/{id}/edit', 'editDonationonline')->name('templedonation.editonline');
        Route::put('temple-donations-online/{id}', 'updateDonationonline')->name('templedonation.updateonline');
        Route::delete('temple-donations-online/{id}', 'deleteDonationonline')->name('templedonation.destroyonline');

        Route::post('/store-temple-item-donation', 'storeitemDonation')->name('templedonation.storeitemDonation');
        Route::get('/manage-temple-item-donations', 'manageitemDonations')->name('templedonation.manageitem');
        Route::get('temple-donations-item/{id}/edit', 'editDonationitem')->name('templedonation.edititem');
        Route::put('temple-donations-item/{id}', 'updateDonationitem')->name('templedonation.updateitem');
        Route::delete('temple-donations-item/{id}', 'deleteDonationitem')->name('templedonation.destroyitem');

    });
    
    Route::controller(TempleInventoryController::class)->group(function() {
        Route::get('/manage-inventory-category', 'mnginventorycategory')->name('templeinventory.mnginventorycategory');
        Route::post('/addCategory', 'store')->name('templeinventory.addCategory');
        Route::put('/updateCategory/{id}', 'update');
        Route::put('/deleteCategory/{id}', 'destroy');
        Route::get('/add-temple-inventory', 'addInventory')->name('templeinventory.inventory');
        Route::post('/store-temple-inventory', 'storeInventory')->name('templeinventory.storeinventory');
        Route::get('/edit-temple-inventory/{id}', 'editinventory')->name('templeinventory.editinventory');
        Route::put('/templeinventory/{id}/update', 'updateinventory')->name('templeinventory.updateinventory');
        Route::delete('/delete-temple-inventory/{id}', 'deleteinventory')->name('templeinventory.deleteinventory');
        Route::get('/manage-temple-inventory', 'manageInventory')->name('templeinventory.manageinventory');
    });

    Route::controller(TempleDevoteesController::class)->group(function() {
        Route::get('/add-temple-devotees', 'adddevotees')->name('templedevotees.adddevotees');
        Route::post('/store-temple-devotees', 'storedata')->name('templedevotees.storedevotees');
        Route::get('/manage-temple-devotees', 'managedevotees')->name('templedevotees.managedevotees');
        Route::get('/devotees/{id}/edit', 'edit')->name('templedevotees.edit');
        Route::put('/devotees/{id}', 'update')->name('templedevotees.update');
        Route::delete('/devotees/{id}', 'destroy')->name('templedevotees.destroy');
    });

    Route::controller(TempleDailyRitualController::class)->group(function() {
        Route::get('/daily-ritual', 'dailyritual')->name('templeuser.add-dailyritual');
        Route::post('/savetempleritual',  'saveTempleRitual')->name('templeuser.savetempleritual');
        Route::get('/manage-daily-ritual', 'manageDailyRitual')->name('templeuser.manage-dailyritual');
        Route::get('/daily-rituals/{id}/edit','edit')->name('edit.daily-ritual');
        Route::post('/updateRituals', 'updateRituals')->name('templeuser.updateRituals');
        Route::post('/deleteRitual/{id}', 'deleteRitual')->name('templeuser.deleteRitual');
    });

    Route::controller(TempleYearlyRitualController::class)->group(function() {
        Route::get('/yearly-ritual', 'yearlyritual')->name('templeuser.add-yearlyritual');
        Route::get('/manage-yearly-ritual', 'manageYearlyRitual')->name('templeuser.manage-yearlyritual');
        Route::post('/savespecialritual', 'saveSpecialRitual')->name('templeuser.savespecialritual');
        Route::get('/yearly-rituals/{id}/edit','editYearlyRitual')->name('edit.yearly-ritual');
        Route::delete('/yearly-rituals/{id}',  'deletYearlyRitual')->name('delete.yearly-ritual');
        Route::put('/updateyearlyritual/{id}',  'updateYearlyRitual')->name('update.yearly-ritual');
    });

    Route::controller(TempleDarshanController::class)->group(function() {
        Route::get('/add-temple-darshan', 'templeDarshan')->name('add-templedarshan');
        Route::get('/manage-temple-darshan', 'ManageTempleDarshan')->name('manage-templedarshan');
        Route::post('/savetempledarshan','saveTempleDarshan')->name('templeuser.savetempledarshan');
        Route::post('/update-darshan', 'updateTempleDarshan')->name('templeuser.updateDarshan');
        Route::post('/delete-darshan/{id}',  'deleteTempleDarshan')->name('templeuser.deleteDarshan');
    });

    Route::controller(TempleVendorController::class)->group(function() {
        Route::get('/add-vendor-details', 'addVendorDetails')->name('templeuser.addvendor');
        Route::post('/save-vendor-details', 'saveVendorDetails')->name('templeuser.saveVendorDetails');
        Route::get('/manage-vendor-details', 'manageVendorDetails')->name('templeuser.managevendor');
        Route::post('/delete-temple-vendor/{imad}', 'deleteVendorDetails')->name('templeuser.deletevendor');
        Route::get('/edit-temple-vendor/{id}', 'editVendorDetails')->name('templeuser.editvendor');
        Route::put('/update-temple-vendor/{id}', 'updateVendorDetails')->name('templeuser.updateVendorDetails');
    });

    Route::controller(InsideTempleController::class)->group(function() {
        Route::get('/add-inside-temple', 'addInsideTemple')->name('templeuser.addinsidetemple');
        Route::post('/save-inside-temple', 'saveInsideTemple')->name('templeuser.saveinsidetemple');
        Route::get('/manage-inside-temple', 'manageInsideTemple')->name('templeuser.manageinsidetemple');
        Route::post('/delete-inside-temple/{id}', 'deleteInsideTemple')->name('templeuser.deleteinsidetemple');
        Route::get('/edit-inside-temple/{id}',  'editInsideTemple')->name('templeuser.editinsidetemple');
        Route::post('/update-inside-temple/{id}', 'updateInsideTemple')->name('templeuser.updateinsidetemple');
    });

    Route::controller(TempleExpenditureController::class)->group(function() {
        Route::get('/add-temple-expenditure', 'addExpenditure')->name('templeuser.addexpenditure');
        Route::get('/manage-temple-expenditure', 'manageExpenditure')->name('templeuser.manageexpenditure');
        Route::post('/save-temple-expenditure', 'saveExpenditure')->name('templeuser.saveexpenditure');
        Route::get('/find-vendor-name', 'getVendors')->name('templeuser.getVendors'); // Corrected route
        Route::get('/printInvoice/{id}','printInvoice')->name('templeuser.printInvoice');
        Route::get('/edit-temple-expenditure/{id}',  'editExpenditure')->name('templeuser.editexpenditure');
        Route::post('/delete-temple-expenditure/{id}', 'deleteExpenditure')->name('templeuser.deleteexpenditure');
        Route::put('/update-temple-expenditure/{id}', 'updateExpenditure')->name('templeuser.updateexpenditure');
    });

    Route::controller(TempleHundiController::class)->group(function() {
        Route::get('/add-hundi', 'addHundi')->name('templeuser.addhundi');
        Route::get('/manage-hundi', 'manageHundi')->name('templeuser.managehundi');
        Route::get('/edit-hundi/{id}', 'editHundi')->name('templeuser.edithundi');
        Route::put('/update-hundi/{id}', 'updateHundi')->name('templeuser.updatehundi');
        Route::post('/delete-hundi/{id}', 'deleteHundi')->name('templeuser.delethundi');
        Route::post('/save-temple-hundi','saveHundi')->name('templeuser.savehundi');
        Route::get('/add-temple-hundi-collection', 'addHundiCollection')->name('templeuser.addhundicollection');
        Route::post('/save-temple-hundi-collection', 'saveHundiCollection')->name('templeuser.savehundicollection');
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
        Route::post('/update-temple-status/{id}/{status}', 'updateStatus')->name('updateTempleStatus');
    });

    Route::controller(TempleTitleController::class)->group(function() {
        Route::get('/manage-temple-title', 'mngtitle')->name('templetitle.mngtitle');
        Route::post('/addTitle', 'addTitle')->name('templetitle.addTitle');
        Route::put('/updateTitle/{id}', 'updateTitle')->name('templetitle.updateTitle');
        Route::put('/deleteTitle/{id}', 'deleteTitle')->name('templetitle.deleteTitle');
    });
});




