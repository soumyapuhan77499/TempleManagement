<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PublicServices;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TemplePublicServiceController extends Controller
{
    public function addService(){

        return view('templeuser.templefeature.add-public-service');

    }

    public function saveService(Request $request)
    {
        try {
            // Validate input fields
            $request->validate([
                'service_type' => 'required|string',
                'photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'google_map_link' => 'required|url',
                'contact_no' => 'required|string',
                'whatsapp_no' => 'required|string',
                'opening_time' => 'nullable',
                'closing_time' => 'nullable',
                'landmark' => 'nullable|string',
                'pincode' => 'nullable|string',
                'city_village' => 'nullable|string',
                'district' => 'nullable|string',
                'state' => 'nullable|string',
                'country' => 'nullable|string',
                'description' => 'required|string',
            ]);

            // Handle multiple file uploads
            $photoPaths = [];
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $fileName = time() . '_' . $photo->getClientOriginalName();
                    $photo->move(public_path('uploads/public_services'), $fileName);
                    $photoPaths[] = 'uploads/public_services/' . $fileName;
                }
            }

            // Save data in database
            PublicServices::create([
                'temple_id' => Auth::guard('temples')->user()->temple_id, // Ensure temple_id is set
                'service_type' => $request->service_type,
                'photo' => json_encode($photoPaths), // Store as JSON
                'google_map_link' => $request->google_map_link,
                'contact_no' => $request->contact_no,
                'whatsapp_no' => $request->whatsapp_no,
                'email' => $request->email,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
                'city_village' => $request->city_village,
                'district' => $request->district,
                'state' => $request->state,
                'country' => $request->country,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Service saved successfully.');

        } catch (\Exception $e) {
            Log::error('Service Save Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    
    public function manageService(){

        $temple_id = Auth::guard('temples')->user()->temple_id;

        $services = PublicServices::where('temple_id', $temple_id)->where('status','active')->get();

        return view('templeuser.templefeature.manage-public-service', compact('services'));
    }

    public function deleteService($id)
    {
        $services = PublicServices::findOrFail($id);
        $services->status = 'deleted';
        $services->save();

        return redirect()->route('manageService')->with('success', 'Service status deleted successfully!');
    }

    public function updateService(Request $request, $id)
    {
        $service = PublicServices::findOrFail($id);
    
        $request->validate([
            'service_type' => 'required|string',
            'google_map_link' => 'nullable|url',
            'contact_no' => 'required|string',
            'whatsapp_no' => 'nullable|string',
            'email' => 'nullable|string',
            'opening_time' => 'nullable',
            'closing_time' => 'nullable',
            'landmark' => 'nullable|string',
            'pincode' => 'nullable|string',
            'city_village' => 'nullable|string',
            'district' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'description' => 'required|string',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Get existing data except photo
        $data = $request->except('photo');
    
        // Handle multiple file uploads
        if ($request->hasFile('photo')) {
            $photoPaths = [];
            
            foreach ($request->file('photo') as $photo) {
                $fileName = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('uploads/public_services'), $fileName);
                $photoPaths[] = 'uploads/public_services/' . $fileName;
            }
    
            // Convert array to JSON for database storage
            $data['photo'] = json_encode($photoPaths);
        }
    
        // Update service details
        $service->update($data);
    
        return redirect()->back()->with('success', 'Service updated successfully');
    }
    

}
