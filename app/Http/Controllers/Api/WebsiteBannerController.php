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
    
            // Fetch all running sub-nitis today (for all niti)
            $subNitis = TempleSubNitiManagement::whereIn('status', ['Running', 'Completed'])
                ->whereDate('date', $today)
                ->whereIn('niti_id', function ($query) {
                    $query->select('niti_id')
                          ->from('temple__niti_details')
                          ->whereIn('niti_status', ['Started', 'Paused']);
                })
                ->get([
                    'sub_niti_id',
                    'sub_niti_name',
                    'niti_id',
                    'start_time',
                    'date',
                    'status'
                ]);
    
            // Get all relevant nitis
            $nitis = NitiMaster::where(function ($query) {
                    $query->where('niti_type', 'daily')
                          ->where('status', 'active')
                          ->where('niti_privacy', 'public');
                })
                ->orWhere(function ($query) {
                    $query->where('niti_type', 'special')
                          ->whereIn('niti_status', ['Started', 'Completed']);
                })
                ->get();
    
            // Map result
            $result = $nitis->map(function ($niti) use ($today, $subNitis) {
                $management = NitiManagement::where('niti_id', $niti->niti_id)
                    ->whereDate('date', $today)
                    ->orderBy('start_time', 'desc')
                    ->first();
    
                // Find matching sub-niti from pre-fetched list
                $matchingSubNitis = $subNitis->where('niti_id', $niti->niti_id);
    
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
                    'start_time'    => $management->start_time ?? null,
                    'pause_time'    => $management->pause_time ?? null,
                    'resume_time'   => $management->resume_time ?? null,
                    'end_time'      => $management->end_time ?? null,
                    'duration'      => $management->duration ?? null,
                    'management_status' => $management->niti_status ?? null,
                    'running_sub_niti' => $matchingSubNitis->map(function ($sub) {
                        return [
                            'sub_niti_id'   => $sub->sub_niti_id,
                            'sub_niti_name' => $sub->sub_niti_name,
                            'start_time'    => $sub->start_time,
                            'status'        => $sub->status,
                            'date'          => $sub->date,
                        ];
                    })->values(),


                ];
            });
    
            // Sort by start_time (nulls go last)
            $sortedResult = $result->sortBy(function ($item) {
                return $item['start_time'] ?? '99:99:99';
            })->values();
    
            // Fetch other sections
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
    
            // Final response
            return response()->json([
                'status' => true,
                'message' => 'Temple website data fetched successfully.',
                'data' => [
                    'niti_master'         => $sortedResult,
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
