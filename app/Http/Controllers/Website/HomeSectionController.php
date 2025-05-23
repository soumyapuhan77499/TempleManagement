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
use App\Models\TempleNews;

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

        $todayDate = Carbon::today()->toDateString();
        $todayPanji = PanjiDetails::where('date', $todayDate)->where('status', 'active')->first();

         $information = TempleNews::where('type', 'information')
        ->where('type','information')
        ->where('status','active')
        ->orderBy('created_at', 'desc')
        ->get(['id', 'niti_notice', 'status'])
        ->first();
    
 
    return view('website.index3', [
        'nitis' => $finalNitiList->values(),
        'latestWebVideo' => TempleBanner::where('banner_type', 'web')->whereNotNull('banner_video')->latest()->first(),
        'nearbyTemples' => NearByTemple::whereNotNull('photo')->where('language','English')->get(),
        'aboutTemple' => TempleAboutDetail::where('temple_id', $templeId)->first(),
        'photos' => TemplePhotosVideos::where('temple_id', $templeId)->first(),
        'matha' => Matha::where('temple_id', $templeId)->first(),
        'festival' => TempleFestival::with('subFestivals')->where('temple_id', $templeId)->first(),
        'nijoga' => NijogaMaster::where('temple_id', $templeId)->first(),
        'besha' => TempleBesha::whereNotNull('besha_name')->first(),
        'darshan' => TempleDarshan::where('temple_id', $templeId)->first(),
        'prasad' => TemplePrasad::where('temple_id', $templeId)->first(),
        'todayPanji' => $todayPanji, // Pass today Panji
        'temples' => NearByTemple::where('language', 'English')->get(),
        'nitiInfo' => $information,

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

    // ✅ Only load daily & special nitis — exclude "other" completely
    $allNitis = NitiMaster::whereIn('niti_type', ['daily', 'special'])
        ->where('niti_privacy', 'public')
        ->orderBy('niti_order', 'asc')
        ->get()
        ->keyBy('niti_id');

    // ✅ Get management records only for daily/special
    $nitiManagements = NitiManagement::where('day_id', $latestDayId)
        ->with('master')
        ->whereHas('master', function ($query) {
            $query->whereIn('niti_type', ['daily', 'special']);
        })
        ->get()
        ->groupBy('niti_id');

    // ✅ Running sub-nitis
    $activeNitiIds = NitiMaster::whereIn('niti_status', ['Started', 'Paused'])->pluck('niti_id');
    $runningSubNitis = TempleSubNitiManagement::where(function ($query) {
            $query->where('status', 'Running')->orWhere('status', '!=', 'Deleted');
        })
        ->where('day_id', $latestDayId)
        ->whereIn('niti_id', $activeNitiIds)
        ->get();

    // ✅ Group special nitis triggered after a daily one
    $specialNitisGrouped = $allNitis->filter(fn($niti) => $niti->niti_type === 'special')
        ->groupBy('after_special_niti');

    $mergedNitiList = [];

    // ✅ Loop for daily & special nitis
    foreach ($allNitis as $niti_id => $niti) {
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

        // ✅ Add special nitis triggered after this daily one
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
    $otherNitiManagements = NitiManagement::where('day_id', $latestDayId)
        ->with('master')
        ->whereHas('master', function ($query) {
            $query->where('niti_type', 'other');
        })
        ->get()
        ->groupBy(function ($item) {
            // Group by unique start_time to identify the same execution
            return $item->niti_id . '|' . ($item->start_time ?? $item->id);
        })
        ->map(function ($group) {
            // Prefer 'Completed' over 'Started'
            return $group->where('niti_status', 'Completed')->first()
                ?? $group->where('niti_status', 'Started')->first();
        })
        ->sortBy('start_time')
        ->values();


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

    // ✅ Final sorting
    $mergedNitiList = collect($mergedNitiList)->sortBy(function ($item) {
        return $item['start_time'] ?? '9999:99:99';
    })->values();

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

public function viewNearByTemple($name)
{
    $temple = NearByTemple::where('name', $name)->first(); // ✅ single object
    return view('website.view-near-by-temple', compact('temple'));
}

public function privacyPolicy(){
    return view('website.temple-privacy-police');
}

}
