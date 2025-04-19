<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleBanner;
use App\Models\NitiMaster;
use App\Models\NearByTemple;
use App\Models\TempleAboutDetail;
use App\Models\TemplePhotosVideos;
use App\Models\TempleSubNitiManagement;
use App\Models\NitiManagement;
use App\Models\TempleSubNiti;
use App\Models\Matha;
use App\Models\TempleFestival;
use App\Models\NijogaMaster;
use App\Models\TempleBesha;
use App\Models\TempleDarshan;
use App\Models\TemplePrasad;


class HomeSectionController extends Controller
{

public function puriWebsite()
{
    $templeId = 'TEMPLE25402';

    return view('website.index3', [
        'latestWebVideo' => TempleBanner::where('banner_type', 'web')->whereNotNull('banner_video')->latest()->first(),
        'nitis' => NitiMaster::orderBy('date_time', 'asc')->take(2)->get(),
        'nearbyTemples' => NearByTemple::whereNotNull('photo')->get(),
        'aboutTemple' => TempleAboutDetail::where('temple_id', $templeId)->first(),
        'photos' => TemplePhotosVideos::where('temple_id', $templeId)->first(),
        'matha' => Matha::where('temple_id', $templeId)->first(),
        'festival' => TempleFestival::with('subFestivals')->where('temple_id', $templeId)->first(),
        'nijoga' => NijogaMaster::where('temple_id', $templeId)->first(),
        'besha' => TempleBesha::whereNotNull('besha_name')->first(),
        'darshan' => TempleDarshan::where('temple_id', $templeId)->first(),
        'prasad' => TemplePrasad::where('temple_id', $templeId)->first(),
    ]);
}

public function viewAllNiti()
{
    $today = \Carbon\Carbon::now()->toDateString();

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

        $mergedNitiList[] = [
            ...$dailyNiti->toArray(),
            'start_time'    => null,
            'pause_time'    => null,
            'resume_time'   => null,
            'end_time'      => null,
            'duration'      => null,
            'management_status' => null,
            'after_special_niti_name' => null,
            'running_sub_niti' => $matchingRunningSubNitis->map(fn ($sub) => [
                'sub_niti_id'   => $sub->sub_niti_id,
                'sub_niti_name' => $sub->sub_niti_name,
                'start_time'    => $sub->start_time,
                'status'        => $sub->status,
                'date'          => $sub->date,
            ])->values(),
        ];

        $specialsAfter = $specialNitisGrouped->get($dailyNiti->niti_id, collect());

        foreach ($specialsAfter as $specialNiti) {
            $management = NitiManagement::where('niti_id', $specialNiti->niti_id)
                ->whereDate('date', $today)
                ->orderBy('start_time', 'desc')
                ->first();

            $specialRunningSubNitis = $runningSubNitis->where('niti_id', $specialNiti->niti_id);

            $mergedNitiList[] = [
                ...$specialNiti->toArray(),
                'start_time'    => $management->start_time ?? null,
                'pause_time'    => $management->pause_time ?? null,
                'resume_time'   => $management->resume_time ?? null,
                'end_time'      => $management->end_time ?? null,
                'duration'      => $management->duration ?? null,
                'management_status' => $management->niti_status ?? null,
                'after_special_niti_name' => $dailyNiti->niti_name,
                'running_sub_niti' => $specialRunningSubNitis->map(fn ($sub) => [
                    'sub_niti_id'   => $sub->sub_niti_id,
                    'sub_niti_name' => $sub->sub_niti_name,
                    'start_time'    => $sub->start_time,
                    'status'        => $sub->status,
                    'date'          => $sub->date,
                ])->values(),
            ];
        }
    }

    return view('website.view-all-niti', ['nitis' => $mergedNitiList]);
}


public function mandirTv(){
    return view('website.tv-layout');
}

public function mandirRadio(){
    return view('website.radio-layout');
}

public function mandirDarshan()
{
    $templeId = 'TEMPLE25402';

    $darshans = TempleDarshan::where('temple_id', 'TEMPLE25402')
    ->orderBy('darshan_start_time', 'asc')
    ->get();

    return view('website.temple-darshan-list', compact('darshans'));
}


}
