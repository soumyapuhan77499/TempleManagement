<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PanjiDetails;
use Carbon\Carbon;

class PanjiController extends Controller
{

    public function addPanji(){

        $events = PanjiDetails::where('status','active')->get();

        return view('templeuser.add-panji', compact('events'));
    }

    public function savePanjiDetails(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'date' => 'required|date',
            'tithi' => 'nullable|string',
            'sun_set' => 'nullable|date_format:H:i',
            'sun_rise' => 'nullable|date_format:H:i',
            'good_time' => 'nullable|string',
            'bad_time' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Get the selected date
        $selectedDate = Carbon::parse($request->date); // Using Carbon to parse the date

        // Save the Panji data
        PanjiDetails::create([
            'year' => $selectedDate->year,    // Save the year
            'date' => $selectedDate->toDateString(),    // Save the date in YYYY-MM-DD format
            'day' => $selectedDate->format('l'),    // Save the day name (e.g., "Monday")
            'language' => $request->language,
            'event_name' => $request->event_name,
            'tithi' => $request->tithi,
            'yoga' => $request->yoga,
            'nakshatra' => $request->nakshatra,
            'sun_set' => $request->sun_set,
            'sun_rise' => $request->sun_rise,
            'good_time' => $request->good_time,
            'bad_time' => $request->bad_time,
            'description' => $request->description,
        ]);

        // Redirect or send a response
        return redirect()->back()->with('success', 'Panji details saved successfully!');
    }

    public function updatePanjiDetails(Request $request, $id)
{
    // Find the event by ID
    $event = PanjiDetails::findOrFail($id);

    // Validate the incoming data
    $request->validate([
        'date' => 'required|date',
        'tithi' => 'nullable|string',
        'sun_set' => 'nullable|date_format:H:i',
        'sun_rise' => 'nullable|date_format:H:i',
        'good_time' => 'nullable|string',
        'bad_time' => 'nullable|string',
        'description' => 'nullable|string',
    ]);

    // Update the Panji data
    $event->update([
        'date' => Carbon::parse($request->date)->toDateString(),
        'language' => $request->language,
        'event_name' => $request->event_name,
        'tithi' => $request->tithi,
        'yoga' => $request->yoga,
        'nakshatra' => $request->nakshatra,
        'sun_set' => $request->sun_set,
        'sun_rise' => $request->sun_rise,
        'good_time' => $request->good_time,
        'bad_time' => $request->bad_time,
        'description' => $request->description,
    ]);

    // Redirect or send a response
    return redirect()->route('templeuser.addPanji')->with('success', 'Panji details updated successfully!');
}


public function getPanjiDetails()
{
    $panji_details = PanjiDetails::where('status', 'active')->get();
                            
}

}
