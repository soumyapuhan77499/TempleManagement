<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDarshan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class TempleDarshanController extends Controller
{

public function apiSaveTempleDarshan(Request $request)
{
    
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'status' => 400,
            'message' => 'Invalid temple ID. Please authenticate again.',
        ], 400);
    }
    try {
        // Loop through each darshan entry from the JSON request
        foreach ($request->input('darshans') as $darshanData) {

            $startTime = $this->convert24ToCarbonInstance($darshanData['darshan_start_time'], $darshanData['darshan_start_period']);
            $endTime = $this->convert24ToCarbonInstance($darshanData['darshan_end_time'], $darshanData['darshan_end_period']);

            // Calculate darshan duration
            $durationInMinutes = $startTime->diffInMinutes($endTime);
            $hours = intdiv($durationInMinutes, 60);
            $minutes = $durationInMinutes % 60;
            $darshanDuration = sprintf('%02d:%02d', $hours, $minutes);  // Format as HH:MM

            // Create a new Darshan record
            $darshan = new TempleDarshan();

            // Store darshan data
            $darshan->temple_id = $templeId;
            $darshan->darshan_day = $darshanData['day_name'];
            $darshan->darshan_name = $darshanData['darshan_name'];
            $darshan->darshan_start_time = $darshanData['darshan_start_time'];
            $darshan->darshan_start_period = $darshanData['darshan_start_period'];
            $darshan->darshan_end_time = $darshanData['darshan_end_time'];
            $darshan->darshan_end_period = $darshanData['darshan_end_period'];
            $darshan->darshan_duration = $darshanDuration;

            // Handle image upload if base64 encoded image is sent
            if (isset($darshanData['darshan_image'])) {
                $imageName = time() . '_darshan_image.png'; // You can customize the image name and extension
                $imagePath = 'assets/temple/darshan_images/' . $imageName;
                file_put_contents(public_path($imagePath), base64_decode($darshanData['darshan_image']));
                $darshan->darshan_image = $imagePath;
            }

            // Save description
            $darshan->description = $darshanData['description'] ?? null;

            // Save the darshan record
            $darshan->save();
        }

        // Return 200 success response
        return response()->json([
            'status' => 200,
            'success' => 'Darshans saved successfully.'
        ], 200);

    } catch (\Exception $e) {
        // Log the exception for debugging
        \Log::error('Error saving darshans: ' . $e->getMessage());

        // Return 500 server error
        return response()->json([
            'status' => 500,
            'error' => 'An error occurred while saving darshans.'
        ], 500);
    }
}
    
private function convert24ToCarbonInstance($time, $period)
{
    return Carbon::createFromFormat('H:i A', Carbon::createFromFormat('H:i', $time)->format('h:i') . ' ' . $period);
}

public function ManageTempleDarshan()
{
    try {
        $templeId = Auth::guard('api')->user()->temple_id;
        
        if (!$templeId) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid temple ID. Please authenticate again.',
            ], 400);
        }

        // Fetch active darshans for the temple
        $darshans = TempleDarshan::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get();

        // Group darshans by darshan_day
        $groupedDarshans = $darshans->groupBy('darshan_day');

        // Prepare the list of weekdays
        $weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Return a successful JSON response
        return response()->json([
            'status' => 200,
            'message' => 'Darshans fetched successfully.',
            'groupedDarshans' => $groupedDarshans,
            'weekDays' => $weekDays
        ], 200);
    } catch (\Exception $e) {
        // Return a server error message
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while fetching the darshans. Please try again later.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function updateTempleDarshan(Request $request)
{
   
    try {
        // Loop through each darshan entry
        foreach ($request->darshan_id as $key => $id) {
            // Convert start and end time to Carbon instances
            $startTime = $this->convert24ToCarbonInstance($request->darshan_start_time[$key], $request->darshan_start_period[$key]);
            $endTime = $this->convert24ToCarbonInstance($request->darshan_end_time[$key], $request->darshan_end_period[$key]);

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
                $darshan->darshan_start_period = $request->darshan_start_period[$key];
                $darshan->darshan_end_time = $request->darshan_end_time[$key];
                $darshan->darshan_end_period = $request->darshan_end_period[$key];
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

        return response()->json([
            'success' => 200, 
            'message' => 'Darshans updated successfully.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => 500,
             'message' => 'An error occurred while updating darshans: ' . $e->getMessage()
        ], 500);
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

            return response()->json([
                'success' => 200,
                 'message' => 'Darshan deleted successfully.'
            ], 200);
        } else {
            return response()->json([
                'success' => 200,
                 'message' => 'Darshan not found.'
                ], 200);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => 500,
             'message' => 'An error occurred while deleting the darshan: ' . $e->getMessage()
            ], 500);
    }
}
}
