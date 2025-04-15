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

            $nitis = NitiMaster::where(function ($query) {
                    $query->where('niti_type', 'daily')
                          ->where('status', 'active')
                          ->where('niti_privacy', 'public')
                          ->orderBy('date_time', 'asc');
                })
                ->orWhere(function ($query) {
                    $query->where('niti_type', 'special')
                          ->whereIn('niti_status', ['Started', 'Completed']);
                })
                ->get();
            
            $result = $nitis->map(function ($niti) use ($today) {
                // Try to get today's management record, else null
                $management = NitiManagement::where('niti_id', $niti->niti_id)
                    ->whereDate('date', $today)
                    ->latest()
                    ->first();
            
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
            
                    // Management info (optional)
                    'start_time'    => $management->start_time ?? null,
                    'pause_time'    => $management->pause_time ?? null,
                    'resume_time'   => $management->resume_time ?? null,
                    'end_time'      => $management->end_time ?? null,
                    'duration'      => $management->duration ?? null,
                    'management_status' => $management->niti_status ?? null,
                ];
            });
            
          
        
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
