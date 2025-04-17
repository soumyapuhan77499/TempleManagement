<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDarshan;
use App\Models\DarshanDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class TempleDarshanController extends Controller
{
    public function templeDarshan(){
        
        $weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        return view('templeuser.add-temple-darshan', compact('weekDays'));
    }

    public function ManageTempleDarshan(){

        $templeId = Auth::guard('temples')->user()->temple_id;

        $darshans = TempleDarshan::where('status', 'active')->where('temple_id', $templeId)->get();
    
        $groupedDarshans = $darshans->groupBy('darshan_day');
    
        $weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    
        return view('templeuser.manage-temple-darshan', compact('groupedDarshans', 'weekDays'));
    }

    public function saveTempleDarshan(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'darshan_name.*' => 'required|string|max:255',
            'darshan_start_time.*' => 'required',
            'darshan_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'description.*' => 'nullable|string',
        ]);
    
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        try {
            // Loop through each darshan entry
            foreach ($request->darshan_name as $key => $darshanName) {
    
                $startTime = $this->convert24ToCarbonInstance($request->darshan_start_time[$key], $request->darshan_start_period[$key]);
                $endTime = $this->convert24ToCarbonInstance($request->darshan_end_time[$key], $request->darshan_end_period[$key]);
    
                // Calculate darshan duration
                $durationInMinutes = $startTime->diffInMinutes($endTime);
                $hours = intdiv($durationInMinutes, 60);
                $minutes = $durationInMinutes % 60;
                $darshanDuration = sprintf('%02d:%02d', $hours, $minutes);  // Format as HH:MM
    
                // Create a new Darshan record
                $darshan = new TempleDarshan();
    
                // Store darshan data
                $darshan->temple_id = $templeId;
                $darshan->darshan_day = $request->day_name[$key];
                $darshan->darshan_name = $darshanName;
                $darshan->darshan_start_time = $request->darshan_start_time[$key];
                $darshan->darshan_end_time = $request->darshan_end_time[$key];
                $darshan->darshan_duration = $darshanDuration;
    
                // Handle image upload
                if ($request->hasFile('darshan_image.' . $key)) {
                    $image = $request->file('darshan_image.' . $key);
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = 'assets/temple/darshan_images';
                    $image->move(public_path($imagePath), $imageName);
                    $darshan->darshan_image = $imagePath . '/' . $imageName;
                }
    
                // Save description
                $darshan->description = $request->description[$key] ?? null;
    
                // Save the darshan record
                $darshan->save();
            }
    
            return redirect()->back()->with('success', 'Darshans saved successfully.');
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Error saving darshans: ' . $e->getMessage());
    
            return redirect()->back()->with('danger', 'An error occurred while saving darshans: ' . $e->getMessage());
        }
    }

    private function convert24ToCarbonInstance($time, $period)
{
    // Convert time from 24-hour format to 12-hour format with AM/PM and return a Carbon instance
    return Carbon::createFromFormat('H:i A', Carbon::createFromFormat('H:i', $time)->format('h:i') . ' ' . $period);
}

public function updateTempleDarshan(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'darshan_name.*' => 'required|string|max:255',
        'darshan_start_time.*' => 'required',
        'description.*' => 'nullable|string',
        'darshan_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        // Loop through each darshan entry
        foreach ($request->darshan_id as $key => $id) {

            // Convert start and end time to Carbon instances
            $startTime = $this->convert24ToCarbonInstance($request->darshan_start_time[$key]);
            $endTime = $this->convert24ToCarbonInstance($request->darshan_end_time[$key]);

            // Check if start time is greater than end time (overnight case)
            if ($startTime->greaterThan($endTime)) {
                // Add one day to the end time
                $endTime->addDay();
            }

            // Calculate darshan duration
            $durationInMinutes = $startTime->diffInMinutes($endTime);
            $hours = intdiv($durationInMinutes, 60);
            $minutes = $durationInMinutes % 60;
            $darshanDuration = sprintf('%02d:%02d', $hours, $minutes);  // Format as HH:MM

            // Find the darshan entry by ID
            $darshan = TempleDarshan::find($id);

            if ($darshan) {
                // Update the darshan details
                $darshan->darshan_name = $request->darshan_name[$key];
                $darshan->darshan_start_time = $request->darshan_start_time[$key];
                $darshan->darshan_end_time = $request->darshan_end_time[$key];
                $darshan->darshan_duration = $darshanDuration;  // Save the calculated darshan duration
                $darshan->description = $request->description[$key] ?? null;

                // Handle image upload if a new image is uploaded
                if ($request->hasFile('darshan_image.' . $key)) {
                    $image = $request->file('darshan_image.' . $key);
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = 'assets/temple/darshan_images';
                    $image->move(public_path($imagePath), $imageName);
                    $darshan->darshan_image = $imagePath . '/' . $imageName;
                }

                // Save the darshan details
                $darshan->save();
            }
        }

        return redirect()->back()->with('success', 'Darshans updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('danger', 'An error occurred while updating darshans: ' . $e->getMessage());
    }
}

public function deleteTempleDarshan($id)
{
    try {
        // Find the darshan by ID
        $darshan = TempleDarshan::find($id);

        if ($darshan) {
            // Update the status to 'deleted'
            $darshan->status = 'deleted';
            $darshan->save();

            return redirect()->back()->with('success', 'Darshan deleted successfully.');
        } else {
            return redirect()->back()->with('danger', 'Darshan not found.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('danger', 'An error occurred while deleting the darshan: ' . $e->getMessage());
    }
}

public function darshanManagement()
{
    return view('templeuser.temple-darshan-management');
}

public function saveDarshanManagement(Request $request)
{
    $request->validate([
        'darshan_name' => 'required|string|max:255',
        'darshan_type' => 'required|in:special,normal',
        'darshan_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'duration' => 'required|string|max:50',
    ]);

    $templeId = Auth::guard('temples')->user()->temple_id;

    try {
        DarshanDetails::create([
            'temple_id'     => $templeId,
            'darshan_name'  => $request->darshan_name,
            'darshan_type'  => $request->darshan_type,
            'date'          => $request->darshan_date,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
            'duration'      => $request->duration,
            'description'   => $request->description,
        ]);

        return redirect()->back()->with('success', 'Darshan saved successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}

public function ManageDarshanManagement(){

    $templeId = Auth::guard('temples')->user()->temple_id;

    $darshans = DarshanDetails::where('status', 'active')->where('temple_id', $templeId)->get();

    return view('templeuser.manage-darshan-management', compact('darshans'));
    
}

}
