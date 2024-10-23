<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleRitual;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TempleDailyRitualController extends Controller
{
    public function saveTempleRitual(Request $request)
    {
        try {
            $templeId = Auth::guard('api')->user()->temple_id;

            if (!$templeId) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid temple ID. Please authenticate again.',
                ], 400);
            }

            // Validate that the required fields are present
            $this->validate($request, [
                'ritual_name' => 'required|array',
            ]);

            // Loop through each ritual based on the number of rituals in the request
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
                
                // Save the ritual and check for success
                if (!$templeRitual->save()) {
                    throw new \Exception("Failed to save ritual: {$ritualName}");
                }
            }

            // Return a successful response
            return response()->json([
                'status' => 200,
                'success' => 'Rituals saved successfully.'
            ], 200);
        } catch (\Exception $e) {
            // Log the exception message for debugging
            \Log::error('Error saving rituals: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'error' => 'An error occurred while saving the rituals: ' . $e->getMessage()
            ], 500);
        }
    }

    private function convert24ToCarbonInstance($time, $period)
    {
        // Validate the input time and period
        if (!preg_match('/^(0?[0-9]|1[0-2]):[0-5][0-9]$/', $time) && !preg_match('/^(0?[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $time) || !in_array($period, ['AM', 'PM'])) {
            throw new \InvalidArgumentException("Invalid time format or period.");
        }
    
        // If time is in 24-hour format, convert it to 12-hour format
        if (preg_match('/^(0?[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $time)) {
            // Convert to Carbon instance directly for 24-hour format
            return Carbon::createFromFormat('H:i', $time);
        } else {
            // Otherwise, convert to Carbon instance using AM/PM
            return Carbon::createFromFormat('H:i A', Carbon::createFromFormat('H:i', $time)->format('h:i') . ' ' . $period);
        }
    }
    

    public function apiManageDailyRitual()
    {
        try {
            $templeId = Auth::guard('api')->user()->temple_id;
    
            if (!$templeId) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid temple ID. Please authenticate again.',
                ], 400);
            }
    
            // Fetch active rituals for the temple
            $rituals = TempleRitual::where('status', 'active')
                ->where('temple_id', $templeId)
                ->get();
    
            // Group rituals by ritual_day_name
            $groupedRituals = $rituals->groupBy('ritual_day_name');
    
            // Prepare the response data
            $response = [
                'status' => 200,
                'message' => 'Rituals fetched successfully.',
                'weekDays' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'rituals' => $groupedRituals,
            ];
    
            return response()->json($response, 200);
    
        } catch (\Exception $e) {
            // Return a server error response
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while fetching the rituals. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

public function apiUpdateRituals(Request $request)
{
    \Log::info($request->all()); // Log all request data

    // Process each ritual update
    try {
        foreach ($request->ritual_id as $index => $ritualId) {

            $ritual = TempleRitual::find($ritualId);

            if (!$ritual) {
                return response()->json([
                    'status' => 400,
                    'error' => 'Ritual not found for ID: ' . $ritualId
                ], 400); // 404 Not Found
            }

            $ritual->ritual_name = $request->ritual_name[$index] ?? $ritual->ritual_name;
            $ritual->ritual_start_time = $request->ritual_start_time[$index] ?? $ritual->ritual_start_time;
            $ritual->ritual_end_time = $request->ritual_end_time[$index] ?? $ritual->ritual_end_time;
            $ritual->description = $request->description[$index] ?? $ritual->description;
            $ritual->ritual_start_period = $request->ritual_start_period[$index] ?? $ritual->ritual_start_period; 
            $ritual->ritual_end_period = $request->ritual_end_period[$index] ?? $ritual->ritual_end_period; 
            
            // Calculate ritual duration
            if (isset($request->ritual_start_time[$index]) && isset($request->ritual_end_time[$index])) {
                $startTime = $this->convert24ToCarbonInstance($request->ritual_start_time[$index], $request->ritual_start_period[$index]);
                $endTime = $this->convert24ToCarbonInstance($request->ritual_end_time[$index], $request->ritual_end_period[$index]);
                $durationInMinutes = $startTime->diffInMinutes($endTime);
                $hours = intdiv($durationInMinutes, 60);
                $minutes = $durationInMinutes % 60;
                $ritual->ritual_duration = sprintf('%02d:%02d', $hours, $minutes);
            }

            // Handling image update
            if ($request->hasFile('ritual_image.' . $index)) {
                $image = $request->file('ritual_image.' . $index);
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'assets/temple/ritual_images';
                $image->move(public_path($imagePath), $imageName);
                $ritual->ritual_image = $imagePath . '/' . $imageName;
            }

            // Handling video update
            if ($request->hasFile('ritual_video.' . $index)) {
                $video = $request->file('ritual_video.' . $index);
                $videoName = time() . '_' . $video->getClientOriginalName();
                $videoPath = 'assets/temple/ritual_videos';
                $video->move(public_path($videoPath), $videoName);
                $ritual->ritual_video = $videoPath . '/' . $videoName;
            }

            // Save the ritual updates
            $ritual->save();
        }

        return response()->json([
            'status' => 200,
            'success' => 'Rituals updated successfully!'
        ], 200); // 200 OK
    } catch (\Exception $e) {
        \Log::error('Update Rituals Error: ' . $e->getMessage()); // Log the error
        return response()->json([
            'status' => 500,
            'error' => 'Server error occurred.'
        ], 500); // 500 Internal Server Error
    }
}
public function apiDeleteRitual($id)
{
    try {
        // Find the ritual by ID or fail if not found
        $ritual = TempleRitual::findOrFail($id);

        if (!$ritual) {
            return response()->json([
                'status' => 400,
                'error' => 'Ritual not found for ID: ' . $ritualId
            ], 400); // 404 Not Found
        }
        // Update the status to 'deleted'
        $ritual->status = 'deleted'; // Update the status value to 'deleted' instead of removing the row
        $ritual->save();

        // Optionally delete files if needed
        if ($ritual->ritual_image) {
            Storage::delete($ritual->ritual_image);
        }
        if ($ritual->ritual_video) {
            Storage::delete($ritual->ritual_video);
        }

        // Return a success response
        return response()->json([
            'status' => 200,
            'success' => 'Ritual status updated to deleted.'
        ], 200); // 200 OK
    } catch (\Exception $e) {
        \Log::error('Delete Ritual Error: ' . $e->getMessage()); // Log the error
        return response()->json([
            'status' => 500,
            'error' => 'Server error occurred.'
        ], 500); // 500 Internal Server Error
    }
}

}
