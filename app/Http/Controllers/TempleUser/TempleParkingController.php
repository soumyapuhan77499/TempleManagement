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
                'parking' => 'required|string|max:255',
                'availability' => 'required|string|max:255',
                'map_url' => 'nullable|url',
                'parking_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'vehicle_type' => 'array',
                'vehicle_type.*' => 'string|in:two wheeler,four wheeler,three wheeler,heavy vehicle,electric vehicle',
                'pass_type' => 'array',
                'pass_type.*' => 'string|in:vip,vvip,normal,sebayat',
                'area_type' => 'array',
                'area_type.*' => 'string|in:cover,open',
                'parking_management' => 'array',
                'parking_management.*' => 'string|in:automated,manual',
                'landmark' => 'nullable|string|max:255',
                'pincode' => 'nullable|string|max:10',
                'city_village' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
            ]);
    
            // Ensure user is authenticated
            $user = Auth::guard('temples')->user();
            if (!$user) {
                return redirect()->back()->with('error', 'You must be logged in to save parking details.');
            }
    
            // Handle the file upload
            $photoPath = null;
            if ($request->hasFile('parking_photo')) {
                $file = $request->file('parking_photo');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move(public_path('assets/uploads/parking_photo'), $filename);
                $photoPath = 'assets/uploads/parking_photo/' . $filename;
            }
    
            Parking::create([
                'temple_id' => $user->temple_id,
                'language' => $request->language,
                'parking_name' => $request->parking,
                'parking_availability' => $request->availability,
                'map_url' => $request->map_url,
                'parking_photo' => $photoPath,
                'vehicle_type' => json_encode($request->vehicle_type ?? []),
                'pass_type' => json_encode($request->pass_type ?? []),
                'area_type' => json_encode($request->area_type ?? []),
                'parking_management' => json_encode($request->parking_management ?? []),
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
                'city_village' => $request->city_village,
                'district' => $request->district,
                'state' => $request->state,
                'country' => $request->country,
            ]);
    
            // Redirect back with success message
            return redirect()->back()->with('success', 'Parking saved successfully!');
    
        } catch (\Exception $e) {
            \Log::error('Error saving parking', ['error' => $e]);
            return redirect()->back()->with('error', $e->getMessage());
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
            'language' => 'required|string',
            'parking_name' => 'required|string|max:255',
            'parking_availability' => 'nullable|string|max:255',
            'map_url' => 'nullable|url',
            'parking_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pass_type' => 'nullable|array',
            'vehicle_type' => 'nullable|array',
            'area_type' => 'nullable|array',
            'parking_management' => 'nullable|array',
            'landmark' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'city_village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $parking = Parking::findOrFail($id);

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

        $parking->language = $request->language;
        $parking->parking_name = $request->parking_name;
        $parking->parking_availability = $request->parking_availability;
        $parking->map_url = $request->map_url;
        $parking->pass_type = json_encode($request->pass_type);
        $parking->vehicle_type = json_encode($request->vehicle_type);
        $parking->area_type = json_encode($request->area_type);
        $parking->parking_management = json_encode($request->parking_management);
        $parking->landmark = $request->landmark;
        $parking->pincode = $request->pincode;
        $parking->city_village = $request->city_village;
        $parking->district = $request->district;
        $parking->state = $request->state;
        $parking->country = $request->country;
        $parking->parking_photo = $photoPath;

        $parking->save();

        return redirect()->route('manageparking')->with('success', 'Parking details updated successfully!');
    }

    public function deleteParking($id)
    {
        $parking = Parking::findOrFail($id);
        $parking->status = 'deleted';
        $parking->save();

        return redirect()->route('manageparking')->with('success', 'Parking status updated to deleted successfully!');
    }
}
