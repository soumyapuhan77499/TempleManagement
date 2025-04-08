<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NearByTemple;
use App\Models\CountryList;
use App\Models\StateList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
   
class TempleNearByTempleController extends Controller
{
    public function addNearByTemple()
    {
        return view('templeuser.templefeature.add-near-by-temple');
    }

    public function saveNearByTemple(Request $request)
{
    try {
        // Step 1: Validate Request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'google_map_link' => 'nullable|url',
            'estd_date' => 'nullable|date',
            'estd_by' => 'nullable|string|max:255',
            'committee_name' => 'nullable|string|max:255',
            'contact_no' => 'required|digits_between:10,15',
            'whatsapp_no' => 'nullable|digits_between:10,15',
            'email' => 'nullable|email|max:255',
            'priest_name' => 'nullable|string|max:255',
            'priest_contact_no' => 'nullable|digits_between:10,15',
            'description' => 'nullable|string',
            'landmark' => 'nullable|string|max:255',
            'pincode' => 'nullable|digits:6',
            'city_village' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Step 2: Handle Cover Photo Upload
        $coverPhotoPath = null;
        if ($request->hasFile('cover_photo')) {
            $coverPhoto = $request->file('cover_photo');
            $coverFilename = time() . '_cover_' . uniqid() . '.' . $coverPhoto->getClientOriginalExtension();
            $coverPhoto->move(public_path('assets/uploads/temple_photo'), $coverFilename);
            $coverPhotoPath = url('assets/uploads/temple_photo/' . $coverFilename); // Full URL
        }

        // Step 3: Handle Multiple Photo Uploads
        $photoPaths = [];
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/uploads/temple_photo'), $filename);
                $photoPaths[] = url('assets/uploads/temple_photo/' . $filename); // Full URL
            }
        }

        // Step 4: Save to DB
        NearByTemple::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id,
            'place_type' => $request->place_type,
            'temple_name' => $request->name,
            'photo' => json_encode($photoPaths),
            'cover_photo' => $coverPhotoPath,
            'google_map_link' => $request->google_map_link,
            'type' => $request->area_type,
            'estd_date' => $request->estd_date,
            'estd_by' => $request->estd_by,
            'committee_name' => $request->committee_name,
            'contact_no' => $request->contact_no,
            'whatsapp_no' => $request->whatsapp_no,
            'email' => $request->email,
            'priest_name' => $request->priest_name,
            'priest_contact_no' => $request->priest_contact_no,
            'description' => $request->description,
            'landmark' => $request->landmark,
            'pincode' => $request->pincode,
            'city_village' => $request->city_village,
            'district' => $request->district,
            'state' => $request->state,
            'country' => $request->country,
        ]);

        return redirect()->back()->with('success', 'Nearby temple added successfully.');
    } catch (\Exception $e) {
        Log::error('Error saving nearby temple: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong! Please try again.');
    }
}


    public function manageNearByTemple(){

        $temple_id = Auth::guard('temples')->user()->temple_id;

        $nearbytemples = NearByTemple::where('status', 'active')->where('temple_id', $temple_id)->get();

        return view('templeuser.templefeature.manage-near-by-temple', compact('nearbytemples'));

    }
    
    public function editNearByTemple($id)
{
    $temple = NearByTemple::with(['countryData', 'stateData'])->findOrFail($id);
    $countries = CountryList::all();
    $states = StateList::where('country_id', $temple->country)->get();

    return view('templeuser.templefeature.update-near-by-temple', compact('temple', 'countries', 'states'));
}


public function deletNearByTemple($id)
{
    try {
        $temple = NearByTemple::findOrFail($id);
        
        $temple->update(['status' => 'deleted']);

        return redirect()->back()->with('success', 'Temple status updated to deleted!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong! ' . $e->getMessage());
    }
}
public function updateNearByTemple(Request $request, $id)
{
    try {
        // Find temple or throw an exception
        $temple = NearByTemple::findOrFail($id);

        // Validate request data
        $request->validate([
            'temple_name' => 'required|string|max:255',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'google_map_link' => 'nullable|url',
            'estd_date' => 'nullable|date',
            'contact_no' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'area_type' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'district' => 'required|string',
            'pincode' => 'nullable|string|max:10',
            'city_village' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Handle file uploads
        $photoPaths = [];
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/uploads/temple_photo'), $filename);
                $photoPaths[] = 'assets/uploads/temple_photo/' . $filename;
            }
        }

        // Update temple data
        $temple->update([
            'temple_name' => $request->temple_name,
            'google_map_link' => $request->google_map_link,
            'estd_date' => $request->estd_date,
            'estd_by' => $request->estd_by,
            'photo' => json_encode($photoPaths), // Store images as JSON
            'committee_name' => $request->committee_name,
            'contact_no' => $request->contact_no,
            'whatsapp_no' => $request->whatsapp_no,
            'email' => $request->email,
            'priest_name' => $request->priest_name,
            'priest_contact_no' => $request->priest_contact_no,
            'type' => $request->area_type,
            'country' => $request->country,
            'state' => $request->state,
            'district' => $request->district,
            'landmark' => $request->landmark,
            'pincode' => $request->pincode,
            'city_village' => $request->city_village,
            'description' => $request->description,
        ]);

        return redirect()->route('manageNearByTemple')->with('success', 'Temple details updated successfully!');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->back()->with('error', 'Temple not found!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}


}
