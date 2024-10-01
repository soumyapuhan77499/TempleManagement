<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDarshan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class TempleDarshanController extends Controller
{
    public function apiSaveTempleDarshan(Request $request)
    {
        $templeId = Auth::guard('api')->user()->temple_id;
    
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
            return response()->json(['success' => 'Darshans saved successfully.'], 200);
    
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Error saving darshans: ' . $e->getMessage());
    
            // Return 500 server error
            return response()->json(['error' => 'An error occurred while saving darshans.'], 500);
        }
    }
    

private function convert24ToCarbonInstance($time, $period)
{
    return Carbon::createFromFormat('H:i A', Carbon::createFromFormat('H:i', $time)->format('h:i') . ' ' . $period);
}

}
