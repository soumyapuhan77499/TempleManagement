<?php

namespace App\Http\Controllers\templeUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SebaMaster;
use App\Models\SebayatMaster;
use App\Models\SebaStep;

class SebakController extends Controller
{
    
    public function manageSeba()
    {
        // Fetch SebaMaster records with their associated SebaStep records
        $manage_seba = SebaMaster::where('status', 'active')->with('steps')->get();
        return view('templeuser.manage-seba', compact('manage_seba'));
    }
    

    public function addSeba(){
        return view('templeuser.add-seba');
    }

    public function editSeba($id)
    {
        $seba = SebaMaster::findOrFail($id);
        return view('templeuser.edit-seba', compact('seba'));
    }
    
public function saveSeba(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'seba_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'step_of_seba' => 'required|array',
        'step_of_seba.*' => 'string|max:255',
    ]);

    // Save data to the SebaMaster model
    $seba = new SebaMaster();
    $seba->language = $request->input('language');
    $seba->seba_name = $request->input('seba_name');
    $seba->description = $request->input('description');
    $seba->save();

    // Loop through each step and save it in the SebaStep model
    foreach ($request->input('step_of_seba') as $step) {
        $sebaStep = new SebaStep();
        $sebaStep->seba_id = $seba->id;
        $sebaStep->step_name = $step;
        $sebaStep->save();
    }

    // Redirect with a success message
    return redirect()->back()->with('success', 'Seba and steps saved successfully!');
}

public function updateSeba(Request $request, $id)
{
    // Validate incoming data
    $request->validate([
        'seba_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'step_of_seba' => 'nullable|array', // Ensure steps are an array
        'step_of_seba.*' => 'string|max:255', // Each step should be a string
    ]);

    // Update the main SebaMaster entry
    $seba = SebaMaster::findOrFail($id);
    $seba->language = $request->input('language');
    $seba->seba_name = $request->input('seba_name');
    $seba->description = $request->input('description');
    $seba->save();

    // Retrieve the existing steps for the Seba
    $existingSteps = $seba->steps; // Assuming the SebaMaster model has a `steps` relationship
    $newSteps = $request->input('step_of_seba', []);

    // Track updated or new steps by ID to retain them
    $updatedStepIds = [];

    foreach ($newSteps as $index => $stepName) {
        if (isset($existingSteps[$index])) {
            // Update existing step
            $existingSteps[$index]->update([
                'step_name' => $stepName,
            ]);
            $updatedStepIds[] = $existingSteps[$index]->id;
        } else {
            // Create new step
            $newStep = $seba->steps()->create([
                'step_name' => $stepName,
                'seba_id' => $seba->id, // Associate with SebaMaster
            ]);
            $updatedStepIds[] = $newStep->id;
        }
    }

    // Remove steps that are no longer in the updatedStepIds list
    $seba->steps()->whereNotIn('id', $updatedStepIds)->delete();

    // Redirect with a success message
    return redirect()->route('manageSeba')->with('success', 'Seba updated successfully!');
}

public function deleteSeba($id)
{
    // Find the Niti record
    $niti = SebaMaster::findOrFail($id);

    // Update the status to 'deleted'
    $niti->status = 'deleted';
    $niti->save();

    // Redirect with a success message
    return redirect()->route('manageSeba')->with('success', 'Seba deleted successfully!');
}

   // sebayat controller start here

   public function manageSebayat(){
    $manage_sebayat = SebayatMaster::where('status', 'active')->get();
    return view('templeuser.manage-sebayat',compact('manage_sebayat'));
}

public function addSebayat(){
    return view('templeuser.add-sebayat');
}

public function editSebayat($id)
{
    $sebayat = SebayatMaster::findOrFail($id);
    return view('templeuser.edit-sebayat', compact('sebayat'));
}

public function saveSebayat(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'sebayat_name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Save data to the Niti model
    $niti = new SebayatMaster();
    $niti->language = $request->input('language');
    $niti->sebayat_name = $request->input('sebayat_name');
    $niti->description = $request->input('description');
    $niti->save();

    // Redirect with a success message
    return redirect()->back()->with('success', 'Sebayat saved successfully!');
}


public function updateSebayat(Request $request, $id)
{
// Validate incoming data
$request->validate([
    'sebayat_name' => 'required|string|max:255',
    'description' => 'nullable|string',
]);

// Update the existing Niti entry
$niti = SebayatMaster::findOrFail($id);
$niti->language = $request->input('language');
$niti->sebayat_name = $request->input('sebayat_name');
$niti->description = $request->input('description');
$niti->save();

// Redirect with a success message
return redirect()->route('manageSebayat')->with('success', 'Sebayat updated successfully!');
}

public function deleteSebayat($id)
{
// Find the Niti record
$niti = SebayatMaster::findOrFail($id);

// Update the status to 'deleted'
$niti->status = 'deleted';
$niti->save();

// Redirect with a success message
return redirect()->route('manageSebayat')->with('success', 'Sebayat deleted successfully!');
}


}
