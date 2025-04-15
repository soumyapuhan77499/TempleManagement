<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NitiMaster;
use App\Models\NitiManagement;
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

            $previousDate = Carbon::yesterday()->toDateString(); 

            $today = Carbon::now('Asia/Kolkata')->toDateString();

            // Step 1: Get today's started Nitis in actual order
            $startedToday = NitiManagement::whereDate('date', $today)
                ->whereNotNull('start_time')
                ->orderBy('start_time', 'asc')
                ->get();
            
            // Step 2: Fetch related master data and build response
            $orderedNitis = $startedToday->map(function ($management) use ($today) {
                $niti = NitiMaster::where('niti_id', $management->niti_id)->first();
            
                return [
                    'niti_id'       => $niti->niti_id,
                    'niti_name'     => $niti->niti_name,
                    'niti_type'     => $niti->niti_type,
                    'niti_status'   => $niti->niti_status,
                    'date_time'     => $niti->date_time,
                    'language'      => $niti->language,
                    'niti_privacy'  => $niti->niti_privacy,
                    'niti_about'    => $niti->niti_about,
                    'niti_sebayat'  => $niti->niti_sebayat,
                    'description'   => $niti->description,
            
                    // Management info
                    'start_time'    => $management->start_time,
                    'pause_time'    => $management->pause_time,
                    'resume_time'   => $management->resume_time,
                    'end_time'      => $management->end_time,
                    'duration'      => $management->duration,
                    'management_status' => $management->niti_status,
                ];
            });
            
            // Step 3: Optionally fetch remaining daily Nitis not yet started today
            $startedNitiIds = $startedToday->pluck('niti_id')->toArray();
            
            $remainingNitis = NitiMaster::whereNotIn('niti_id', $startedNitiIds)
                ->where(function ($query) {
                    $query->where('niti_type', 'daily')
                          ->where('status', 'active')
                          ->where('niti_privacy', 'public');
                })
                ->orderBy('date_time', 'asc')
                ->get()
                ->map(function ($niti) {
                    return [
                        'niti_id'       => $niti->niti_id,
                        'niti_name'     => $niti->niti_name,
                        'niti_type'     => $niti->niti_type,
                        'niti_status'   => $niti->niti_status,
                        'date_time'     => $niti->date_time,
                        'language'      => $niti->language,
                        'niti_privacy'  => $niti->niti_privacy,
                        'niti_about'    => $niti->niti_about,
                        'niti_sebayat'  => $niti->niti_sebayat,
                        'description'   => $niti->description,
            
                        'start_time'    => null,
                        'pause_time'    => null,
                        'resume_time'   => null,
                        'end_time'      => null,
                        'duration'      => null,
                        'management_status' => null,
                    ];
                });
            
            // Step 4: Merge — running Nitis first (by actual start), then unstarted daily
            $result = $orderedNitis->merge($remainingNitis)->values();
            
            $banners = TempleBanner::where('temple_id', $templeId)
            ->where('status', 'active')
            ->get(['banner_image', 'banner_type']);

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
                    'niti_master' => $result,
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
