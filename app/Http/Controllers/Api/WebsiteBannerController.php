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
use App\Models\TempleSubNitiManagement;
use App\Models\TempleSubNiti;
use Carbon\Carbon;
use Exception;

class WebsiteBannerController extends Controller
{

    public function manageWebsiteBanner()
    {
        try {
            $templeId = 'TEMPLE25402';
            $today = Carbon::now('Asia/Kolkata')->toDateString();
            $previousDate = Carbon::yesterday()->toDateString();
    
            // ✅ Fetch Running Sub Nitis for Today
            $runningSubNitis = TempleSubNitiManagement::whereIn('status', ['Running', 'Completed'])
                ->whereDate('date', $today)
                ->whereIn('niti_id', function ($query) {
                    $query->select('niti_id')
                        ->from('temple__niti_details')
                        ->whereIn('niti_status', ['Started', 'Paused']);
                })
                ->get();
    
            // ✅ Get Daily Nitis (no date check)
            $dailyNitis = NitiMaster::where('status', 'active')
                ->where('niti_type', 'daily')
                ->where('niti_privacy', 'public')
                ->orderBy('date_time', 'asc')
                ->get();
    
            // ✅ Get Today's Special Nitis grouped by after_special_niti
            $specialNitisGrouped = NitiMaster::where('status', 'active')
                ->where('niti_type', 'special')
                ->whereDate('date_time', $today)
                ->where('niti_privacy', 'public')
                ->get()
                ->groupBy('after_special_niti');
    
            $mergedNitiList = [];
    
            foreach ($dailyNitis as $dailyNiti) {
                // Fetch running sub-nitis for daily
                $matchingRunningSubNitis = $runningSubNitis->where('niti_id', $dailyNiti->niti_id);
    
                $mergedNitiList[] = [
                    'niti_id'       => $dailyNiti->niti_id,
                    'niti_name'     => $dailyNiti->niti_name,
                    'niti_type'     => $dailyNiti->niti_type,
                    'niti_status'   => $dailyNiti->niti_status,
                    'date_time'     => $dailyNiti->date_time,
                    'language'      => $dailyNiti->language,
                    'niti_privacy'  => $dailyNiti->niti_privacy,
                    'niti_about'    => $dailyNiti->niti_about,
                    'niti_sebayat'  => $dailyNiti->niti_sebayat,
                    'description'   => $dailyNiti->description,
                    'start_time'    => null,
                    'pause_time'    => null,
                    'resume_time'   => null,
                    'end_time'      => null,
                    'duration'      => null,
                    'management_status' => null,
                    'after_special_niti_name' => null,
                    'running_sub_niti' => $matchingRunningSubNitis->map(function ($sub) {
                        return [
                            'sub_niti_id'   => $sub->sub_niti_id,
                            'sub_niti_name' => $sub->sub_niti_name,
                            'start_time'    => $sub->start_time,
                            'status'        => $sub->status,
                            'date'          => $sub->date,
                        ];
                    })->values(),
                ];
    
                // Append special Nitis after this daily
                $specialsAfter = $specialNitisGrouped->get($dailyNiti->niti_id, collect());
                foreach ($specialsAfter as $specialNiti) {
                    $management = NitiManagement::where('niti_id', $specialNiti->niti_id)
                        ->whereDate('date', $today)
                        ->orderBy('start_time', 'desc')
                        ->first();
    
                    $specialRunningSubNitis = $runningSubNitis->where('niti_id', $specialNiti->niti_id);
    
                    $mergedNitiList[] = [
                        'niti_id'       => $specialNiti->niti_id,
                        'niti_name'     => $specialNiti->niti_name,
                        'niti_type'     => $specialNiti->niti_type,
                        'niti_status'   => $specialNiti->niti_status,
                        'date_time'     => $specialNiti->date_time,
                        'language'      => $specialNiti->language,
                        'niti_privacy'  => $specialNiti->niti_privacy,
                        'niti_about'    => $specialNiti->niti_about,
                        'niti_sebayat'  => $specialNiti->niti_sebayat,
                        'description'   => $specialNiti->description,
                        'start_time'    => $management->start_time ?? null,
                        'pause_time'    => $management->pause_time ?? null,
                        'resume_time'   => $management->resume_time ?? null,
                        'end_time'      => $management->end_time ?? null,
                        'duration'      => $management->duration ?? null,
                        'management_status' => $management->niti_status ?? null,
                        'after_special_niti_name' => $dailyNiti->niti_name,
                        'running_sub_niti' => $specialRunningSubNitis->map(function ($sub) {
                            return [
                                'sub_niti_id'   => $sub->sub_niti_id,
                                'sub_niti_name' => $sub->sub_niti_name,
                                'start_time'    => $sub->start_time,
                                'status'        => $sub->status,
                                'date'          => $sub->date,
                            ];
                        })->values(),
                    ];
                }
            }
    
            // Sort merged Nitis by their position (already ordered via loop)
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
    
            return response()->json([
                'status' => true,
                'message' => 'Temple website data fetched successfully.',
                'data' => [
                    'niti_master'         => collect($mergedNitiList)->values(),
                    'banners'             => $banners,
                    'nearby_temples'      => $nearbyTemples,
                    'totalPreviousAmount' => $totalPreviousAmount,
                ]
            ], 200);
    
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

}
