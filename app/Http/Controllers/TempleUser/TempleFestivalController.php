<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleFestival;
use Illuminate\Support\Facades\Auth;

class TempleFestivalController extends Controller
{
    //
    public function addFestival(){
        return view('templeuser.add-temple-festival');
    }
     
     // Save the festival to the database
     public function storedata(Request $request)
     {
         $validatedData = $request->validate([
             'festival_name' => 'required|string|max:255',
             'festival_date' => 'required|date',
             'festival_descp' => 'required|string',
         ]);
 
         TempleFestival::create([
             'temple_id' =>  Auth::guard('temples')->user()->temple_id, // Example temple_id (use actual temple id)
             'festival_name' => $validatedData['festival_name'],
             'festival_date' => $validatedData['festival_date'],
             'festival_descp' => $validatedData['festival_descp'],
             'status' => 'active'
         ]);
 
         return redirect()->route('templefestival.managefestivals')->with('success', 'Festival added successfully!');
     }
 
     // Display all festivals
     public function managefestivals()
     {
         $festivals = TempleFestival::where('status','active')->get();
         return view('templeuser.manage-festivals', compact('festivals'));
     }
 
     // Display the edit form
     public function edit($id)
     {
         $festival = TempleFestival::findOrFail($id);
         return view('templeuser.edit-festival', compact('festival'));
     }
 
     // Update the festival in the database
     public function update(Request $request, $id)
     {
         $validatedData = $request->validate([
             'festival_name' => 'required|string|max:255',
             'festival_date' => 'required|date',
             'festival_descp' => 'required|string',
         ]);
 
         $festival = TempleFestival::findOrFail($id);
         $festival->update([
             'festival_name' => $validatedData['festival_name'],
             'festival_date' => $validatedData['festival_date'],
             'festival_descp' => $validatedData['festival_descp'],
         ]);
 
         return redirect()->route('templefestival.managefestivals')->with('success', 'Festival updated successfully!');
     }
 
     // Soft-delete the festival (mark as inactive)
     public function destroy($id)
     {
         $festival = TempleFestival::findOrFail($id); // Find the festival by ID
         $festival->status = 'deactive'; // Change status to 'deactive'
         $festival->save(); // Save the updated status
     
         return redirect()->route('templefestival.managefestivals')->with('success', 'Festival deactivated successfully!');
     }
     
}
