<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDressColor;
use App\Models\TempleBesha;
use App\Models\DeityDressItem;
// use Illuminate\Support\Facades\Log;
class TempleBeshaController extends Controller
{
    //
    public function templemanagebesha(){
        $temple_beshas = TempleBesha::all(); // Fetch all records from the TempleBesha model

        // Return the view with the data
        return view('templeuser.templebesha.temple-manage-besha', compact('temple_beshas'));
    }
    public function addbesha(){
        $dressColors = TempleDressColor::all();
        $items = DeityDressItem::where('status', 'active')
       ->get();
        return view('templeuser.templebesha.temple-add-besha',compact('dressColors','items'));
    }
    // Method to save the Besha data (form submission)
    public function savebesha(Request $request)
    {
        // Validate the request
        $request->validate([
            'besha_name' => 'required|string|max:255',
            'items' => 'required|array',
            'description' => 'nullable|string',
            'estimated_time' => 'required|date_format:H:i',
            'time_period' => 'required|in:AM,PM',
            'date' => 'nullable|date',
            'weekly_day' => 'nullable|string',
            'dress_color' => 'nullable|string',

            'special_day' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Save the Besha data
        $besha = new TempleBesha;
        $besha->besha_name = $request->besha_name;
        $besha->items = implode(',', $request->items); // Store items as comma-separated string
        $besha->description = $request->description;
        $besha->estimated_time = $request->estimated_time;
        $besha->time_period =  $request->time_period;

        $besha->total_time = $request->total_time;
        $besha->date = $request->date;

        $besha->weekly_day = $request->weekly_day;
        $besha->dress_color = $request->dress_color;
        $besha->special_day = $request->special_day;

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('besha_photos', 'public');
                $photos[] = $path;
            }
            $besha->photos = implode(',', $photos);
        }
      

        // Save the Besha record to the database
        $besha->save();

        // Redirect to a success page (you can change this URL as needed)
        return redirect()->route('templeuser.managebesha')->with('success', 'Besha added successfully');
    }
    public function edit($id)
{
    $besha = TempleBesha::findOrFail($id);
    $items = DeityDressItem::where('status', 'active')
       ->get();
    $dressColors = TempleDressColor::all();
    
    return view('templeuser.templebesha.temple-edit-besha', compact('besha', 'items', 'dressColors'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'besha_name' => 'required|string|max:255',
        'items' => 'nullable|array',
        'description' => 'nullable|string',
        'estimated_time' => 'nullable|string',
        'time_period' => 'nullable|string|in:AM,PM',
        'total_time' => 'nullable|string',
        'date' => 'nullable|date',
        'weekly_day' => 'nullable|string',
        'dress_color' => 'nullable|string',
        'special_day' => 'nullable|string',
        'photos.*' => 'nullable|image|mimes:jpeg,png|max:2048',
    ]);

    $besha = TempleBesha::findOrFail($id);

    $besha->besha_name = $request->besha_name;
    // $besha->items = json_encode($request->items); // Save as JSON if multiple
    $besha->items = implode(',', $request->items);
    $besha->description = $request->description;
    $besha->estimated_time = $request->estimated_time;
    $besha->time_period = $request->time_period;
    $besha->total_time = $request->total_time;
    $besha->date = $request->date;
    $besha->weekly_day = $request->weekly_day;
    $besha->dress_color = $request->dress_color;
    $besha->special_day = $request->special_day;

   // Handle Removed Photos
   $removedPhotos = $request->input('removed_photos') ? explode(',', $request->input('removed_photos')) : [];
   $existingPhotos = explode(',', $besha->photos);
   $remainingPhotos = array_diff($existingPhotos, $removedPhotos);

   // Delete Removed Photos from Storage
   foreach ($removedPhotos as $photo) {
       if (file_exists(public_path($photo))) {
           unlink(public_path($photo));
       }
   }

   // Handle New Photos
//    $newPhotos = [];
//    if ($request->hasFile('photos')) {
//        foreach ($request->file('photos') as $file) {
//            $path = $file->store('besha_photos', 'public');
//            $newPhotos[] = 'besha_photos/' . basename($path);
//        }
//    }

//    // Merge Remaining Photos with New Photos
//    $updatedPhotos = array_merge($remainingPhotos, $newPhotos);

//    // Update the Besha Record
//    $besha->photos = implode(',', $updatedPhotos);

   // Handle New Photos
$newPhotos = [];
if ($request->hasFile('photos')) {
    foreach ($request->file('photos') as $file) {
        $path = $file->store('besha_photos', 'public');
        if ($path) {
            $newPhotos[] = 'besha_photos/' . basename($path);
        } else {
            logger('File upload failed for: ' . $file->getClientOriginalName());
        }
    }
}

// Merge Remaining Photos with New Photos
$updatedPhotos = array_merge($remainingPhotos, $newPhotos);

// Debug Final Photos Array
// Log::info('Final photos to save: ' . implode(',', $updatedPhotos));

// Update the Besha Record
$besha->photos = implode(',', $updatedPhotos);
// $besha->save();


   $besha->save();

   return redirect()->route('templeuser.managebesha')->with('success', 'Besha updated successfully!');
}
public function delete($id)
    {
        // Find the Besha record by ID
        $besha = TempleBesha::findOrFail($id);

        // Delete associated photos from storage
        if ($besha->photos) {
            $photos = explode(',', $besha->photos);
            foreach ($photos as $photo) {
                $photoPath = public_path($photo);
                if (file_exists($photoPath)) {
                    // Log the photo deletion
                    Log::info('Deleting photo: ' . $photo);
                    File::delete($photoPath);
                }
            }
        }

        // Delete the Besha record
        $besha->delete();

        // Redirect back with success message
        return redirect()->route('templeuser.managebesha')->with('success', 'Besha deleted successfully!');
    }

}
