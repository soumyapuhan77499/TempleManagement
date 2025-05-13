<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePrasad;
use App\Models\PrasadManagement;
use App\Models\NitiMaster;
use App\Models\Parking;
use App\Models\DarshanDetails;
use App\Models\DarshanManagement;
use App\Models\Accomodation;
use App\Models\PublicServices;
use App\Models\NearByTemple;
use App\Models\PanjiDetails;
use App\Models\TempleHundi;

use Carbon\Carbon;

class QuickServiceController extends Controller
{

public function prasadTimeline()
{
    $latestDayId = NitiMaster::where('status', 'active')->latest('id')->value('day_id');

    if (!$latestDayId) {
        return response()->json([
            'status' => false,
            'message' => 'No active Niti found to determine day_id.'
        ], 404);
    }

    $prasads = TemplePrasad::where('language', 'Odia')->get();

    // Map Prasad with today's management data
    $prasadList = $prasads->map(function ($prasad) use ($latestDayId) {
        $todayLog = PrasadManagement::where('prasad_id', $prasad->id)
        ->where('day_id', $latestDayId)
            ->latest()
            ->first();

        return (object)[
            'prasad_id'     => $prasad->id,
            'prasad_name'   => $prasad->prasad_name,
            'prasad_type'   => $prasad->prasad_type,
            'prasad_photo'  => $prasad->prasad_photo,
            'prasad_item'   => $prasad->prasad_item,
            'description'   => $prasad->description,
            'online_order'  => $prasad->online_order,
            'pre_order'     => $prasad->pre_order,
            'offline_order' => $prasad->offline_order,
            'master_status' => $prasad->prasad_status,
            'start_time'    => $todayLog->start_time ?? null,
            'date'          => $todayLog->date ?? null,
            'today_status'  => $prasad->prasad_status ?? null, // could be 'Started', 'Completed', etc.
        ];
    });

    return view('website.temple-prasad-list', compact('prasadList'));
}

public function parkingList()
{
    $templeId = 'TEMPLE25402';

    $temples = NearByTemple::where('language', 'English')->get();

    $parking = Parking::where('temple_id', $templeId)->where('status','active')->where('language','English')->get();

    return view('website.parking-list', compact('parking','temples'));
}

public function bhaktanibasList(){

    $templeId = 'TEMPLE25402'; // adjust as needed

    $bhaktaNibas = Accomodation::where('temple_id', $templeId)
        ->where('accomodation_type', 'bhakta_niwas')
        ->where('language', 'English')
        ->get();

    $temples = NearByTemple::where('language', 'English')->get();


    return view('website.bhaktanibas-list', compact('bhaktaNibas','temples'));

}

public function lockerShoeList()
{
    $templeId = 'TEMPLE25402'; // change if needed

    $temples = NearByTemple::where('language', 'English')->get();


    $services = PublicServices::where('temple_id', $templeId)
        ->whereIn('service_type', ['locker', 'shoe_stand'])
        ->where('status', 'active')
        ->where('language','English')
        ->get();

    return view('website.locker-shoe-list', compact('services','temples'));
}

public function getDarshanList()
{
    $latestDayId = NitiMaster::where('status', 'active')->latest('id')->value('day_id');

    $temples = NearByTemple::where('language', 'English')->get();

    if (!$latestDayId) {
        return response()->json([
            'status' => false,
            'message' => 'No active Niti found to determine day_id.'
        ], 404);
    }

    $darshans = DarshanDetails::where('status', 'active')->where('language', 'Odia')->get();

    $darshanList = $darshans->map(function ($darshan) use ($latestDayId) {
        $todayLog = DarshanManagement::where('darshan_id', $darshan->id)
            ->where('day_id', $latestDayId)
            ->latest('start_time')
            ->first();

        return (object) [
            'darshan_id'     => $darshan->id,
            'darshan_name'   => $darshan->darshan_name,
            'darshan_day'    => $darshan->darshan_day ?? 'N/A',
            'darshan_image'  => $darshan->darshan_image ?? null,
            'description'    => $darshan->description,
            'start_time'     => $todayLog?->start_time,
            'end_time'       => $todayLog?->end_time,
            'duration'       => $todayLog?->duration,
            'date'           => $todayLog?->date,
            'today_status'   => $todayLog?->darshan_status ?? 'Upcoming',
        ];
    });

    return view('website.temple-darshan-list', compact('darshanList','temples'));
}

public function viewNearByTemple($id)
{
    $temples = NearByTemple::findOrFail($id);

    return view('website.view-near-by-temple', compact('temples'));
}

public function showByServiceType($service_type)
{
    // Fetch services matching the clicked type
    $services = PublicServices::where('service_type', $service_type)
                ->where('status', 'active') // Only active services
                ->where('language','English')
                ->get();

    $temples = NearByTemple::where('language', 'English')->get();


    return view('website.temple-convience', compact('services', 'service_type','temples'));
}

public function viewPanji()
{
    $todayDate = Carbon::today()->toDateString();

    $temples = NearByTemple::where('language', 'English')->get();

    $todayPanji = PanjiDetails::where('date', $todayDate)->where('status', 'active')->where('language','English')->first();

    return view('website.view-panji-details', compact('todayPanji','temples'));  
} 

public function serviceEmergerncy(){

    $temples = NearByTemple::where('language', 'English')->get();

    return view('website.emergency-contact', compact('temples'));
    
}

public function serviceAbled()
{

    $temples = NearByTemple::where('language', 'English')->get();
    return view('website.service-abled', compact('temples'));
}

public function onlineDonation()
{
    $temples = NearByTemple::where('language', 'English')->get();
    return view('website.online-donation', compact('temples'));

}

public function hundiCollection()
{
    $yesterday = Carbon::yesterday()->toDateString(); // 1 day ago
    $temples = NearByTemple::where('language', 'English')->get();
    $hundi = TempleHundi::where('date', $yesterday)
    ->first();

    return view('website.hundi-collection' , compact('hundi', 'temples'));

}

}
