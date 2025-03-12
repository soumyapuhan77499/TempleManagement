<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmergencyContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class TempleEmergencyController extends Controller
{
    public function addEmergency()
    {
        return view('templeuser.templefeature.add-emergency');
    }

    public function saveEmergency(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'emergency_type' => 'required|string',
                'contact_no' => 'required|string|max:15',
                'google_map_link' => 'nullable|url',
                'country' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'district' => 'nullable|string|max:255',
                'landmark' => 'nullable|string|max:255',
                'pincode' => 'nullable|string|max:10',
                'city_village' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Create new emergency contact entry
            EmergencyContact::create([
                'temple_id' => auth()->user()->temple_id ?? null, // Set temple_id if available
                'type' => $request->emergency_type,
                'contact_no' => $request->contact_no,
                'google_map_link' => $request->google_map_link,
                'country' => $request->country,
                'state' => $request->state,
                'district' => $request->district,
                'landmark' => $request->landmark,
                'pincode' => $request->pincode,
                'city_village' => $request->city_village,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Emergency contact saved successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to save emergency contact. Error: ' . $e->getMessage());
        }
    }

    public function manageEmergency(){

        $temple_id = Auth::guard('temples')->user()->temple_id;

        $emergencys = EmergencyContact::where('temple_id', $temple_id)->where('status','active')->get();

        return view('templeuser.templefeature.manage-emergency', compact('emergencys'));
    }

    public function deleteEmergency($id)
    {
        $emergency = EmergencyContact::findOrFail($id);
        $emergency->status = 'deleted';
        $emergency->save();

        return redirect()->route('manageEmergency')->with('success', 'Commute status updated to deleted successfully!');
    }

}
