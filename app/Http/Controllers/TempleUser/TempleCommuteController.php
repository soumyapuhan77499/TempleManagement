<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommuteMode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TempleCommuteController extends Controller
{
    public function addCommute()
    {
        return view('templeuser.templefeature.add-commute');
    }

    public function saveCommute(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'commute_type'      => 'required|string',
            'name'              => 'required|string|max:255',
            'photo.*'           => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'google_map_link'   => 'nullable|url',
            'distance'          => 'nullable|string|max:100',
            'landmark'          => 'nullable|string|max:255',
            'pincode'           => 'nullable|numeric|digits:6',
            'city_village'      => 'nullable|string|max:255',
            'district'          => 'nullable|string|max:255',
            'state'             => 'nullable|string|max:255',
            'country'           => 'nullable|string|max:255',
            'description'       => 'nullable|string',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       
        $photoPaths = [];
    
        // Handle multiple image uploads
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/uploads/commute_photos'), $filename);
                $photoPaths[] = 'assets/uploads/commute_photos/' . $filename;
            }
        }

        try {
            // Save data in the database
            CommuteMode::create([
                'temple_id'          => auth()->user()->temple_id ?? null, // Adjust as needed
                'commute_type'       => $request->commute_type,
                'name'               => $request->name,
                'photo'              => json_encode($photoPaths),
                'google_map_link'    => $request->google_map_link,
                'distance_from_temple' => $request->distance,
                'landmark'           => $request->landmark,
                'pincode'            => $request->pincode,
                'city_village'       => $request->city_village,
                'district'           => $request->district,
                'state'              => $request->state,
                'country'            => $request->country,
                'description'        => $request->description,
            ]);

            return redirect()->back()->with('success', 'Commute information saved successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save commute details. ' . $e->getMessage());
        }
    }

    
    
    public function manageCommute(){

        $temple_id = Auth::guard('temples')->user()->temple_id;

        $commutes = CommuteMode::where('temple_id', $temple_id)->where('status','active')->get();

        return view('templeuser.templefeature.manage-commute', compact('commutes'));
    }


    
    public function deleteCommute($id)
    {
        $commute = CommuteMode::findOrFail($id);
        $commute->status = 'deleted';
        $commute->save();

        return redirect()->route('manageCommute')->with('success', 'Commute status updated to deleted successfully!');
    }

    public function updateCommute(Request $request, $id)
{
    $commute = CommuteMode::findOrFail($id);

    // Validate the request
    $request->validate([
        'commute_type' => 'required|string',
        'name' => 'required|string|max:255',
        'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'google_map_link' => 'nullable|url',
        'distance' => 'nullable|string',
        'city_village' => 'nullable|string|max:255',
        'landmark' => 'nullable|string|max:255',
        'pincode' => 'nullable|string|max:10',
        'description' => 'nullable|string',
    ]);

    // Update commute details
    $commute->commute_type = $request->commute_type;
    $commute->name = $request->name;
    $commute->google_map_link = $request->google_map_link;
    $commute->distance_from_temple = $request->distance;
    $commute->city_village = $request->city_village;
    $commute->landmark = $request->landmark;
    $commute->pincode = $request->pincode;
    $commute->description = $request->description;

    // Handle photo uploads
    if ($request->hasFile('photo')) {
        $photos = [];
        foreach ($request->file('photo') as $photo) {
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/commute_photos'), $filename);
            $photos[] = 'uploads/commute_photos/' . $filename;
        }
        $commute->photo = json_encode($photos); // Store as JSON
    }

    $commute->save();

    return redirect()->back()->with('success', 'Commute details updated successfully!');
}

}
