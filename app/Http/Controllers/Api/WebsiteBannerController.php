<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RathaYatraNiti;
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
    //  public function manageWebsiteBanner()
    // {
    //     try {
    //     $templeId = 'TEMPLE25402';

    //     $latestDayId = NitiMaster::where('status', 'active')->latest('id')->value('day_id');

    //     if (!$latestDayId) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'No active Niti found to determine day_id.'
    //         ], 404);
    //     }

    //     $nitiManagements = NitiManagement::where('day_id', $latestDayId)
    //     ->with('master')
    //     ->where('niti_status', '!=', 'NotStarted')
    //     ->orderByRaw("CASE WHEN niti_status = 'Started' THEN id ELSE NULL END ASC")
    //     ->orderByRaw('date asc, end_time asc')
    //     ->get();

    //     // Extract Niti IDs managed so far (for started/paused/completed)
    //     $managedNitiIds = $nitiManagements->pluck('niti_id')->unique()->toArray();

    //     // 2. Get all nitis from master table that are NOT managed yet (upcoming)
    //     $upcomingNitis = NitiMaster::where('niti_privacy', 'public')
    //         ->whereIn('niti_type', ['daily', 'special'])
    //         ->where('niti_status', '!=', 'NotStarted')
    //         ->whereNotIn('niti_id', $managedNitiIds)
    //         ->orderBy('niti_order', 'asc')
    //         ->get()
    //         ->keyBy('niti_id');

    //     // 3. Get running sub-nitis for active nitis from master
    //     $activeNitiIds = NitiMaster::whereIn('niti_status', ['Started', 'Paused'])->pluck('niti_id');

    //     $runningSubNitis = TempleSubNitiManagement::where(function ($q) {
    //             $q->where('status', 'Running')->orWhere('status', '!=', 'Deleted');
    //         })
    //         ->where('day_id', $latestDayId)
    //         ->whereIn('niti_id', $activeNitiIds)
    //         ->get();

    //     // 4. Special nitis grouped by after_special_niti
    //     $allSpecialNitis = NitiMaster::where('niti_type', 'special')
    //         ->where('niti_privacy', 'public')
    //         ->where('niti_status', '!=', 'NotStarted')
    //         ->where('status', 'active')
    //         ->get()
    //         ->groupBy('after_special_niti');

    //     $mergedNitiList = collect();

    //     // Track inserted "other" niti ids to avoid duplicates
    //     $insertedOtherNitiIds = [];

    //     foreach ($nitiManagements as $management) {
    //         $niti = $management->master;
    //         if (!$niti) continue;

    //         // running subs for this niti
    //         $runningSubs = $runningSubNitis->where('niti_id', $niti->niti_id);

    //         $mergedNitiList->push([
    //             'niti_id' => $niti->niti_id,
    //             'niti_name' => $niti->niti_name,
    //             'english_niti_name' => $niti->english_niti_name,
    //             'niti_type' => $niti->niti_type,
    //             'niti_status' => $niti->niti_status,
    //             'date_time' => $niti->date_time,
    //             'language' => $niti->language,
    //             'niti_privacy' => $niti->niti_privacy,
    //             'niti_about' => $niti->niti_about,
    //             'niti_sebayat' => $niti->niti_sebayat,
    //             'description' => $niti->description,
    //             'english_description' => $niti->english_description,
    //             'start_time' => $management->start_time,
    //             'pause_time' => $management->pause_time,
    //             'resume_time' => $management->resume_time,
    //             'end_time' => $management->end_time,
    //             'duration' => $management->duration,
    //             'management_status' => $management->niti_status,
    //             'after_special_niti_name' => null,
    //             'running_sub_niti' => $runningSubs->map(fn($sub) => [
    //                 'sub_niti_id' => $sub->sub_niti_id,
    //                 'sub_niti_name' => $sub->sub_niti_name,
    //                 'start_time' => $sub->start_time,
    //                 'status' => $sub->status,
    //                 'date' => $sub->date,
    //             ])->values(),
    //         ]);

    //         // If daily, append specials after it
    //         if ($niti->niti_type === 'daily') {
    //             $specialsAfter = $allSpecialNitis->get($niti->niti_id, collect());

    //             foreach ($specialsAfter as $specialNiti) {
    //                 $specialMgmt = $nitiManagements->has($specialNiti->niti_id)
    //                     ? $nitiManagements[$specialNiti->niti_id]->sortByDesc('created_at')->first()
    //                     : null;

    //                 $specialRunningSubs = $runningSubNitis->where('niti_id', $specialNiti->niti_id);

    //                 $mergedNitiList->push([
    //                     'niti_id' => $specialNiti->niti_id,
    //                     'niti_name' => $specialNiti->niti_name,
    //                     'english_niti_name' => $specialNiti->english_niti_name,
    //                     'niti_type' => $specialNiti->niti_type,
    //                     'niti_status' => $specialNiti->niti_status,
    //                     'date_time' => $specialNiti->date_time,
    //                     'language' => $specialNiti->language,
    //                     'niti_privacy' => $specialNiti->niti_privacy,
    //                     'niti_about' => $specialNiti->niti_about,
    //                     'niti_sebayat' => $specialNiti->niti_sebayat,
    //                     'description' => $specialNiti->description,
    //                     'english_description' => $specialNiti->english_description,
    //                     'start_time' => $specialMgmt->start_time ?? null,
    //                     'pause_time' => $specialMgmt->pause_time ?? null,
    //                     'resume_time' => $specialMgmt->resume_time ?? null,
    //                     'end_time' => $specialMgmt->end_time ?? null,
    //                     'duration' => $specialMgmt->duration ?? null,
    //                     'management_status' => $specialMgmt->niti_status ?? 'Not Started',
    //                     'after_special_niti_name' => $niti->niti_name,
    //                     'running_sub_niti' => $specialRunningSubs->map(fn($sub) => [
    //                         'sub_niti_id' => $sub->sub_niti_id,
    //                         'sub_niti_name' => $sub->sub_niti_name,
    //                         'start_time' => $sub->start_time,
    //                         'status' => $sub->status,
    //                         'date' => $sub->date,
    //                     ])->values(),
    //                 ]);
    //             }
    //         }
    //     }

    //     // 7. Now add remaining upcoming nitis (those not managed yet)
    //     foreach ($upcomingNitis as $niti) {
    //         $runningSubs = $runningSubNitis->where('niti_id', $niti->niti_id);

    //         $mergedNitiList->push([
    //             'niti_id' => $niti->niti_id,
    //             'niti_name' => $niti->niti_name,
    //             'english_niti_name' => $niti->english_niti_name,
    //             'niti_type' => $niti->niti_type,
    //             'niti_status' => $niti->niti_status,
    //             'date_time' => $niti->date_time,
    //             'language' => $niti->language,
    //             'niti_privacy' => $niti->niti_privacy,
    //             'niti_about' => $niti->niti_about,
    //             'niti_sebayat' => $niti->niti_sebayat,
    //             'description' => $niti->description,
    //             'english_description' => $niti->english_description,
    //             'start_time' => null,
    //             'pause_time' => null,
    //             'resume_time' => null,
    //             'end_time' => null,
    //             'duration' => null,
    //             'management_status' => 'Not Started',
    //             'after_special_niti_name' => null,
    //             'running_sub_niti' => $runningSubs->map(fn($sub) => [
    //                 'sub_niti_id' => $sub->sub_niti_id,
    //                 'sub_niti_name' => $sub->sub_niti_name,
    //                 'start_time' => $sub->start_time,
    //                 'status' => $sub->status,
    //                 'date' => $sub->date,
    //             ])->values(),
    //         ]);
    //     }

    //         $nitiInfo = TempleNews::where('type', 'information')
    //         ->where('niti_notice_status','Started')
    //         ->where('status','active')
    //         ->orderBy('created_at', 'desc')
    //         ->get(['id', 'niti_notice','niti_notice_english','created_at'])
    //         ->first();

    //         $banners = TempleBanner::where('temple_id', $templeId)
    //             ->where('status', 'active')
    //             ->get(['banner_image', 'banner_type']);
    
    //         $nearbyTemples = NearByTemple::where('status', 'active')
    //             ->where('temple_id', $templeId)
    //             ->get();
    
    //         $totalPreviousAmount = HundiCollection::where('temple_id', $templeId)
    //             ->where('status', 'active')
    //             ->whereDate('hundi_open_date', Carbon::yesterday()->toDateString())
    //             ->sum('collection_amount');
    
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Temple website data fetched successfully.',
    //             'data' => [
    //                 'niti_master' => $mergedNitiList,
    //                 'banners'             => $banners,
    //                 'nearby_temples'      => $nearbyTemples,
    //                 'totalPreviousAmount' => $totalPreviousAmount,
    //                 'information'           => $nitiInfo,
    //             ]
    //         ], 200);
    
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Something went wrong.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    public function manageWebsiteBanner()
{
    try {
       $mergedNitiList = collect(); // Default empty
        $runningDayId = null;

        // ✅ Get all unique day_ids in correct order
        $dayIds = RathaYatraNiti::select('day_id')
            ->distinct()
            ->orderByRaw("CAST(SUBSTRING(day_id, 5) AS UNSIGNED)")
            ->pluck('day_id');

        foreach ($dayIds as $dayId) {
            // ✅ Check if there's at least one Niti with today's date and required statuses
            $hasNiti = RathaYatraNiti::where('day_id', $dayId)
                ->whereDate('date', Carbon::today('Asia/Kolkata'))
                ->whereIn('niti_status', ['Started', 'Completed', 'NotStarted','Upcoming'])
                ->exists();

            if ($hasNiti) {
                $runningDayId = $dayId;

                // ✅ Fetch only those Nitis for this running day, skip NotStarted ones
         $nitis = RathaYatraNiti::where('day_id', $runningDayId)
    ->whereIn('niti_status', ['Started', 'Completed', 'Upcoming']) // Exclude NotStarted
    ->where(function ($query) {
        $query->where('niti_status', '!=', 'Upcoming')
            ->orWhere(function ($q) {
                $q->where('niti_status', 'Upcoming')
                    ->whereNull('end_time'); // Only allow Upcoming if end_time is null
            });
    })
    ->orderByRaw("
        CASE 
            WHEN niti_status = 'Started' THEN 1
            WHEN niti_status = 'Completed' THEN 2
            WHEN niti_status = 'Upcoming' THEN 3
            ELSE 4
        END
    ")
    ->orderByRaw("
        CASE 
            WHEN niti_status = 'Started'  THEN order_id
            WHEN niti_status = 'Completed' THEN TIME_TO_SEC(end_time)
            WHEN niti_status = 'Upcoming' THEN order_id
            ELSE NULL
        END ASC
    ")
    ->get();




                    $mergedNitiList = $nitis->map(function ($niti) {
                        return [
                            'niti_id'           => $niti->niti_id,
                            'niti_name'         => $niti->niti_name ?? null,
                            'english_niti_name' => $niti->english_niti_name ?? null,
                            'niti_type'         => $niti->niti_type,
                            'niti_status'       => $niti->niti_status,
                            'start_time'        => $niti->start_time,
                            'end_time'          => $niti->end_time,
                            'date'              => $niti->date,
                            'order_id'          => $niti->order_id,
                        ];
                    });
                

                break; // ✅ Process only the first valid day_id
            }
        }

        $nitiInfo = TempleNews::where('type', 'information')
            ->where('niti_notice_status', 'Started')
            ->where('status', 'active')
            ->latest('created_at')
            ->first(['id', 'niti_notice', 'niti_notice_english', 'created_at']);

        $banners = TempleBanner::where('status', 'active')
            ->get(['banner_image', 'banner_type']);

        $nearbyTemples = NearByTemple::where('status', 'active')
            ->get();

        $totalPreviousAmount = HundiCollection::where('status', 'active')
            ->whereDate('hundi_open_date', Carbon::yesterday()->toDateString())
            ->sum('collection_amount');

        return response()->json([
            'status' => true,
            'message' => 'Temple website data fetched successfully.',
            'data' => [
                'niti_master'         => $mergedNitiList,
                'banners'             => $banners,
                'nearby_temples'      => $nearbyTemples,
                'totalPreviousAmount' => $totalPreviousAmount,
                'information'         => $nitiInfo,
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
