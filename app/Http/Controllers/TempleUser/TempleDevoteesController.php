<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDevotee;
use Illuminate\Support\Facades\Auth;
class TempleDevoteesController extends Controller
{
    //
    public function managedevotees(){
        $templeId = Auth::guard('temples')->user()->temple_id;
   
        $devotees = TempleDevotee::where('status','active') ->where('temple_id', $templeId)->get();
        return view('templeuser.manage-temple-devotees',compact('devotees'));
    }
    public function adddevotees(){
        return view('templeuser.add-temple-devotee');
    }
    public function storedata(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'dob' => 'required|date',
            'photo' => 'required|image|max:2048',
            'gotra' => 'required|string|max:255',
            'rashi' => 'required|string|max:255',
            'nakshatra' => 'nullable|string|max:255',
            'anniversary_date' => 'nullable|date',
            'address' => 'required|string|max:500',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('devotees_photos', 'public');
        }

        // Save data in database
        TempleDevotee::create([
            'temple_id' =>  Auth::guard('temples')->user()->temple_id, 
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'photo' => $photoPath,
            'gotra' => $request->gotra,
            'rashi' => $request->rashi,
            'nakshatra' => $request->nakshatra,
            'anniversary_date' => $request->anniversary_date,
            'address' => $request->address,
            
        ]);

        return redirect()->route('templedevotees.managedevotees')->with('success', 'Devotee added successfully.');
    }
    public function edit($id)
    {
        $devotee = TempleDevotee::findOrFail($id);
        return view('templeuser.edit-devotees', compact('devotee'));
    }
       // Update a devotee
       public function update(Request $request, $id)
       {
           $request->validate([
               'name' => 'required',
               'phone_number' => 'required',
               'dob' => 'required|date',
               'photo' => 'nullable|image',
               'gotra' => 'required',
               'rashi' => 'required',
               'address' => 'required',
           ]);
       
           $devotee = TempleDevotee::findOrFail($id);
       
           // If a new photo is uploaded, handle the file upload
           if ($request->hasFile('photo')) {
               // Delete old photo if necessary
               if ($devotee->photo) {
                   Storage::disk('public')->delete($devotee->photo);
               }
               $photoPath = $request->file('photo')->store('photos', 'public');
               $devotee->photo = $photoPath;
           }
       
           // Update the devotee's data
           $devotee->update([
               'name' => $request->name,
               'phone_number' => $request->phone_number,
               'dob' => $request->dob,
               'gotra' => $request->gotra,
               'rashi' => $request->rashi,
               'anniversary_date' => $request->anniversary_date,
               'address' => $request->address,
           ]);
       
           return redirect()->route('templedevotees.managedevotees')
                            ->with('success', 'Devotee updated successfully.');
       }
       
   
       // Deactivate (soft delete) a devotee
       public function destroy($id)
       {
        $festival = TempleDevotee::findOrFail($id); // Find the festival by ID
        $festival->status = 'deleted'; // Change status to 'deactive'
        $festival->save(); // Save the updated status
    
        return redirect()->route('templedevotees.managedevotees')->with('success', 'Devotee Deleted successfully!');
       }
   


   
}
