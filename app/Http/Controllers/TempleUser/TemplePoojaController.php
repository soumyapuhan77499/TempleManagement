<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePooja;
use Illuminate\Support\Facades\Auth;

class TemplePoojaController extends Controller
{
    //
    public function addPooja(){
        return view('templeuser.add-temple-pooja');
    }
      // Store pooja data
    public function storePooja(Request $request)
    {
          $request->validate([
              'pooja_name' => 'required|string|max:255',
              'pooja_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
              'pooja_price' => 'required|numeric',
              'pooja_descp' => 'nullable|string',
          ]);
      
          // Handle file upload and save the image to the 'pooja_images' directory in 'public' storage
          $poojaImagePath = null;
          if ($request->hasFile('pooja_image')) {
              $poojaImagePath = $request->file('pooja_image')->store('pooja_images', 'public');
          }
      
          // Save the pooja data
          TemplePooja::create([
              'temple_id' =>  Auth::guard('temples')->user()->temple_id, // Assuming temple_id is linked to user
              'pooja_image' => $poojaImagePath,
              'pooja_name' => $request->pooja_name,
              'pooja_price' => $request->pooja_price,
              'pooja_descp' => $request->pooja_descp,
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
          $pooja = TemplePooja::findOrFail($id);
          return view('templeuser.edit-temple-pooja', compact('pooja')); // Create this blade view for editing
      }
  
      // Update pooja data
      public function updatePooja(Request $request, $id)
        {
            $request->validate([
                'pooja_name' => 'required|string|max:255',
                'pooja_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'pooja_price' => 'required|numeric',
                'pooja_descp' => 'nullable|string',
            ]);

            $pooja = TemplePooja::findOrFail($id);

            // Handle file upload and save the image to the 'pooja_images' directory in 'public' storage
            $poojaImagePath = $pooja->pooja_image; // Keep the old image if no new one is uploaded
            if ($request->hasFile('pooja_image')) {
                $poojaImagePath = $request->file('pooja_image')->store('pooja_images', 'public');
            }

            // Update pooja data
            $pooja->update([
                'pooja_image' => $poojaImagePath,
                'pooja_name' => $request->pooja_name,
                'pooja_price' => $request->pooja_price,
                'pooja_descp' => $request->pooja_descp,
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

