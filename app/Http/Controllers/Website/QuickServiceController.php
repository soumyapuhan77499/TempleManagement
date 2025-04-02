<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePrasad;
use App\Models\Parking;
use App\Models\Accomodation;
use App\Models\PublicServices;

class QuickServiceController extends Controller
{

public function prasadTimeline()
{
    $templeId = 'TEMPLE25402';
    $prasads = TemplePrasad::where('temple_id', $templeId)->orderBy('prasad_time')->get();
    return view('website.temple-prasad-list', compact('prasads'));
}

public function parkingList()
{
    $templeId = 'TEMPLE25402';

    $parking = Parking::where('temple_id', $templeId)->where('status','active')->get();

    return view('website.parking-list', compact('parking'));
}

public function bhaktanibasList(){

    $templeId = 'TEMPLE25402'; // adjust as needed

    $bhaktaNibas = Accomodation::where('temple_id', $templeId)
        ->where('accomodation_type', 'bhakta_niwas')
        ->get();

    return view('website.bhaktanibas-list', compact('bhaktaNibas'));

}

public function lockerShoeList()
{
    $templeId = 'TEMPLE25402'; // change if needed

    $services = PublicServices::where('temple_id', $templeId)
        ->whereIn('service_type', ['locker', 'shoe_stand'])
        ->where('status', 'active')
        ->get();

    return view('website.locker-shoe-list', compact('services'));
}
}
