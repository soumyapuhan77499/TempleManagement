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

        $result = $nitis->map(function ($niti) use ($today) {
            $management = NitiManagement::where('niti_id', $niti->niti_id)
                ->whereDate('date', $today)
                ->orderBy('start_time', 'desc')
                ->first();

            $runningSubNiti = TempleSubNitiManagement::where('niti_id', $niti->niti_id)
                ->whereDate('date', $today)
                ->where('status', 'Running')
                ->orderBy('start_time', 'desc')
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
                'start_time'    => $management->start_time ?? null,
                'pause_time'    => $management->pause_time ?? null,
                'resume_time'   => $management->resume_time ?? null,
                'end_time'      => $management->end_time ?? null,
                'duration'      => $management->duration ?? null,
                'management_status' => $management->niti_status ?? null,
                'sub_niti' => $runningSubNiti ? [
                    'sub_niti_id'   => $runningSubNiti->sub_niti_id,
                    'sub_niti_name' => $runningSubNiti->sub_niti_name,
                    'status'        => $runningSubNiti->status,
                    'start_time'    => $runningSubNiti->start_time,
                    'date'          => $runningSubNiti->date
                ] : null,
            ];
        });

        // ✅ Sort Niti list by start_time
        $sortedResult = $result->sortBy(function ($item) {
            return $item['start_time'] ?? '99:99:99';
        })->values();

        // ✅ Fetch global Running Sub Nitis
        $subNitis = TempleSubNitiManagement::where('status', 'Running')
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

        // ✅ Other data
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

        // ✅ Final response
        return response()->json([
            'status' => true,
            'message' => 'Temple website data fetched successfully.',
            'data' => [
                'niti_master'         => $sortedResult,
                'running_sub_nitis'   => $subNitis,
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
