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
            $validator = Validator::make($request->all(), [
                'place_type' => 'required|string',
                'area_type' => 'nullable|string',
                'name' => 'required|string|max:255',
                'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
                'map_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
                'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:9096',
                'google_map_link' => 'nullable|url',
                'estd_date' => 'nullable|date',
                'estd_by' => 'nullable|string|max:255',
                'committee_name' => 'nullable|string|max:255',
                'contact_no' => 'nullable|digits_between:10,15',
                'whatsapp_no' => 'nullable|digits_between:10,15',
                'email' => 'nullable|email|max:255',
                'priest_name' => 'nullable|string|max:255',
                'priest_contact_no' => 'nullable|digits_between:10,15',
                'description' => 'nullable|string',
                'history' => 'nullable|string',
                'distance_from_temple' => 'nullable|string|max:255',
                'landmark' => 'nullable|string|max:255',
                'pincode' => 'nullable|digits:6',
                'city_village' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $uploadPath = public_path('assets/uploads/temple_photo');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
    
            $uploadImage = function ($file, $prefix = 'img') use ($uploadPath) {
                $filename = microtime(true) . "_{$prefix}_" . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                return url('assets/uploads/temple_photo/' . $filename);
            };
    
            $coverPhotoPath = $request->hasFile('cover_photo')
                ? $uploadImage($request->file('cover_photo'), 'cover')
                : null;
    
            $mapPhotoPath = $request->hasFile('map_photo')
                ? $uploadImage($request->file('map_photo'), 'map')
                : null;
    
            $photoPaths = [];
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $file) {
                    $photoPaths[] = $uploadImage($file, 'photo');
                }
            }
    
            NearByTemple::create([
                'temple_id' => Auth::guard('temples')->user()->temple_id,
                'place_type' => $request->place_type,
                'type' => $request->area_type,
                'name' => $request->name,
                'cover_photo' => $coverPhotoPath,
                'map_photo' => $mapPhotoPath,
                'photo' => json_encode($photoPaths, JSON_UNESCAPED_SLASHES),
                'google_map_link' => $request->google_map_link,
                'estd_date' => $request->estd_date,
                'estd_by' => $request->estd_by,
                'committee_name' => $request->committee_name,
                'contact_no' => $request->contact_no,
                'whatsapp_no' => $request->whatsapp_no,
                'email' => $request->email,
                'priest_name' => $request->priest_name,
                'priest_contact_no' => $request->priest_contact_no,
                'description' => $request->description,
                'history' => $request->history,
                'distance_from_temple' => $request->distance_from_temple,
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
                'city_village' => $request->city_village,
                'district' => $request->district,
                'state' => $request->state,
                'country' => $request->country,
            ]);
    
            return redirect()->back()->with('success', 'Nearby temple added successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving nearby temple: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
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
            'name' => $request->name,
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
