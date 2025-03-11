<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CountryList;
use App\Models\StateList;

class LocationController extends Controller
{
    public function getCountries()
    {
        $countries = CountryList::all(); // Fetch all countries from DB
        return response()->json($countries);
    }

    // Fetch states based on selected country
    public function getStates($country_id)
    {
        $states = StateList::where('country_id', $country_id)->get();
        return response()->json($states);
    }
}
