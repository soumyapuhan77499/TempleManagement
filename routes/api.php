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
use App\Http\Controllers\Api\InsideTempleController;
use App\Http\Controllers\Api\TempleVendorsControllerller;
use App\Http\Controllers\Api\TempleExpenditureController;
use App\Http\Controllers\Api\TempleDevoteesController;
use App\Http\Controllers\Api\TempleBannerController;
use App\Http\Controllers\Api\TempleInventoryController;
use App\Http\Controllers\Api\TempleHundiController;
use App\Http\Controllers\Api\TempleMandapController;
use App\Http\Controllers\Api\TemplePoojaController;
use App\Http\Controllers\Api\TempleHundiCollectionController;
use App\Http\Controllers\Api\TempleDonationController;
use App\Http\Controllers\Api\TemplePrasadController;
use App\Http\Controllers\Api\TempleCommitteeController;
use App\Http\Controllers\Api\ReportHundiCollection;
use App\Http\Controllers\Api\PanjiController;

// website

use App\Http\Controllers\Api\WebsiteBannerController;
use App\Http\Controllers\Api\TempleInformationController;
use App\Http\Controllers\Api\QuickServiceController;



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


Route::middleware(['auth:sanctum'])->group(function () {
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

     
      Route::controller(TempleDailyRitualController::class)->group(function() {
        Route::post('/save-daily-rituals',  'saveTempleRitual');
        Route::get('/show-daily-rituals',  'apiManageDailyRitual');
        Route::put('/update-daily-rituals', 'apiUpdateRituals');
        Route::delete('/delet-daily-rituals/{id}', 'apiDeleteRitual');
      });

      Route::controller(TempleDarshanController::class)->group(function() {
        Route::post('/save-darshans', 'apiSaveTempleDarshan');
        Route::get('/manage-darshan', 'ManageTempleDarshan')->name('templedarshan.manage');
        Route::put('/update-darshan', 'updateTempleDarshan')->name('templedarshan.update');
        Route::delete('/delete-darshan/{id}', 'deleteTempleDarshan');
      });

      Route::controller(TempleFestivalController::class)->group(function() {
        Route::post('/save-festival', 'apiStoreFestival');
        Route::get('/manage-festival', 'apiManageFestivals');
        Route::put('/update-festival/{id}',  'apiUpdateFestival');
        Route::delete('/delete-festival/{id}',  'destroy');
      });

      Route::controller(SpecialRitualController::class)->group(function() {
        Route::post('/save-special-ritual', 'apiSaveSpecialRitual');
        Route::get('/manage-special-rituals', 'manageSpecialRitual');
        Route::put('/update-special-rituals/{id}', 'updateSpecialRitual');
        Route::delete('/delet-special-rituals/{id}','deleteSpecialRitual');
        Route::get('/edit-special-ritual/{id}', 'editSpecialRitual');
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

      Route::controller(TemplePoojaController::class)->group(function() {
        Route::post('/add-pooja',  'storePoojaAPI');
        Route::get('/manage-pooja', 'managePoojaAPI');
        Route::post('/update-pooja/{id}',  'updatePooja');
        Route::delete('/delete-pooja/{id}', 'destroyPooja');
      });

      Route::controller(TempleBannerController::class)->group(function() {
        Route::post('/add-banner','storeBanner');
        Route::get('/manage-banner',  'manageBanner');
        Route::post('/update-banner/{id}',  'updateBanner');
        Route::delete('/delete-banner/{id}', 'deleteBanner');
      });

      Route::controller(TempleInventoryController::class)->group(function() {
        Route::post('/add-inventory-category','storeCategory')->name('templeuser.storeCategory');
        Route::post('/update-inventory-category/{id}','updateCategory')->name('templeuser.updateCategory');
        Route::get('/manage-inventory-category', 'mngInventoryCategory')->name('templeuser.manageInventoryCategory');
        Route::delete('/delete-inventory-category/{id}',  'destdestroyInventoryCategoryroy')->name('templeuser.destroyInventoryCategory');

        Route::post('/add-inventory',  'storeInventory')->name('templeuser.storeInventory');
      Route::get('/manage-inventory', 'mngInventory')->name('templeuser.manageInventory');
      Route::post('/update-inventory/{id}','updateInventory')->name('templeuser.updateInventory');
      Route::delete('/delete-inventory/{id}',  'destdestroyInventory')->name('templeuser.destroyInventory');

      });

      Route::controller(InsideTempleController::class)->group(function() {
        Route::post('/add-inside-temple', 'saveInsideTemple');
        Route::get('/manage-inside-temple', 'manageInsideTemple');
        Route::post('/update-inside-temple/{id}', 'updateInsideTemple');
        Route::delete('/delete-inside-temple/{id}', 'deleteInsideTemple');
      });

      Route::controller(TempleDevoteesController::class)->group(function() {
        Route::post('/add-devotee', 'storedata');
        Route::post('/update-devotee/{id}', 'update')->name('devotees.update');
        Route::get('/manage-devotees', 'ManageDevotees');
        Route::delete('/delete-devotees/{id}',  'destroy')->name('templedevotees.destroy');
      });

      Route::controller(ReportHundiCollection::class)->group(function() {
        Route::get('/report-hundi-collection', 'reportHundiCollection');
        Route::post('/search-hundi-collection','searchHundiCollection');
        Route::get('/cash-tray/{id}',  'showCashTray');
      });

      Route::controller(TempleExpenditureController::class)->group(function() {
        Route::post('/save-temple-expenditure', 'saveExpenditure')->name('templeexpenditure.save');
        Route::get('/manage-temple-expenditure', 'manageExpenditure')->name('templeexpenditure.manage');
        Route::put('/update-temple-expenditure/{id}', 'updateExpenditure')->name('templeexpenditure.update');  // For updating expenditure
        Route::get('/edit-temple-expenditure/{id}', 'editExpenditure')->name('templeexpenditure.edit');  // For retrieving expenditure details
        Route::delete('/delete-temple-expenditure/{id}', 'deleteExpenditure')->name('templeexpenditure.delete'); // For deleting expenditure
        Route::get('/vendors', 'getVendors')->name('templevendors.get');
        Route::get('/invoice-temple-expenditure/{id}', 'printInvoice')->name('templeexpenditure.invoice');
      });
       
      Route::controller(TempleVendorsControllerller::class)->group(function() {
        Route::post('/save-temple-vendors', 'saveVendorDetails')->name('templevendors.save');
        Route::get('/manage-temple-vendors', 'manageVendorDetails')->name('templevendors.manage');
        Route::get('/edit-temple-vendors/{id}', 'editVendorDetails')->name('templevendor.edit');
        Route::put('/update-temple-vendors/{id}', 'updateVendorDetails')->name('templevendor.update');
        Route::delete('/delete-temple-vendors/{id}', 'deleteVendorDetails')->name('templevendor.delete');
      });

      Route::controller(TempleHundiController::class)->group(function() {
        Route::post('/save-hundi', 'saveHundi');
        Route::put('/update-hundi/{id}', 'updateHundi');
        Route::get('/manage-hundi', 'manageHundi');
        Route::delete('/delete-hundi/{id}',  'deleteHundi');
      });

      Route::controller(TempleHundiCollectionController::class)->group(function() {
        Route::post('/save-hundi-collection', 'saveHundiCollection');
        Route::get('/hundi-list', 'hundiList');
      });

      Route::controller(PanjiController::class)->group(function() {
        Route::get('/get-panjidetails', 'getPanjiDetails');
      });

        Route::post('/store-cash-donation', [TempleDonationController::class, 'storeCashDonation'])->name('api.templedonation.store');
        Route::get('/cash-donations', [TempleDonationController::class, 'manageCashDonations'])->name('api.templedonation.manage');
        Route::put('/update-cash-donation/{id}', [TempleDonationController::class, 'updateDonation'])->name('api.templedonation.update');
        Route::delete('/delete-cash-donation/{id}', [TempleDonationController::class, 'deleteDonation'])->name('api.templedonation.delete');
   
        Route::post('/store-online-donation', [TempleDonationController::class, 'storeOnlineDonation']);
        Route::get('/online-donations', [TempleDonationController::class, 'manageOnlineDonations']);
        Route::put('/update-online-donation/{id}', [TempleDonationController::class, 'updateDonationOnline']);
        Route::delete('/delete-online-donation/{id}', [TempleDonationController::class, 'deleteDonationOnline']);

        Route::post('/store-item-donation', [TempleDonationController::class, 'storeItemDonation']);
        Route::get('/item-donations', [TempleDonationController::class, 'manageItemDonations']);
        Route::post('/update-item-donation/{id}', [TempleDonationController::class, 'updateDonationItem']);
        Route::delete('/delete-item-donation/{id}', [TempleDonationController::class, 'deleteDonationItem']);

        Route::post('/store-temple-prasad', [TemplePrasadController::class, 'store']);
        Route::get('/temple-prasads', [TemplePrasadController::class, 'manageprasad']);
        Route::put('/update-temple-prasad/{id}', [TemplePrasadController::class, 'update']);
        Route::delete('/delete-temple-prasad/{id}', [TemplePrasadController::class, 'destroy']);

        Route::post('store-trust-member', [TrustMemberController::class, 'storeTrustMember']);
        Route::get('trust-members', [TrustMemberController::class, 'getTrustMembers']);
        Route::put('update-trust-member/{id}', [TrustMemberController::class, 'updateTrustMember']);
        Route::delete('delete-trust-members/{id}', [TrustMemberController::class, 'deleteTrustMember']);

        Route::get('/committee-details', [TempleCommitteeController::class, 'addnewcommittee']);
        Route::post('/save-committee', [TempleCommitteeController::class, 'saveCommittee']);
        Route::get('/committee-members', [TempleCommitteeController::class, 'getcommitteemember']);
        Route::post('/store-committee-member', [TempleCommitteeController::class, 'storecommitteemember']);
        Route::get('/mng-committee-hierarchy', [TempleCommitteeController::class, 'mngcommitteehierarchy']);
        Route::post('/committee/hierarchy-position/{id}', [TempleCommitteeController::class, 'saveCommitteeHierarchyPosition']);
});

Route::controller(WebsiteBannerController::class)->group(function() {
  Route::get('/get-home-section', 'manageWebsiteBanner');
});

Route::controller(TempleInformationController::class)->group(function() {
  Route::get('/get-festival', 'getFestival')->name('templeinformation.getFestival');
  Route::get('/get-matha', 'getMathaList')->name('templeinformation.getMatha');
  Route::get('/get-nijoga', 'getNijogaList')->name('templeinformation.getNijoga');
  Route::get('/get-temple-about',  'getTempleAbout')->name('quickservice.getTempleAbout');
});

Route::controller(QuickServiceController::class)->group(function() {
  Route::get('/get-parking', 'getParkingList')->name('quickservice.getParkingList');
  Route::get('/get-accomodation', 'getAccomodationList')->name('quickservice.getAccomodation');
  Route::get('/get-commute', 'getCommuteList')->name('quickservice.getCommute');
  Route::get('/get-emergency', 'getEmergencyContacts')->name('quickservice.getEmergencyContacts');
  Route::get('/get-all-service-list', 'getPublicServiceList')->name('quickservice.getPublicServiceList');
  Route::get('/get-maha-prasad', 'getTemplePrasadList')->name('quickservice.getTemplePrasadList');
  Route::get('/get-panji', 'getPanji')->name('quickservice.getPanji');
  Route::get('/get-darshan', 'getDarshan')->name('quickservice.getDarshan');
});

