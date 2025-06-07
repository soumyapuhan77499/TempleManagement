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

// 1. Get all NitiManagement records for latest day ordered by start_time (or created_at)
$nitiManagements = NitiManagement::where('day_id', $latestDayId)
    ->with('master')
    ->orderBy('id', 'asc')
    ->get();

// Extract Niti IDs managed so far (for started/paused/completed)
$managedNitiIds = $nitiManagements->pluck('niti_id')->unique()->toArray();

// 2. Get all nitis from master table that are NOT managed yet (upcoming)
$upcomingNitis = NitiMaster::where('niti_privacy', 'public')
    ->whereIn('niti_type', ['daily', 'special'])
    ->whereNotIn('niti_id', $managedNitiIds)
    ->orderBy('niti_order', 'asc')
    ->get()
    ->keyBy('niti_id');

// 3. Get running sub-nitis for active nitis from master
$activeNitiIds = NitiMaster::whereIn('niti_status', ['Started', 'Paused'])->pluck('niti_id');

$runningSubNitis = TempleSubNitiManagement::where(function ($q) {
        $q->where('status', 'Running')->orWhere('status', '!=', 'Deleted');
    })
    ->where('day_id', $latestDayId)
    ->whereIn('niti_id', $activeNitiIds)
    ->get();

// 4. Special nitis grouped by after_special_niti
$allSpecialNitis = NitiMaster::where('niti_type', 'special')
    ->where('niti_privacy', 'public')
    ->where('status', 'active')
    ->get()
    ->groupBy('after_special_niti');

$mergedNitiList = collect();

// 6. Push managed nitis first (ordered by start_time)
foreach ($nitiManagements as $management) {
    $niti = $management->master;
    if (!$niti) continue;

    // running subs for this niti
    $runningSubs = $runningSubNitis->where('niti_id', $niti->niti_id);

    $mergedNitiList->push([
        'niti_id' => $niti->niti_id,
        'niti_name' => $niti->niti_name,
        'english_niti_name' => $niti->english_niti_name,
        'niti_type' => $niti->niti_type,
        'niti_status' => $niti->niti_status,
        'date_time' => $niti->date_time,
        'language' => $niti->language,
        'niti_privacy' => $niti->niti_privacy,
        'niti_about' => $niti->niti_about,
        'niti_sebayat' => $niti->niti_sebayat,
        'description' => $niti->description,
        'english_description' => $niti->english_description,
        'start_time' => $management->start_time,
        'pause_time' => $management->pause_time,
        'resume_time' => $management->resume_time,
        'end_time' => $management->end_time,
        'duration' => $management->duration,
        'management_status' => $management->niti_status,
        'after_special_niti_name' => null,
        'running_sub_niti' => $runningSubs->map(fn($sub) => [
            'sub_niti_id' => $sub->sub_niti_id,
            'sub_niti_name' => $sub->sub_niti_name,
            'start_time' => $sub->start_time,
            'status' => $sub->status,
            'date' => $sub->date,
        ])->values(),
    ]);

    // If daily, append specials after it
    if ($niti->niti_type === 'daily') {
        $specialsAfter = $allSpecialNitis->get($niti->niti_id, collect());

        foreach ($specialsAfter as $specialNiti) {
            $specialMgmt = $nitiManagements->has($specialNiti->niti_id)
                ? $nitiManagements[$specialNiti->niti_id]->sortByDesc('created_at')->first()
                : null;

            $specialRunningSubs = $runningSubNitis->where('niti_id', $specialNiti->niti_id);

            $mergedNitiList->push([
                'niti_id' => $specialNiti->niti_id,
                'niti_name' => $specialNiti->niti_name,
                'english_niti_name' => $specialNiti->english_niti_name,
                'niti_type' => $specialNiti->niti_type,
                'niti_status' => $specialNiti->niti_status,
                'date_time' => $specialNiti->date_time,
                'language' => $specialNiti->language,
                'niti_privacy' => $specialNiti->niti_privacy,
                'niti_about' => $specialNiti->niti_about,
                'niti_sebayat' => $specialNiti->niti_sebayat,
                'description' => $specialNiti->description,
                'english_description' => $specialNiti->english_description,
                'start_time' => $specialMgmt->start_time ?? null,
                'pause_time' => $specialMgmt->pause_time ?? null,
                'resume_time' => $specialMgmt->resume_time ?? null,
                'end_time' => $specialMgmt->end_time ?? null,
                'duration' => $specialMgmt->duration ?? null,
                'management_status' => $specialMgmt->niti_status ?? 'Not Started',
                'after_special_niti_name' => $niti->niti_name,
                'running_sub_niti' => $specialRunningSubs->map(fn($sub) => [
                    'sub_niti_id' => $sub->sub_niti_id,
                    'sub_niti_name' => $sub->sub_niti_name,
                    'start_time' => $sub->start_time,
                    'status' => $sub->status,
                    'date' => $sub->date,
                ])->values(),
            ]);
        }

      
    }
}

// 7. Now add remaining upcoming nitis (those not managed yet)
foreach ($upcomingNitis as $niti) {
    $runningSubs = $runningSubNitis->where('niti_id', $niti->niti_id);

    $mergedNitiList->push([
        'niti_id' => $niti->niti_id,
        'niti_name' => $niti->niti_name,
        'english_niti_name' => $niti->english_niti_name,
        'niti_type' => $niti->niti_type,
        'niti_status' => $niti->niti_status,
        'date_time' => $niti->date_time,
        'language' => $niti->language,
        'niti_privacy' => $niti->niti_privacy,
        'niti_about' => $niti->niti_about,
        'niti_sebayat' => $niti->niti_sebayat,
        'description' => $niti->description,
        'english_description' => $niti->english_description,
        'start_time' => null,
        'pause_time' => null,
        'resume_time' => null,
        'end_time' => null,
        'duration' => null,
        'management_status' => 'Not Started',
        'after_special_niti_name' => null,
        'running_sub_niti' => $runningSubs->map(fn($sub) => [
            'sub_niti_id' => $sub->sub_niti_id,
            'sub_niti_name' => $sub->sub_niti_name,
            'start_time' => $sub->start_time,
            'status' => $sub->status,
            'date' => $sub->date,
        ])->values(),
    ]);
}

// 8. Add remaining others at the end (if any leftover)
foreach ($otherNitiManagements as $nitiMgmt) {
    $niti = $nitiMgmt->master;
    if (!$niti) continue;

    $runningSubs = $runningSubNitis->where('niti_id', $niti->niti_id);

    $mergedNitiList->push([
        'niti_id' => $niti->niti_id,
        'niti_name' => $niti->niti_name,
        'english_niti_name' => $niti->english_niti_name,
        'niti_type' => $niti->niti_type,
        'niti_status' => $niti->niti_status,
        'date_time' => $niti->date_time,
        'language' => $niti->language,
        'niti_privacy' => $niti->niti_privacy,
        'niti_about' => $niti->niti_about,
        'niti_sebayat' => $niti->niti_sebayat,
        'description' => $niti->description,
        'english_description' => $niti->english_description,
        'start_time' => $nitiMgmt->start_time,
        'pause_time' => $nitiMgmt->pause_time,
        'resume_time' => $nitiMgmt->resume_time,
        'end_time' => $nitiMgmt->end_time,
        'duration' => $nitiMgmt->duration,
        'management_status' => $nitiMgmt->niti_status,
        'after_special_niti_name' => null,
        'running_sub_niti' => $runningSubs->map(fn($sub) => [
            'sub_niti_id' => $sub->sub_niti_id,
            'sub_niti_name' => $sub->sub_niti_name,
            'start_time' => $sub->start_time,
            'status' => $sub->status,
            'date' => $sub->date,
        ])->values(),
    ]);
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
                    'niti_master' => $mergedNitiList,
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
