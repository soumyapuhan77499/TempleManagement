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

        $activeNitiIds = NitiMaster::whereIn('niti_status', ['Started', 'Paused'])->pluck('niti_id');

        $runningSubNitis = TempleSubNitiManagement::where(function ($query) {
            $query->where('status', 'Running')
                  ->orWhere('status', '!=', 'Deleted');
        })
        ->whereDate('date', $today)
        ->whereIn('niti_id', $activeNitiIds)
        ->get();

        $dailyNitis = NitiMaster::where('status', 'active')
            ->where('niti_type', 'daily')
            ->where('niti_privacy', 'public')
            ->orderBy('date_time', 'asc')
            ->get();

        $specialNitisGrouped = NitiMaster::where('status', 'active')
            ->where('niti_type', 'special')
            ->whereDate('date_time', $today)
            ->where('niti_privacy', 'public')
            ->get()
            ->groupBy('after_special_niti');

        $mergedNitiList = [];

        foreach ($dailyNitis as $dailyNiti) {
            $matchingRunningSubNitis = $runningSubNitis->where('niti_id', $dailyNiti->niti_id);

            // ✅ Get latest entry for this Niti, even if it's not ended yet
            $dailyManagement = NitiManagement::where('niti_id', $dailyNiti->niti_id)
                ->whereDate('date', $today)
                ->latest('created_at')
                ->first();

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

            // Special Nitis after this Daily
            $specialsAfter = $specialNitisGrouped->get($dailyNiti->niti_id, collect());

            foreach ($specialsAfter as $specialNiti) {
                $specialManagement = NitiManagement::where('niti_id', $specialNiti->niti_id)
                    ->whereDate('date', $today)
                    ->latest('created_at')
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

        // ✅ Other sections
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
