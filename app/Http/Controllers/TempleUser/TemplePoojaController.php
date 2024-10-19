<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePooja;
use App\Models\InsideTemple;

use Illuminate\Support\Facades\Auth;

class TemplePoojaController extends Controller
{
    //
    public function addPooja(){
        $templeId = Auth::guard('temples')->user()->temple_id;
        $temples = InsideTemple::where('status', 'active')->where('temple_id', $templeId)->get(['id', 'inside_temple_name']);
    
        // Pass the temple data to the view
        return view('templeuser.add-temple-pooja', compact('temples'));
    }
      // Store pooja data
      public function storePooja(Request $request)
      {
          // Validate the request data
          $request->validate([
              'pooja_name' => 'required|string|max:255',
              'pooja_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
              'pooja_price' => 'required|numeric',
              'pooja_descp' => 'nullable|string',
              'inside_temple_id' => 'nullable|', // Make this field optional
          ]);
      
          // Handle file upload and save the image to the 'pooja_images' directory in 'public' storage
          $poojaImagePath = null;
          if ($request->hasFile('pooja_image')) {
              $poojaImagePath = $request->file('pooja_image')->store('pooja_images', 'public');
          }
      
          // Save the pooja data
          TemplePooja::create([
              'temple_id' => Auth::guard('temples')->user()->temple_id, // Assuming temple_id is linked to user
              'pooja_image' => $poojaImagePath,
              'pooja_name' => $request->pooja_name,
              'pooja_price' => $request->pooja_price,
              'pooja_descp' => $request->pooja_descp,
              'inside_temple_id' => $request->inside_temple_id, // Save the inside temple ID if provided
              'status' => 'active',
          ]);
      
          return redirect()->route('templepooja.pooja')->with('success', 'Pooja added successfully!');
      }
      
      // Manage active pooja items
      public function managePooja()
      {
          $templeId = Auth::guard('temples')->user()->temple_id; // Get the current temple's ID
          $poojaList = TemplePooja::where('temple_id', $templeId)->where('status', 'active')->get(); // Fetch active pooja for the current temple
          return view('templeuser.manage-pooja', compact('poojaList')); // Return the view with the data
      }
  
      // Show edit pooja form
      public function editPooja($id)
      {
        $templeId = Auth::guard('temples')->user()->temple_id;

          $pooja = TemplePooja::findOrFail($id);
          $temples = InsideTemple::where('status', 'active')->where('temple_id', $templeId)->get(['id', 'inside_temple_name']);
    
          return view('templeuser.edit-temple-pooja', compact('pooja', 'temples')); // Pass temples to the view
      }
      // Update pooja data
      public function updatePooja(Request $request, $id)
      {
          $request->validate([
              'pooja_name' => 'required|string|max:255',
              'pooja_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
              'pooja_price' => 'required|numeric',
              'pooja_descp' => 'nullable|string',
              'inside_temple_id' => 'nullable|integer', // Validate inside_temple_id
          ]);
      
          $pooja = TemplePooja::findOrFail($id);
      
          // Handle file upload and save the image to the 'pooja_images' directory in 'public' storage
          $poojaImagePath = $pooja->pooja_image; // Keep the old image if no new one is uploaded
          if ($request->hasFile('pooja_image')) {
              // Optionally delete the old image here
              if ($pooja->pooja_image) {
                  Storage::delete('public/' . $pooja->pooja_image);
              }
              $poojaImagePath = $request->file('pooja_image')->store('pooja_images', 'public');
          }
      
          // Update pooja data including inside_temple_id
          $pooja->update([
              'pooja_image' => $poojaImagePath,
              'pooja_name' => $request->pooja_name,
              'pooja_price' => $request->pooja_price,
              'pooja_descp' => $request->pooja_descp,
              'inside_temple_id' => $request->inside_temple_id, // Update inside_temple_id
          ]);
      
          return redirect()->route('templepooja.managepooja')->with('success', 'Pooja updated successfully!');
      }
      

  
      // Soft delete pooja (change status to deactive)
      public function destroyPooja($id)
      {
          $pooja = TemplePooja::findOrFail($id);
          $pooja->update(['status' => 'deleted']);
  
          return redirect()->route('templepooja.managepooja')->with('success', 'Pooja deactivated successfully!');
      }
      
  
    
      
}

