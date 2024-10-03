<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpecialRitual;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TempleYearlyRitualController extends Controller
{
    public function yearlyritual(){
      return view('templeuser/add-yearly-special-ritual');
    }

    public function manageYearlyRitual(){

        $special_rituals = SpecialRitual::where('status', 'active')->get();

        // Pass data to the view
        return view('templeuser/manage-yearly-ritual', compact('special_rituals'));

    }

    public function editYearlyRitual($id)
{
    // Fetch the special ritual by ID
    $specialRitual = SpecialRitual::findOrFail($id);  // Assuming your model is named SpecialRitual

    // Redirect to the edit view with the fetched ritual data
    return view('templeuser.edit-yearly-ritual', compact('specialRitual'));
}
    public function saveSpecialRitual(Request $request)
    {
        $validated = $request->validate([
            'spcl_ritual_name' => 'required|string|max:255',
            'spcl_ritual_date' => 'required|date',
            'spcl_ritual_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
            'spcl_ritual_video' => 'nullable|mimes:mp4,mov,avi|max:100000',
            'description' => 'nullable|string',
        ]);

        try {
            $templeId = Auth::guard('temples')->user()->temple_id;

            $ritual = new SpecialRitual();
            $ritual->temple_id = $templeId; // Assuming temple_id is linked to the authenticated user
            $ritual->spcl_ritual_name = $request->spcl_ritual_name;
            $ritual->spcl_ritual_date = $request->spcl_ritual_date;
            $ritual->spcl_ritual_time = $request->spcl_ritual_time;
            $ritual->spcl_ritual_period = $request->spcl_ritual_period;
            $ritual->spcl_ritual_tithi = $request->spcl_ritual_tithi;

            // Handle image upload
            if ($request->hasFile('spcl_ritual_image')) {
                $image = $request->file('spcl_ritual_image');
                $imageName = time() . '_' . $image->getClientOriginalName();            

                $image->move(public_path('assets/temple/special_ritual_images'), $imageName);
                $ritual->spcl_ritual_image = 'assets/temple/special_ritual_images/' . $imageName;
            }

            // Handle video upload
            if ($request->hasFile('spcl_ritual_video')) {
                $video = $request->file('spcl_ritual_video');
                $videoName = time() . '_' . $video->getClientOriginalName();
                $video->move(public_path('assets/temple/special_ritual_videos'), $videoName);
                $ritual->spcl_ritual_video = 'assets/temple/special_ritual_videos/' . $videoName;
            }

            $ritual->description = $request->description;
            $ritual->save();

            return redirect()->back()->with('success', 'Special Ritual saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving special ritual: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving the special ritual. Please try again.');
        }
    }

    public function deletYearlyRitual($id)
{
    try {
        // Find the special ritual by ID
        $ritual = SpecialRitual::findOrFail($id);

        // Instead of deleting, update the status to indicate it's "deleted"
        $ritual->status = 'deleted'; // Assuming 'inactive' or some other value indicates it's deleted
        $ritual->save();

        return redirect()->back()->with('success', 'Special Ritual marked as deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while deleting the special ritual. Please try again.');
    }
}

public function updateYearlyRitual(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'spcl_ritual_name' => 'required|string|max:255',
        'spcl_ritual_date' => 'required|date',
        'description' => 'nullable|string',
       
    ]);

    // Find the special ritual by its ID
    $specialRitual = SpecialRitual::findOrFail($id);

    // Update ritual details
    $specialRitual->spcl_ritual_name = $request->spcl_ritual_name;
    $specialRitual->spcl_ritual_date = $request->spcl_ritual_date;
    $specialRitual->spcl_ritual_tithi = $request->spcl_ritual_tithi;
    $specialRitual->spcl_ritual_time = $request->spcl_ritual_time;
    $specialRitual->spcl_ritual_period = $request->spcl_ritual_period;
    $specialRitual->description = $request->description;

    // Handle image upload
    if ($request->hasFile('spcl_ritual_image')) {
        $image = $request->file('spcl_ritual_image');
        $imagePath = 'assets/temple/special_ritual_images' . time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('assets/temple/special_ritual_images'), $imagePath);
        $specialRitual->spcl_ritual_image = $imagePath;
    }

    // Handle video upload
    if ($request->hasFile('spcl_ritual_video')) {
        $video = $request->file('spcl_ritual_video');
        $videoPath = 'assets/temple/special_ritual_videos' . time() . '_' . $video->getClientOriginalName();
        $video->move(public_path('assets/temple/special_ritual_videos'), $videoPath);
        $specialRitual->spcl_ritual_video = $videoPath;
    }

    // Save the updated ritual
    $specialRitual->save();

    // Redirect with success message
    return redirect()->route('templeuser.manage-yearlyritual')->with('success', 'Yearly Special Ritual updated successfully!');
}

}
