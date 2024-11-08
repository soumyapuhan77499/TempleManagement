<?php

namespace App\Http\Controllers\templeUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeityMaster;

class DeityController extends Controller
{
    public function addDeity(){
        return view('templeuser.add-deity');
    }

    public function manageDeity(){

        $manage_deity = DeityMaster::where('status', 'active')->get();
        return view('templeuser.manage-deity',compact('manage_deity'));
    }

    public function saveDeity(Request $request)
{
    $request->validate([
        'deity_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'deity_type' => 'nullable|boolean', // Validate deity_type as boolean
    ]);

    $deity = new DeityMaster();
    $deity->language = $request->input('language');
    $deity->deity_name = $request->input('deity_name');
    $deity->description = $request->input('description');
    
    // Check if 'deity_type' checkbox is checked, set it to 1 if checked, 0 if not
    $deity->deity_type = $request->has('deity_type') ? 1 : 0;

    $deity->save();

    return redirect()->back()->with('success', 'Deity saved successfully!');
}

public function editDeity($id)
{
    // Find the deity by ID
    $deity = DeityMaster::findOrFail($id);

    // Pass the deity data to the edit view
    return view('templeuser.edit-deity', compact('deity'));
}

public function updateDeity(Request $request, $id)
{
    $request->validate([
        'deity_name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Find the deity by ID
    $deity = DeityMaster::findOrFail($id);
    $deity->language = $request->input('language');
    $deity->deity_name = $request->input('deity_name');
    $deity->description = $request->input('description');
    $deity->deity_type = $request->input('deity_type', 0); // Default to 0 if not checked
    $deity->save();

    return redirect()->route('manageDeity')->with('success', 'Deity updated successfully!');
}

public function deletDeity($id)
{
    // Find the deity by ID
    $deity = DeityMaster::findOrFail($id);

    // Update the status to 'deleted' instead of deleting the row
    $deity->status = 'deleted';
    $deity->save();

    // Redirect back with a success message
    return redirect()->route('manageDeity')->with('success', 'Deity marked as deleted.');
}


}
