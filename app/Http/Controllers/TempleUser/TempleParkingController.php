<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parking;

class TempleParkingController extends Controller
{
    public function parking(){
      
        return view('templeuser.rathayatra.add-parking');
    }
    public function manageParking(){

        $parkings = Parking::where('status', 'active')->get();

        return view('templeuser.rathayatra.manage-parking', compact('parkings'));

    }

    public function saveParking(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'parking' => 'required|string|max:255',
                'availability' => 'required|string|max:255',
                'map_url' => 'nullable|url',
                'parking_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'parking_address' => 'required|string',
                'vehicle_type' => 'required|string|in:two_wheeler,four_wheeler,both',
                'pass_type' => 'required|string|in:vip,vvip,normal,all', // Validate pass_type
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
            $parking->language = $request->language;
            $parking->parking_name = $request->parking;
            $parking->parking_availability = $request->availability;
            $parking->map_url = $request->map_url;
            $parking->parking_photo = $photoPath;
            $parking->parking_address = $request->parking_address;
            $parking->vehicle_type = $request->vehicle_type;
            $parking->pass_type = $request->pass_type; // Save the pass_type
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
        $request->validate([
            'parking_name' => 'required|string|max:255',
            'parking_photo' => 'nullable|image|max:2048',
        ]);

        $parking = Parking::findOrFail($id);
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
         $parking->language = $request->language;
         $parking->parking_name = $request->parking_name;
         $parking->parking_availability = $request->parking_availability;
         $parking->map_url = $request->map_url;
         $parking->vehicle_type = $request->vehicle_type;
         $parking->parking_address = $request->parking_address;
 
         $parking->save();

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
