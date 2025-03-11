<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matha;
use Illuminate\Support\Facades\Auth;

class TempleMathaController extends Controller
{
    public function addMatha()
    {
        return view('templeuser.templefeature.add-matha');
    }

    public function saveMatha(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'matha_name' => 'required|string|max:255',
                'established_date' => 'required|date',
                'established_by' => 'required|string|max:255',
                'endowment' => 'required|string|in:yes,no',
                'availability' => 'required|string|in:lodging,fooding,both',
                'google_map_link' => 'required|url|max:255',
                'contact_no' => 'required|string|max:15',
                'whatsapp_no' => 'required|string|max:15',
                'email_id' => 'required|email|max:255',
                'description' => 'required|string|max:1000',
            ]);
    
            $photoPaths = [];
    
            // Check if photos are uploaded
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $file) {
                    $ext = $file->getClientOriginalExtension();
                    $filename = time() . '_' . uniqid() . '.' . $ext;
                    $file->move(public_path('assets/uploads/matha_photo'), $filename);
                    $photoPaths[] = 'assets/uploads/matha_photo/' . $filename;
                }
            }
    
            // Convert file paths array to JSON for storage
            $photoPathsJson = json_encode($photoPaths);
    
            // Save Matha details to the database
            Matha::create([
                'temple_id' => Auth::guard('temples')->user()->temple_id,
                'matha_name' => $request->matha_name,
                'photo' => $photoPathsJson, // Save as JSON
                'established_date' => $request->established_date,
                'established_by' => $request->established_by,
                'endowment' => $request->endowment,
                'availability' => $request->availability,
                'google_map_link' => $request->google_map_link,
                'contact_no' => $request->contact_no,
                'whatsapp_no' => $request->whatsapp_no,
                'email_id' => $request->email_id,
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
                'city_village' => $request->city_village,
                'district' => $request->district,
                'state' => $request->state,
                'country' => $request->country,
                'description' => $request->description,
            ]);
    
            return redirect()->back()->with('success', 'Matha details saved successfully!');
        } catch (Exception $e) {
            return redirect()->route('addMatha')->with('error', 'An error occurred while saving Matha details. Please try again.');
        }
    }
    
    public function manageMatha(){

        $temple_id = Auth::guard('temples')->user()->temple_id;

        $mathas = Matha::where('status', 'active')->where('temple_id', $temple_id)->get();

        return view('templeuser.templefeature.manage-matha', compact('mathas'));

    }

    public function editMatha($id)
    {
        $matha = Matha::findOrFail($id);
        return view('templeuser.templefeature.update-matha', compact('matha'));
    }

    public function updateMatha(Request $request, $id)
    {
        try {
            // Validate input data
            $request->validate([
                'matha_name' => 'required|string|max:255',
                'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each uploaded image
                'established_date' => 'nullable|date',
                'established_by' => 'nullable|string|max:255',
                'endowment' => 'required|in:yes,no',
                'availability' => 'required|in:lodging,fooding,both',
                'google_map_link' => 'required|url',
                'contact_no' => 'required|string|max:15',
                'whatsapp_no' => 'nullable|string|max:15',
                'email_id' => 'nullable|email|max:255',
                'relation_with_temple' => 'nullable|string|max:255',
                'description' => 'required|string',
            ]);
    
            // Find the existing matha record
            $matha = Matha::findOrFail($id);
    
            // Handle multiple image upload
            $photoPaths = json_decode($matha->photo) ?? []; // Retain old images
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $imagePath = 'uploads/matha_photo/' . time() . '_' . $photo->getClientOriginalName();
                    $photo->move(public_path('uploads/matha_photo'), $imagePath);
                    $photoPaths[] = $imagePath; // Store new image path
                }
            }
    
            // Update matha details
            $matha->update([
                'matha_name' => $request->matha_name,
                'photo' => json_encode($photoPaths), // Store images as JSON
                'established_date' => $request->established_date,
                'established_by' => $request->established_by,
                'endowment' => $request->endowment,
                'availability' => $request->availability,
                'google_map_link' => $request->google_map_link,
                'contact_no' => $request->contact_no,
                'whatsapp_no' => $request->whatsapp_no,
                'email_id' => $request->email_id,
                'relation_with_temple' => $request->relation_with_temple,
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
                'city_village' => $request->city_village,
                'district' => $request->district,
                'state' => $request->state,
                'country' => $request->country,
                                'description' => $request->description,
            ]);
            
            return redirect()->route('manageMatha')->with('success', 'Matha details updated successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Matha record not found.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function deletMatha($id)
{
    try {
        $matha = Matha::findOrFail($id);
        
        $matha->update(['status' => 'deleted']);

        return redirect()->back()->with('success', 'Matha status updated to deleted!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong! ' . $e->getMessage());
    }
}

    
}
