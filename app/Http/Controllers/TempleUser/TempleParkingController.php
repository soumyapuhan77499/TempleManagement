<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parking;
use Illuminate\Support\Facades\Auth;

class TempleParkingController extends Controller
{
    public function parking(){
      
        return view('templeuser.rathayatra.add-parking');
    }
    public function manageParking(){

        $temple_id = Auth::guard('temples')->user()->temple_id;
        $parkings = Parking::where('status', 'active')->where('temple_id', $temple_id)->get();

        return view('templeuser.rathayatra.manage-parking', compact('parkings'));

    }

    public function saveParking(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'language' => 'required|string|max:255',
                'parking' => 'required|string|max:255',
                'availability' => 'required|string|max:255',
                'map_url' => 'nullable|url',
                'parking_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'parking_address' => 'required|string',
                'vehicle_type' => 'required|string|in:two_wheeler,four_wheeler,three_wheeler,heavy_vehicle,electric_vehicle,all',
                'pass_type' => 'required|string|in:vip,vvip,normal,all,sebayat', // Ensure 'sebayat' is included in validation
                'area_type' => 'required|string|in:cover,open', // Validate area_type
                'parking_management' => 'required|string|in:automated,manual', // Validate parking_management
            ]);
    
            // Handle the file upload
            $photoPath = null;
            if ($request->hasFile('parking_photo')) {
                // Store the file and get the path
                $photoPath = $request->file('parking_photo')->store('parking_photos', 'public');
        
                // Additional manual file move (if needed)
                $file = $request->file('parking_photo');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move(public_path('assets/uploads/parking_photo'), $filename);
        
                // Update photoPath with the manually moved file path
                $photoPath = 'assets/uploads/parking_photo/' . $filename;
            }

            // Create a new Parking record
            $parking = new Parking();
            $parking->temple_id = Auth::guard('temples')->user()->temple_id;
            $parking->language = $request->language;
            $parking->parking_name = $request->parking;
            $parking->parking_availability = $request->availability;
            $parking->map_url = $request->map_url;
            $parking->parking_photo = $photoPath;
            $parking->parking_address = $request->parking_address;
            $parking->vehicle_type = $request->vehicle_type;
            $parking->pass_type = $request->pass_type; // Save the pass_type (including sebayat)
            $parking->area_type = $request->area_type; // Save the area type (cover or open)
            $parking->parking_management = $request->parking_management; // Save the parking management type (automated or manual)
            $parking->save();
    
            // Redirect back with success message
            return redirect()->back()->with('success', 'Parking saved successfully!');
    
        } catch (\Exception $e) {
            // Handle the exception and log it
            \Log::error('Error saving parking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error saving the parking. Please try again.');
        }
    }
    
    

    public function editParking($id)
    {
        $parking = Parking::findOrFail($id);
        return view('templeuser.rathayatra.edit-parking', compact('parking'));
    }

    public function updateParking(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'language' => 'required|string|max:255',
            'parking_name' => 'required|string|max:255',
            'parking_availability' => 'required|string|max:255',
            'map_url' => 'nullable|url|max:255',
            'vehicle_type' => 'required|string|max:255',
            'area_type' => 'required|string|max:255',
            'parking_management' => 'required|string|max:255',
            'pass_type' => 'required|string|max:255',
            'parking_address' => 'required|string|max:500',
            'parking_photo' => 'nullable|image|max:2048',
        ]);
    
        // Find the parking record by ID
        $parking = Parking::findOrFail($id);
    
        // Handle the file upload for parking photo (if any)
        $photoPath = $parking->parking_photo; // default to the current photo if no new one is uploaded
        if ($request->hasFile('parking_photo')) {
            // Store the new file in the public directory
            $photoPath = $request->file('parking_photo')->store('parking_photos', 'public');
    
            // Optional: manually move the file to a custom location
            $file = $request->file('parking_photo');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move(public_path('assets/uploads/parking_photo'), $filename);
    
            // Update photoPath with the manually moved file path
            $photoPath = 'assets/uploads/parking_photo/' . $filename;
        }
    
        // Update the parking details with new data from the form
        $parking->update([
            'language' => $request->language,
            'parking_name' => $request->parking_name,
            'parking_availability' => $request->parking_availability,
            'map_url' => $request->map_url,
            'vehicle_type' => $request->vehicle_type,
            'area_type' => $request->area_type,
            'parking_management' => $request->parking_management,
            'pass_type' => $request->pass_type,
            'parking_address' => $request->parking_address,
            'parking_photo' => $photoPath,  // update photo if new one is uploaded
        ]);
    
        // Redirect back with a success message
        return redirect()->route('manageparking')->with('success', 'Parking updated successfully!');
    }
    

    public function deleteParking($id)
    {
        $parking = Parking::findOrFail($id);
        $parking->status = 'deleted';
        $parking->save();

        return redirect()->route('manageparking')->with('success', 'Parking status updated to deleted successfully!');
    }
}
