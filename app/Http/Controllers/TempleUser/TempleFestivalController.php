<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleFestival;
use Illuminate\Support\Facades\Auth;
use App\Models\SubFestival;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TempleFestivalController extends Controller
{
    //
    public function addFestival(){
        return view('templeuser.add-temple-festival');
    }
   
        public function storeData(Request $request)
        {
            try {
                // Validate request
                $request->validate([
                    'festival_name' => 'required|string|max:255',
                    'start_date' => 'required|date',
                    'festival_descp' => 'required|string',
                    'festival_photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048', // Ensure each photo is an image
                    'sub_festival_photo.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048', 
                ]);
    
                // Generate festival ID
                $festivalId = 'FEST' . rand(1000, 9999);
                $templeId = Auth::guard('temples')->user()->temple_id;
    
                // Save festival data
                $festival = new TempleFestival();
                $festival->temple_id = $templeId;
                $festival->festival_id = $festivalId;
                $festival->festival_name = $request->festival_name;
                $festival->start_date = $request->start_date;
                $festival->end_date = $request->end_date;
                $festival->live_url = $request->live_url;
                $festival->description = $request->festival_descp;
    
                $photoPaths = [];
                if ($request->hasFile('festival_photos')) {
                    foreach ($request->file('festival_photos') as $file) {
                        if ($file->isValid()) {
                            $ext = $file->getClientOriginalExtension();
                            $filename = time() . '_' . uniqid() . '.' . $ext;
                            $file->move(public_path('assets/uploads/festival_photos'), $filename);
                            $photoPaths[] = 'assets/uploads/festival_photos/' . $filename;
                        }
                    }
                }
                
                // Convert file paths array to JSON
                $festival->photo = json_encode($photoPaths);
                        
                $festival->save();

                // Save sub-festivals
                if ($request->sub_festival_name) {
                    foreach ($request->sub_festival_name as $index => $subFestivalName) {
                        if (!empty($subFestivalName)) {
                            $subFestival = new SubFestival();
                            $subFestival->temple_id = $templeId;
                            $subFestival->festival_id = $festivalId;
                            $subFestival->sub_festival_name = $subFestivalName;
                            $subFestival->sub_festival_date = $request->sub_festival_date[$index];
                            $subFestival->sub_festival_time = $request->sub_festival_time[$index];
    
                            if ($request->hasFile('sub_festival_photo')) {
                                foreach ($request->file('sub_festival_photo') as $index => $file) {
                                    if ($file->isValid()) {
                                        $ext = $file->getClientOriginalExtension();
                                        $filename = time() . '_' . uniqid() . '.' . $ext;
                                        $file->move(public_path('assets/uploads/sub_festival_photo'), $filename);
                                        $photoPath = 'assets/uploads/sub_festival_photo/' . $filename;
                                    }
                                }
                            }

                            $subFestival->sub_festival_photo = $photoPath;

                            $subFestival->save();
                        }
                    }
                }
    
                return redirect()->back()->with('success', 'Festival saved successfully!');
            } catch (\Exception $e) {
                Log::error('Error saving festival: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while saving the festival. Please try again. Error: ' . $e->getMessage());
            }
        }

        public function manageFestivals()
        {
            $templeId = Auth::guard('temples')->user()->temple_id;
        
            $festivals = TempleFestival::where('status', 'active')
                ->where('temple_id', $templeId)
                ->with('subFestivals') // Assuming you have a relationship
                ->get();
        
            return view('templeuser.manage-festivals', compact('festivals'));
        }
        
        public function editFestival($id)
        {
            $festival = TempleFestival::with('subFestivals')->findOrFail($id);
            return view('templeuser.edit-festival', compact('festival'));
        }
        
        public function updateFestival(Request $request, $id)
        {
            try {
                // Validate request
                $request->validate([
                    'festival_name' => 'required|string|max:255',
                    'start_date' => 'required|date',
                    'festival_descp' => 'required|string',
                    'festival_photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                    'sub_festival_photo.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                ]);
        
                $templeId = Auth::guard('temples')->user()->temple_id;
        
                // Fetch the existing festival
                $festival = TempleFestival::findOrFail($id);
        
                $festival->temple_id = $templeId;
                $festival->festival_name = $request->festival_name;
                $festival->start_date = $request->start_date;
                $festival->end_date = $request->end_date;
                $festival->live_url = $request->live_url;
                $festival->description = $request->festival_descp;
        
                // Handle new uploaded photos and append to existing if needed
                $existingPhotos = json_decode($festival->photo ?? '[]', true);
                $newPhotoPaths = [];
        
                if ($request->hasFile('festival_photos')) {
                    foreach ($request->file('festival_photos') as $file) {
                        if ($file->isValid()) {
                            $ext = $file->getClientOriginalExtension();
                            $filename = time() . '_' . uniqid() . '.' . $ext;
                            $file->move(public_path('assets/uploads/festival_photos'), $filename);
                            $newPhotoPaths[] = 'assets/uploads/festival_photos/' . $filename;
                        }
                    }
                }
        
                // Merge old and new if you want to retain existing photos
                $festival->photo = json_encode(array_merge($existingPhotos, $newPhotoPaths));
        
                $festival->save();
        
                // Clear existing sub festivals if you want to replace all
                SubFestival::where('festival_id', $festival->festival_id)->delete();
        
                // Save sub-festivals
                if ($request->sub_festival_name) {
                    foreach ($request->sub_festival_name as $index => $subFestivalName) {
                        if (!empty($subFestivalName)) {
                            $subFestival = new SubFestival();
                            $subFestival->temple_id = $templeId;
                            $subFestival->festival_id = $festival->festival_id;
                            $subFestival->sub_festival_name = $subFestivalName;
                            $subFestival->sub_festival_date = $request->sub_festival_date[$index];
                            $subFestival->sub_festival_time = $request->sub_festival_time[$index];
        
                            $photoPath = null;
                            if ($request->hasFile("sub_festival_photo.$index")) {
                                $file = $request->file("sub_festival_photo.$index");
                                if ($file->isValid()) {
                                    $ext = $file->getClientOriginalExtension();
                                    $filename = time() . '_' . uniqid() . '.' . $ext;
                                    $file->move(public_path('assets/uploads/sub_festival_photo'), $filename);
                                    $photoPath = 'assets/uploads/sub_festival_photo/' . $filename;
                                }
                            }
        
                            $subFestival->sub_festival_photo = $photoPath;
                            $subFestival->save();
                        }
                    }
                }
        
                return redirect()->route('templefestival.managefestivals')->with('success', 'Festival updated successfully!');
            } catch (\Exception $e) {
                Log::error('Error updating festival: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while updating the festival. Please try again. Error: ' . $e->getMessage());
            }
        }

     public function deleteFestival($id)
     {
         $festival = TempleFestival::findOrFail($id);
         $festival->status = 'deleted';
         $festival->save();
     
         return redirect()->back()->with('success', 'Festival deleted successfully.');
     }     

}
