<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsideTemple;
use Illuminate\Support\Facades\Auth;

class InsideTempleController extends Controller
{
    public function addInsideTemple(){
        return view('templeuser/add-inside-temple');
    }

    public function manageInsideTemple()
    {
        $temple_id = Auth::guard('temples')->user()->temple_id;
    
        // Get all records related to this temple
        $insideTemple = InsideTemple::where('temple_id', $temple_id)->where('status', 'active')->get();
    
        return view('templeuser.manage-inside-temple', compact('insideTemple'));
    }
    
    public function saveInsideTemple(Request $request)
    {
        // Validate the request data
        $request->validate([
            'inside_temple_name' => 'required|string|max:255',
            'inside_temple_about' => 'nullable|string',
            'inside_temple_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for the image
        ]);

        // Initialize the image path
        $insideTempleImage = null;

        // Check if an image was uploaded and handle it
        if ($request->hasFile('inside_temple_image')) {
            $image = $request->file('inside_temple_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'assets/temple/inside_temple_image';

            // Ensure the directory exists
            if (!file_exists(public_path($imagePath))) {
                mkdir(public_path($imagePath), 0777, true); // Create the directory if it doesn't exist
            }

            // Move the uploaded image to the folder
            $image->move(public_path($imagePath), $imageName);

            // Set the image path to be saved in the database
            $insideTempleImage = $imagePath . '/' . $imageName;
        }

        // Save the form data into the database
        InsideTemple::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id,
            'inside_temple_name' => $request->inside_temple_name,
            'inside_temple_image' => $insideTempleImage,
            'description' => $request->inside_temple_about,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Inside Temple added successfully.');
    }

public function editInsideTemple($id)
{
    $temple = InsideTemple::findOrFail($id);
    
    return view('templeuser.edit-inside-temple', compact('temple'));
}

public function updateInsideTemple(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'inside_temple_name' => 'required|string|max:255',
        'inside_temple_about' => 'nullable|string',
        'inside_temple_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for the image
    ]);

    $temple = InsideTemple::findOrFail($id);

    // Handle image upload if a new image is provided
    if ($request->hasFile('inside_temple_image')) {
        $image = $request->file('inside_temple_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'assets/temple/inside_temple_image';
        $image->move(public_path($imagePath), $imageName);
        $temple->inside_temple_image = $imagePath . '/' . $imageName;
    }

    // Update other fields
    $temple->inside_temple_name = $request->inside_temple_name;
    $temple->description = $request->inside_temple_about;
    
    $temple->save();

    // Redirect back with a success message
    return redirect()->route('templeuser.manageinsidetemple')->with('success', 'Inside Temple updated successfully.');
}

public function deleteInsideTemple($id)
{
    // Find the inside temple record by ID
    $temple = InsideTemple::findOrFail($id);

    // Update the status to 'deleted'
    $temple->status = 'deleted'; // Assuming the status column exists and stores statuses like 'active', 'deleted', etc.
    
    // Save the record
    $temple->save();

    // Redirect back with a success message
    return redirect()->route('templeuser.manageinsidetemple')->with('success', 'Inside Temple has been marked as deleted.');
}




}
