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

// Fetch all nitis of daily/special/other type
$allNitis = NitiMaster::whereIn('niti_type', ['daily', 'special', 'other'])
    ->where('niti_privacy', 'public')
    ->orderBy('niti_order', 'asc')
    ->get()
    ->keyBy('niti_id');

// Management entries (all types)
$nitiManagements = NitiManagement::where('day_id', $latestDayId)
    ->with('master')
    ->get()
    ->groupBy('niti_id');

// Running sub-nitis
$activeNitiIds = NitiMaster::whereIn('niti_status', ['Started', 'Paused'])->pluck('niti_id');
$runningSubNitis = TempleSubNitiManagement::where(function ($query) {
        $query->where('status', 'Running')->orWhere('status', '!=', 'Deleted');
    })
    ->where('day_id', $latestDayId)
    ->whereIn('niti_id', $activeNitiIds)
    ->get();

// Group special nitis by trigger ID
$specialNitisGrouped = $allNitis->filter(fn($niti) => $niti->niti_type === 'special')
    ->groupBy('after_special_niti');

$mergedNitiList = [];

// ✅ Loop for daily & special nitis (skip "other")
foreach ($allNitis as $niti_id => $niti) {
    if ($niti->niti_type === 'other') {
        continue;
    }

    $management = $nitiManagements->has($niti_id)
        ? $nitiManagements[$niti_id]->sortByDesc('created_at')->first()
        : null;

    $runningSubs = $runningSubNitis->where('niti_id', $niti_id);

    $mergedNitiList[] = [
        'niti_id'       => $niti->niti_id,
        'niti_name'     => $niti->niti_name,
        'english_niti_name' => $niti->english_niti_name,
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
        'management_status' => $management->niti_status ?? 'Not Started',
        'after_special_niti_name' => null,
        'running_sub_niti' => $runningSubs->map(function ($sub) {
            return [
                'sub_niti_id'   => $sub->sub_niti_id,
                'sub_niti_name' => $sub->sub_niti_name,
                'start_time'    => $sub->start_time,
                'status'        => $sub->status,
                'date'          => $sub->date,
            ];
        })->values(),
    ];

    // Handle special nitis linked after this daily niti
    if ($niti->niti_type === 'daily') {
        $specialsAfter = $specialNitisGrouped->get($niti->niti_id, collect());

        foreach ($specialsAfter as $specialNiti) {
            $specialMgmt = $nitiManagements->has($specialNiti->niti_id)
                ? $nitiManagements[$specialNiti->niti_id]->sortByDesc('created_at')->first()
                : null;

            $specialRunningSubs = $runningSubNitis->where('niti_id', $specialNiti->niti_id);

            $mergedNitiList[] = [
                'niti_id'       => $specialNiti->niti_id,
                'niti_name'     => $specialNiti->niti_name,
                'english_niti_name' => $specialNiti->english_niti_name,
                'niti_type'     => $specialNiti->niti_type,
                'niti_status'   => $specialNiti->niti_status,
                'date_time'     => $specialNiti->date_time,
                'language'      => $specialNiti->language,
                'niti_privacy'  => $specialNiti->niti_privacy,
                'niti_about'    => $specialNiti->niti_about,
                'niti_sebayat'  => $specialNiti->niti_sebayat,
                'description'   => $specialNiti->description,
                'start_time'    => $specialMgmt->start_time ?? null,
                'pause_time'    => $specialMgmt->pause_time ?? null,
                'resume_time'   => $specialMgmt->resume_time ?? null,
                'end_time'      => $specialMgmt->end_time ?? null,
                'duration'      => $specialMgmt->duration ?? null,
                'management_status' => $specialMgmt->niti_status ?? 'Not Started',
                'after_special_niti_name' => $niti->niti_name,
                'running_sub_niti' => $specialRunningSubs->map(function ($sub) {
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
}

// ✅ Now add all "other" type management entries (multiple per day)
$otherNitiManagements = NitiManagement::where('day_id', $latestDayId)
    ->whereIn('niti_status', ['Started', 'Completed'])
    ->with('master')
    ->whereHas('master', function ($query) {
        $query->where('niti_type', 'other');
    })
    ->orderBy('start_time')
    ->get();

foreach ($otherNitiManagements as $nitiMgmt) {
    $niti = $nitiMgmt->master;
    if (!$niti) continue;

    $runningSubs = $runningSubNitis->where('niti_id', $niti->niti_id);

    $mergedNitiList[] = [
        'niti_id'       => $niti->niti_id,
        'niti_name'     => $niti->niti_name,
        'english_niti_name' => $niti->english_niti_name,
        'niti_type'     => $niti->niti_type,
        'niti_status'   => $niti->niti_status,
        'date_time'     => $niti->date_time,
        'language'      => $niti->language,
        'niti_privacy'  => $niti->niti_privacy,
        'niti_about'    => $niti->niti_about,
        'niti_sebayat'  => $niti->niti_sebayat,
        'description'   => $niti->description,
        'start_time'    => $nitiMgmt->start_time,
        'pause_time'    => $nitiMgmt->pause_time,
        'resume_time'   => $nitiMgmt->resume_time,
        'end_time'      => $nitiMgmt->end_time,
        'duration'      => $nitiMgmt->duration,
        'management_status' => $nitiMgmt->niti_status,
        'after_special_niti_name' => null,
        'running_sub_niti' => $runningSubs->map(function ($sub) {
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

// ✅ Sort by execution order
$mergedNitiList = collect($mergedNitiList)->sortBy(function ($item) {
    return $item['start_time'] ?? '9999:99:99';
})->values();


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
