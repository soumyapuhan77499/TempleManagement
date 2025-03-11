<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accomodation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TempleAccomodationController extends Controller
{
    public function addAccomodation()
    {
        return view('templeuser.templefeature.add-accomodation');
    }


    public function saveAccomodation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'google_map_link' => 'required|url',
                'accomodation_type' => 'required|string',
                'contact_no' => 'required|string|max:15',
                'whatsapp_no' => 'required|string|max:15',
                'email' => 'required|email',
                'check_in_time' => 'nullable|date_format:H:i',
                'check_out_time' => 'nullable|date_format:H:i',
                'description' => 'required|string',
                'food_type' => 'nullable|string',
                'opening_time' => 'nullable|date_format:H:i',
                'closing_time' => 'nullable|date_format:H:i',
                'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
    
            $photoPaths = [];
    
            // Handle multiple image uploads
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/accomodation_photos'), $filename);
                    $photoPaths[] = 'assets/uploads/accomodation_photos/' . $filename;
                }
            }

            $accomodation = new Accomodation();
            $accomodation->temple_id = auth()->user()->temple_id;
            $accomodation->name = $request->name;
            $accomodation->photo = json_encode($photoPaths);
            $accomodation->google_map_link = $request->google_map_link;
            $accomodation->accomodation_type = $request->accomodation_type;
            $accomodation->contact_no = $request->contact_no;
            $accomodation->whatsapp_no = $request->whatsapp_no;
            $accomodation->email = $request->email;
            $accomodation->check_in_time = $request->check_in_time;
            $accomodation->check_out_time = $request->check_out_time;
            $accomodation->address = $request->address;
            $accomodation->description = $request->description;
            $accomodation->food_type = $request->food_type;
            $accomodation->opening_time = $request->opening_time;
            $accomodation->closing_time = $request->closing_time;
            $accomodation->landmark = $request->landmark;
            $accomodation->pincode = $request->pincode;
            $accomodation->city_village = $request->city_village;
            $accomodation->district = $request->district;
            $accomodation->state = $request->state;
            $accomodation->country = $request->country;

            $accomodation->save();

            return redirect()->back()->with('success', 'Accommodation details saved successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    

    
    public function manageAccomodation(){

        $temple_id = Auth::guard('temples')->user()->temple_id;

        $accomodations = Accomodation::where('temple_id', $temple_id)->where('status','active')->get();

        return view('templeuser.templefeature.manage-accomodation', compact('accomodations'));
    }

    public function editAccomodation($id)
    {
        $accomodation = Accomodation::findOrFail($id);

        return view('templeuser.templefeature.update-accomodation', compact('accomodation'));
    }

    
    public function deleteAccomodation($id)
    {
        $accomodation = Accomodation::findOrFail($id);
        $accomodation->status = 'deleted';
        $accomodation->save();

        return redirect()->route('manageAccomodation')->with('success', 'Accomodation status updated to deleted successfully!');
    }

    public function updateAccomodation(Request $request, $id)
{
    try {
        // Validate request data
        $rules = [
            'name' => 'required|string|max:255',
            'google_map_link' => 'required|url',
            'accomodation_type' => 'required',
            'contact_no' => 'required|numeric',
            'whatsapp_no' => 'nullable|numeric',
            'email' => 'required|email',
            'check_in_time' => 'nullable',
            'check_out_time' => 'nullable',
            'description' => 'required|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate images
        ];

        // If restaurant is selected, validate opening/closing time and food type
        if ($request->accomodation_type === 'restaurant') {
            $rules['opening_time'] = 'required';
            $rules['closing_time'] = 'required';
            $rules['food_type'] = 'required|in:veg,non_veg,both';
        }

        $request->validate($rules);

        // Find the accommodation record
        $accomodation = Accomodation::findOrFail($id);

        // Update fields
        $accomodation->name = $request->name;
        $accomodation->google_map_link = $request->google_map_link;
        $accomodation->accomodation_type = $request->accomodation_type;
        $accomodation->contact_no = $request->contact_no;
        $accomodation->whatsapp_no = $request->whatsapp_no;
        $accomodation->email = $request->email;
        $accomodation->check_in_time = $request->check_in_time;
        $accomodation->check_out_time = $request->check_out_time;
        $accomodation->landmark = $request->landmark;
        $accomodation->pincode = $request->pincode;
        $accomodation->city_village = $request->city_village;
        $accomodation->district = $request->district;
        $accomodation->state = $request->state;
        $accomodation->country = $request->country;
        $accomodation->description = $request->description;

        // Handle Restaurant Fields
        if ($request->accomodation_type === 'restaurant') {
            $accomodation->opening_time = $request->opening_time;
            $accomodation->closing_time = $request->closing_time;
            $accomodation->food_type = $request->food_type;
        } else {
            // Reset these fields if not a restaurant
            $accomodation->opening_time = null;
            $accomodation->closing_time = null;
            $accomodation->food_type = null;
        }

        // Handle Photo Upload
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('uploads/accomodation_photos'), $filename);
                $photoPaths[] = 'uploads/accomodation_photos/' . $filename;
            }
            $accomodation->photo = json_encode($photoPaths);
        }

        // Save updated record
        $accomodation->save();

        return redirect()->route('manageAccomodation', $id)->with('success', 'Accommodation details updated successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong! ' . $e->getMessage());
    }
}

    
}
