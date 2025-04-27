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
use App\Models\TempleHundi;
use App\Models\PanjiDetails;
use Carbon\Carbon;


class HomeSectionController extends Controller
{

public function puriWebsite()
{
    $templeId = 'TEMPLE25402';

    $latestDayId = NitiMaster::where('status', 'active')->latest('id')->value('day_id');

    if (!$latestDayId) {
        return response()->json([
            'status' => false,
            'message' => 'No active Niti found to determine day_id.'
        ], 404);
    }
    
    // Step 1: Get all active Nitis ordered by date_time (or serial)
    $allNitis = NitiMaster::where('status', 'active')
        ->where('language', 'Odia')
        ->where('niti_type', 'daily') // adjust this if needed
        ->with([
            'todayStartTime' => function ($query) use ($latestDayId) {
                $query->where('day_id', $latestDayId)
                      ->select('niti_id', 'niti_status', 'start_time');
            },
            'subNitis'
        ])
        ->orderBy('niti_order', 'asc')
        ->get();
    
    // Step 2: Find the last started Niti
    $currentIndex = null;
    
    foreach ($allNitis as $index => $niti) {
        if (
            optional($niti->todayStartTime)->niti_status === 'Started'
        ) {
            $currentIndex = $index;
        }
    }
    
    // Step 3: Pick current started and next upcoming
    $finalNitiList = collect();
    
    if ($currentIndex !== null) {
        // Add the currently started Niti
        $finalNitiList->push($allNitis[$currentIndex]);
    
        // Add the next one if it exists
        if (isset($allNitis[$currentIndex + 1])) {
            $finalNitiList->push($allNitis[$currentIndex + 1]);
        }
    } else {
        // If nothing is started, show first 2 upcoming
        foreach ($allNitis as $niti) {
            if (
                optional($niti->todayStartTime)->niti_status === 'Upcoming'
            ) {
                $finalNitiList->push($niti);
                if ($finalNitiList->count() >= 2) break;
            }
        }
    }

    $yesterday = Carbon::yesterday()->toDateString(); // 1 day ago
    $hundi = TempleHundi::where('temple_id', $templeId)
        ->where('date', $yesterday)
        ->first();

        $todayDate = Carbon::today()->toDateString();
        $todayPanji = PanjiDetails::where('date', $todayDate)->where('status', 'active')->first();
 
    return view('website.index3', [
        'nitis' => $finalNitiList->values(),
        'latestWebVideo' => TempleBanner::where('banner_type', 'web')->whereNotNull('banner_video')->latest()->first(),
        'nearbyTemples' => NearByTemple::whereNotNull('photo')->get(),
        'aboutTemple' => TempleAboutDetail::where('temple_id', $templeId)->first(),
        'photos' => TemplePhotosVideos::where('temple_id', $templeId)->first(),
        'matha' => Matha::where('temple_id', $templeId)->first(),
        'festival' => TempleFestival::with('subFestivals')->where('temple_id', $templeId)->first(),
        'nijoga' => NijogaMaster::where('temple_id', $templeId)->first(),
        'besha' => TempleBesha::whereNotNull('besha_name')->first(),
        'darshan' => TempleDarshan::where('temple_id', $templeId)->first(),
        'prasad' => TemplePrasad::where('temple_id', $templeId)->first(),
        'hundi' => $hundi, // <-- Send hundi data to blade
        'todayPanji' => $todayPanji, // Pass today Panji


    ]);
}

public function viewAllNiti()
{
    // ✅ Get latest active day_id
    $latestDayId = NitiMaster::where('status', 'active')->latest('id')->value('day_id');

    if (!$latestDayId) {
        return response()->json([
            'status' => false,
            'message' => 'No active Niti found to determine day_id.'
        ], 404);
    }

    // ✅ Fetch Running or Completed Sub Nitis for this day_id
    $runningSubNitis = TempleSubNitiManagement::whereIn('status', ['Running', 'Completed'])
        ->where('day_id', $latestDayId)
        ->get();

    // ✅ Fetch Daily Nitis (active + public)
    $dailyNitis = NitiMaster::where('status', 'active')
        ->where('niti_type', 'daily')
        ->where('language', 'Odia')
        ->where('niti_privacy', 'public')
        ->where('day_id', $latestDayId)
        ->orderBy('niti_order', 'asc')
        ->get();

    // ✅ Fetch Special Nitis (active + public + today) grouped by their position
    $specialNitis = NitiMaster::where('status', 'active')
        ->where('niti_type', 'special')
        ->where('language', 'Odia')
        ->where('niti_privacy', 'public')
        ->where('day_id', $latestDayId)
        ->get()
        ->groupBy('after_special_niti');

    // ✅ Final Merged List
    $mergedNitiList = [];

    foreach ($dailyNitis as $dailyNiti) {
        // ✅ Get latest management record (even if not completed yet)
        $dailyManagement = NitiManagement::where('niti_id', $dailyNiti->niti_id)
            ->where('day_id', $latestDayId)
            ->latest('start_time')
            ->first();

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

        // ✅ Attach special nitis (if any) after current daily niti
        $specialsAfter = $specialNitis->get($dailyNiti->niti_id, collect());

        foreach ($specialsAfter as $specialNiti) {
            $specialManagement = NitiManagement::where('niti_id', $specialNiti->niti_id)
                ->where('day_id', $latestDayId)
                ->latest('start_time')
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

    return view('website.view-all-niti', compact('mergedNitiList'));
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

public function viewNearByTemple($id)
{
    $temple = NearByTemple::findOrFail($id);
    return view('website.view-near-by-temple', compact('temple'));
}

public function privacyPolicy(){
    return view('website.temple-privacy-police');
}

}
