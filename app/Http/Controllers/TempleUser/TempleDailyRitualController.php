<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleRitual;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TempleDailyRitualController extends Controller
{
    public function dailyritual()
    {
        $weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return view('templeuser.add-daily-ritual', compact('weekDays'));
    }
    
    public function saveTempleRitual(Request $request)
    {
        \Log::info($request->all()); // Log all request data

        try {
            // Validate the input
            $request->validate([
                'ritual_name.*' => 'required|string|max:255',
                'day_name.*' => 'required|string',
                'ritual_start_time.*' => 'required',
                'ritual_end_time.*' => 'required',
                'ritual_start_period.*' => 'required',
                'ritual_end_period.*' => 'required',
                'ritual_image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:3074',
                'ritual_video.*' => 'nullable|mimes:mp4,avi,mov|max:100000',
                'description.*' => 'nullable|string',
            ]);
    
            $templeId = Auth::guard('temples')->user()->temple_id;
    
            // Loop through each ritual based on the number of rituals in the form
            if (is_array($request->ritual_name)) {
                foreach ($request->ritual_name as $index => $ritualName) {
                    // Convert times to Carbon instances
                    $startTime = $this->convert24ToCarbonInstance($request->ritual_start_time[$index], $request->ritual_start_period[$index]);
                    $endTime = $this->convert24ToCarbonInstance($request->ritual_end_time[$index], $request->ritual_end_period[$index]);
    
                    // Calculate ritual duration
                    $durationInMinutes = $startTime->diffInMinutes($endTime);
                    $hours = intdiv($durationInMinutes, 60);
                    $minutes = $durationInMinutes % 60;
                    $ritualDuration = sprintf('%02d:%02d', $hours, $minutes);  // Format as HH:MM
    
                    // Handle file uploads
                    $ritualImage = null;
                    $ritualVideo = null;
    
                    if ($request->hasFile('ritual_image.' . $index)) {
                        $image = $request->file('ritual_image.' . $index);
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $imagePath = 'assets/temple/ritual_images';
                        $image->move(public_path($imagePath), $imageName);
                        $ritualImage = $imagePath . '/' . $imageName;  // Save the relative path to the database
                    }
    
                    if ($request->hasFile('ritual_video.' . $index)) {
                        $video = $request->file('ritual_video.' . $index);
                        $videoName = time() . '_' . $video->getClientOriginalName();
                        $videoPath = 'assets/temple/ritual_videos';
                        $video->move(public_path($videoPath), $videoName);
                        $ritualVideo = $videoPath . '/' . $videoName;  // Save the relative path to the database
                    }
    
                    // Save ritual data using the TempleRitual model
                    $templeRitual = new TempleRitual();
                    $templeRitual->temple_id = $templeId;
                    $templeRitual->ritual_name = $ritualName;
                    $templeRitual->ritual_day_name = $request->day_name[$index];
                    $templeRitual->ritual_start_time = $startTime->format('H:i');
                    $templeRitual->ritual_end_time = $endTime->format('H:i');
                    $templeRitual->ritual_duration = $ritualDuration;
                    $templeRitual->ritual_start_period = $request->ritual_start_period[$index]; 
                    $templeRitual->ritual_end_period = $request->ritual_end_period[$index]; 
                    $templeRitual->ritual_image = $ritualImage;
                    $templeRitual->ritual_video = $ritualVideo;
                    $templeRitual->description = $request->description[$index];
                    $templeRitual->save();
                }
            }
    
            // Redirect with success message
            return redirect()->back()->with('success', 'Rituals saved successfully.');
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving the rituals. ' . $e->getMessage()]);
        }
    }
    
private function convert24ToCarbonInstance($time, $period)
{
    // Convert time from 24-hour format to 12-hour format with AM/PM and return a Carbon instance
    return Carbon::createFromFormat('H:i A', Carbon::createFromFormat('H:i', $time)->format('h:i') . ' ' . $period);
}

public function manageDailyRitual()
{
    // Fetch all data from the temple_rituals table where status is active (assuming 1 represents active)
    $rituals = TempleRitual::where('status', 'active')->get();

    // Pass data to the view
    return view('templeuser.manage-daily-ritual', compact('rituals'));
}

public function edit($id)
{
    $ritual = TempleRitual::findOrFail($id);
    return view('templeuser.edit-daily-ritual', compact('ritual'));
}

public function updateRitual(Request $request, $id)
{
    $request->validate([
        'day_name' => 'required|string',
        'ritual_name' => 'required|string',
        'ritual_date' => 'required|date',
        'ritual_start_time' => 'required|date_format:H:i',
        'ritual_start_period' => 'required|in:AM,PM',
        'ritual_end_time' => 'required|date_format:H:i',
        'ritual_end_period' => 'required|in:AM,PM',
        'ritual_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'ritual_video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
        'description' => 'nullable|string',
    ]);

    $ritual = TempleRitual::findOrFail($id);
    
    $ritual->ritual_day_name = $request->input('day_name');
    $ritual->ritual_name = $request->input('ritual_name');
    $ritual->ritual_date = $request->input('ritual_date');
    $ritual->ritual_start_time = $request->input('ritual_start_time');
    $ritual->ritual_end_time = $request->input('ritual_end_time');
    $ritual->ritual_end_period =  $request->input('ritual_end_period'); 
    $ritual->ritual_start_period = $request->input('ritual_start_period'); 
    $ritual->description = $request->input('description');
    if ($request->hasFile('ritual_image')) {
        // Delete the old image if it exists
        if ($ritual->ritual_image) {
            Storage::delete(public_path($ritual->ritual_image));
        }
        // Save the new image
        $image = $request->file('ritual_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'assets/temple/ritual_images';
        $image->move(public_path($imagePath), $imageName);
        $ritual->ritual_image = $imagePath . '/' . $imageName;
    }

    // Handle the ritual video
    if ($request->hasFile('ritual_video')) {
        // Delete the old video if it exists
        if ($ritual->ritual_video) {
            Storage::delete(public_path($ritual->ritual_video));
        }
        // Save the new video
        $video = $request->file('ritual_video');
        $videoName = time() . '_' . $video->getClientOriginalName();
        $videoPath = 'assets/temple/ritual_videos';
        $video->move(public_path($videoPath), $videoName);
        $ritual->ritual_video = $videoPath . '/' . $videoName;
    }
    $ritual->save();

    return redirect()->route('templeuser.manage-dailyritual')
                     ->with('success', 'Ritual updated successfully.');
}

public function deletRitual($id)
{
    // Find the ritual by ID or fail if not found
    $ritual = TempleRitual::findOrFail($id);

    // Set the status to indicate the ritual is deleted
    $ritual->status = 'deleted'; // Assuming 0 indicates inactive or deleted
    $ritual->save();

    // Optionally delete files if needed
    if ($ritual->ritual_image) {
        Storage::delete('public/' . $ritual->ritual_image);
    }
    if ($ritual->ritual_video) {
        Storage::delete('public/' . $ritual->ritual_video);
    }

    return redirect()->route('templeuser.manage-dailyritual')->with('success', 'Ritual status updated to deleted.');
}



}
