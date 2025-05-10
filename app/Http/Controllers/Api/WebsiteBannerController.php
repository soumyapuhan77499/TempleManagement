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

          try {
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

        $specialNitisGrouped = NitiMaster::where('status', 'active')
            ->where('niti_type', 'special')
            ->where('language', 'Odia')
            ->where('niti_privacy', 'public')
            ->get()
            ->groupBy('after_special_niti');

        // 1. Fetch all management entries of the day
        $managementEntries = NitiManagement::where('day_id', $latestDayId)
            ->orderBy('created_at')
            ->with(['master' => function ($q) {
                $q->where('status', '!=', 'deleted');
            }])
            ->get();

        $mergedNitiList = [];

        foreach ($managementEntries as $entry) {
            $niti = $entry->master;
            if (!$niti || $niti->niti_privacy !== 'public' || $niti->language !== 'Odia') {
                continue;
            }

            $runningSubNitiList = $runningSubNitis->where('niti_id', $niti->niti_id)->map(function ($sub) {
                return [
                    'sub_niti_id'   => $sub->sub_niti_id,
                    'sub_niti_name' => $sub->sub_niti_name,
                    'start_time'    => $sub->start_time,
                    'status'        => $sub->status,
                    'date'          => $sub->date,
                ];
            })->values();

            $mergedNitiList[] = [
                'niti_id'           => $niti->niti_id,
                'niti_name'         => $niti->niti_name,
                'english_niti_name' => $niti->english_niti_name,
                'niti_type'         => $niti->niti_type,
                'niti_status'       => $niti->niti_status,
                'date_time'         => $niti->date_time,
                'language'          => $niti->language,
                'niti_privacy'      => $niti->niti_privacy,
                'niti_about'        => $niti->niti_about,
                'niti_sebayat'      => $niti->niti_sebayat,
                'description'       => $niti->description,
                'start_time'        => $entry->start_time,
                'pause_time'        => $entry->pause_time,
                'resume_time'       => $entry->resume_time,
                'end_time'          => $entry->end_time,
                'duration'          => $entry->duration,
                'management_status' => $entry->niti_status,
                'after_special_niti_name' => null,
                'running_sub_niti'  => $runningSubNitiList,
            ];
        }

        // 2. Handle daily Nitis that haven't started yet
        $existingNitiIds = collect($mergedNitiList)->pluck('niti_id')->unique();

        $dailyNitis = NitiMaster::where('status', 'active')
            ->where('niti_type', 'daily')
            ->where('language', 'Odia')
            ->where('niti_privacy', 'public')
            ->orderBy('niti_order', 'asc')
            ->get();

        foreach ($dailyNitis as $dailyNiti) {
            if ($existingNitiIds->contains($dailyNiti->niti_id)) {
                continue;
            }

            $mergedNitiList[] = [
                'niti_id'           => $dailyNiti->niti_id,
                'niti_name'         => $dailyNiti->niti_name,
                'english_niti_name' => $dailyNiti->english_niti_name,
                'niti_type'         => $dailyNiti->niti_type,
                'niti_status'       => $dailyNiti->niti_status,
                'date_time'         => $dailyNiti->date_time,
                'language'          => $dailyNiti->language,
                'niti_privacy'      => $dailyNiti->niti_privacy,
                'niti_about'        => $dailyNiti->niti_about,
                'niti_sebayat'      => $dailyNiti->niti_sebayat,
                'description'       => $dailyNiti->description,
                'start_time'        => null,
                'pause_time'        => null,
                'resume_time'       => null,
                'end_time'          => null,
                'duration'          => null,
                'management_status' => null,
                'after_special_niti_name' => null,
                'running_sub_niti' => [],
            ];
        }

        return response()->json([
            'status' => true,
            'niti_master' => $mergedNitiList
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
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
