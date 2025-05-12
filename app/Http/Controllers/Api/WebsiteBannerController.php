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
use App\Models\TempleNews;

use Carbon\Carbon;
use Exception;

class WebsiteBannerController extends Controller
{
    public function manageWebsiteBanner()
    {
        try {
            $templeId = 'TEMPLE25402';

            $latestDayId = NitiMaster::where('status', 'active')->latest('id')->value('day_id');
    
            if (!$latestDayId) {
                return response()->json([
                    'status' => false,
                    'message' => 'No active Niti found to determine day_id.'
                ], 404);
            }
    
            $activeNitiIds = NitiMaster::whereIn('niti_status', ['Started', 'Paused'])->pluck('niti_id');
    
            $runningSubNitis = TempleSubNitiManagement::where(function ($query) {
            $query->where('status', 'Running')
            ->orWhere('status', '!=', 'Deleted');
            })
            ->where('day_id', $latestDayId)
            ->whereIn('niti_id', $activeNitiIds)
            ->get();

            $dailyNitis = NitiMaster::where('status', 'active')
                ->where('niti_type', 'daily')
                ->where('language', 'Odia')
                ->where('niti_privacy', 'public')
                ->orderBy('niti_order', 'asc')
                ->get();

            $specialNitisGrouped = NitiMaster::where('status', 'active')
                ->where('niti_type', 'special')
                ->where('language', 'Odia')
                ->where('niti_privacy', 'public')
                ->get()
                ->groupBy('after_special_niti');
    
           $otherNitiManagements = NitiManagement::whereIn('niti_status', ['Started', 'Completed'])
                ->whereHas('master', function ($query) {
                    $query->where('niti_type', 'other')
                        ->where('status', '!=', 'deleted');
                })
                ->with('master')
                ->orderBy('created_at', 'desc') // or 'start_time' if you prefer
                ->get();


            foreach ($otherNitiManagements as $nitiMgmt) {
                $nitiMaster = $nitiMgmt->master;

                $mergedNitiList[] = [
                    'niti_id'           => $nitiMaster->niti_id,
                    'niti_name'         => $nitiMaster->niti_name,
                    'english_niti_name' => $nitiMaster->english_niti_name,
                    'niti_type'         => $nitiMaster->niti_type,
                    'niti_status'       => $nitiMgmt->niti_status,
                    'start_time'        => $nitiMgmt->start_time,
                    'end_time'          => $nitiMgmt->end_time,
                    'duration'          => $nitiMgmt->duration,
                    'management_status' => $nitiMgmt->niti_status,
                ];
            }
            
            foreach ($dailyNitis as $dailyNiti) {
                $matchingRunningSubNitis = $runningSubNitis->where('niti_id', $dailyNiti->niti_id);
    
                $dailyManagement = NitiManagement::where('niti_id', $dailyNiti->niti_id)
                    ->where('day_id', $latestDayId)
                    ->latest('created_at')
                    ->first();
    
                $mergedNitiList[] = [
                    'niti_id'       => $dailyNiti->niti_id,
                    'niti_name'     => $dailyNiti->niti_name,
                    'english_niti_name'     => $dailyNiti->english_niti_name,
                    'niti_type'     => $dailyNiti->niti_type,
                    'niti_status'   => $dailyNiti->niti_status,
                    'date_time'     => $dailyNiti->date_time,
                    'language'      => $dailyNiti->language,
                    'niti_privacy'  => $dailyNiti->niti_privacy,
                    'niti_about'    => $dailyNiti->niti_about,
                    'niti_sebayat'  => $dailyNiti->niti_sebayat,
                    'description'   => $dailyNiti->description,
                    'start_time'    => $dailyManagement->start_time ?? null,
                    'pause_time'    => $dailyManagement->pause_time ?? null,
                    'resume_time'   => $dailyManagement->resume_time ?? null,
                    'end_time'      => $dailyManagement->end_time ?? null,
                    'duration'      => $dailyManagement->duration ?? null,
                    'management_status' => $dailyManagement->niti_status ?? null,
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
    
                $specialsAfter = $specialNitisGrouped->get($dailyNiti->niti_id, collect());
    
                foreach ($specialsAfter as $specialNiti) {
                    $specialManagement = NitiManagement::where('niti_id', $specialNiti->niti_id)
                        ->where('day_id', $latestDayId)
                        ->latest('created_at')
                        ->first();
    
                    $specialRunningSubNitis = $runningSubNitis->where('niti_id', $specialNiti->niti_id);
    
                    $mergedNitiList[] = [
                        'niti_id'       => $specialNiti->niti_id,
                        'niti_name'     => $specialNiti->niti_name,
                        'english_niti_name'     => $specialNiti->english_niti_name,
                        'niti_type'     => $specialNiti->niti_type,
                        'niti_status'   => $specialNiti->niti_status,
                        'date_time'     => $specialNiti->date_time,
                        'language'      => $specialNiti->language,
                        'niti_privacy'  => $specialNiti->niti_privacy,
                        'niti_about'    => $specialNiti->niti_about,
                        'niti_sebayat'  => $specialNiti->niti_sebayat,
                        'description'   => $specialNiti->description,
                        'start_time'    => $specialManagement->start_time ?? null,
                        'pause_time'    => $specialManagement->pause_time ?? null,
                        'resume_time'   => $specialManagement->resume_time ?? null,
                        'end_time'      => $specialManagement->end_time ?? null,
                        'duration'      => $specialManagement->duration ?? null,
                        'management_status' => $specialManagement->niti_status ?? null,
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

            $nitiInfo = TempleNews::where('type', 'information')
            ->where('niti_notice_status','Started')
            ->where('status','active')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'niti_notice','created_at'])
            ->first();

            $banners = TempleBanner::where('temple_id', $templeId)
                ->where('status', 'active')
                ->get(['banner_image', 'banner_type']);
    
            $nearbyTemples = NearByTemple::where('status', 'active')
                ->where('temple_id', $templeId)
                ->get();
    
            $totalPreviousAmount = HundiCollection::where('temple_id', $templeId)
                ->where('status', 'active')
                ->whereDate('hundi_open_date', Carbon::yesterday()->toDateString())
                ->sum('collection_amount');
    
            return response()->json([
                'status' => true,
                'message' => 'Temple website data fetched successfully.',
                'data' => [
                    'niti_master'         => collect($mergedNitiList)->values(),
                    'banners'             => $banners,
                    'nearby_temples'      => $nearbyTemples,
                    'totalPreviousAmount' => $totalPreviousAmount,
                    'information'           => $nitiInfo,
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
