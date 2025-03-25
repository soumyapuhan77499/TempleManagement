<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NitiMaster;
use App\Models\SebaMaster;
use App\Models\TempleBanner;
use App\Models\NearByTemple;
use App\Models\HundiCollection;
use Carbon\Carbon;
use Exception;

class WebsiteBannerController extends Controller
{
    public function manageWebsiteBanner()
    {
        try {
            // Fetch all data
            $templeId = 'TEMPLE25402';

            $previousDate = Carbon::yesterday()->toDateString(); // e.g., '2025-03-24'

            $nitiMaster = NitiMaster::with(['niti_items'])
                            ->where('status', 'active')
                            ->where('temple_id', $templeId)
                            ->get();

            $banners = TempleBanner::where('temple_id', $templeId)
                            ->where('status', 'active')
                            ->get();

            $nearbyTemples = NearByTemple::where('status', 'active')
                                ->where('temple_id', $templeId)
                                ->get();

            $totalPreviousAmount = HundiCollection::where('temple_id', $templeId)
            ->where('status', 'active')
            ->whereDate('hundi_open_date', $previousDate)
            ->sum('collection_amount');

            // Return JSON response
            return response()->json([
                'status' => true,
                'message' => 'Temple website data fetched successfully.',
                'data' => [
                    'niti_master' => $nitiMaster,
                    'banners' => $banners,
                    'nearby_temples' => $nearbyTemples,
                    'totalPreviousAmount' => $totalPreviousAmount,
                ]
            ], 200);

        } catch (Exception $e) {
            // Handle error
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
