<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NijogaMaster;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
 

class TempleNijogaController extends Controller
{
   
    public function addNijoga()
    {
        return view('templeuser.templefeature.add-nijoga');
    }
    public function saveNijoga(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'nijoga_name' => 'required|string|max:255',
                'nijoga_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
            ]);

            $photoPath = null;

            // Check if a file is uploaded
            if ($request->hasFile('nijoga_photo')) {
                $file = $request->file('nijoga_photo');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;

                // Move file to public directory
                $file->move(public_path('assets/uploads/nijoga_photo'), $filename);
                $photoPath = 'assets/uploads/nijoga_photo/' . $filename;
            }

            // Save data to the database
            NijogaMaster::create([
                'temple_id' => Auth::guard('temples')->user()->temple_id, // Ensure temple_id is set
                'nijoga_name' => $request->nijoga_name,
                'nijoga_photo' => $photoPath,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Nijoga saved successfully!');

        } catch (\Exception $e) {
            Log::error('Error saving Nijoga: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save Nijoga. Please try again.');
        }
    }

    public function manageNijoga(){

        $temple_id = Auth::guard('temples')->user()->temple_id;

        $nijogas = NijogaMaster::where('status', 'active')->where('temple_id', $temple_id)->get();

        return view('templeuser.templefeature.manage-nijoga', compact('nijogas'));

    }

       // Update Nijoga
       public function updateNijoga(Request $request, $id)
       {
           try {
               $nijoga = NijogaMaster::findOrFail($id);
   
               $request->validate([
                   'nijoga_name' => 'required|string|max:255',
                   'description' => 'required',
                   'nijoga_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
               ]);
   
               // Update fields
               $nijoga->nijoga_name = $request->nijoga_name;
               $nijoga->description = $request->description;
   
               // Handle photo upload
               if ($request->hasFile('nijoga_photo')) {
                   $file = $request->file('nijoga_photo');
                   $ext = $file->getClientOriginalExtension();
                   $filename = time() . '.' . $ext;
   
                   // Define new file path
                   $photoPath = 'assets/uploads/nijoga_photo/' . $filename;
   
                   // Move file to public directory
                   $file->move(public_path('assets/uploads/nijoga_photo'), $filename);
   
                   // Delete old photo if exists
                   if ($nijoga->nijoga_photo) {
                       $oldImagePath = public_path($nijoga->nijoga_photo);
                       if (file_exists($oldImagePath)) {
                           unlink($oldImagePath);
                       }
                   }
   
                   $nijoga->nijoga_photo = $photoPath;
               }
   
               $nijoga->save();
   
               return redirect()->route('manageNijoga')->with('success', 'Nijoga updated successfully.');
   
           } catch (Exception $e) {
               Log::error('Nijoga update failed: ' . $e->getMessage());
               return redirect()->back()->with('error', 'Something went wrong. Please try again.');
           }
       }
       
    public function deleteNijoga($id)
    {
        $nijoga = NijogaMaster::findOrFail($id);
        $nijoga->status = 'deleted';
        $nijoga->save();

        return redirect()->route('manageNijoga')->with('success', 'Nijoga status updated to deleted successfully!');
    }
}
