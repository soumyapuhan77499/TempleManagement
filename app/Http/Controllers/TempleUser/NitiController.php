<?php

namespace App\Http\Controllers\templeUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NitiMaster;
use App\Models\SebaMaster;
use App\Models\NitiStep;

class NitiController extends Controller
{
     
    public function addniti(){

        $manage_seba = SebaMaster::where('status', 'active')->get();

        return view('templeuser.add-niti', compact('manage_seba'));

    }

    public function saveNitiMaster(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'niti_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|string',
            'seba_name' => 'nullable|array', // Ensure that seba_name is an array if it's passed as multiple values
            'step_of_niti' => 'nullable|array', // Ensure step_of_niti is an array if multiple steps are provided
        ]);
    
        // Save data to the NitiMaster model
        $niti = new NitiMaster();
        $niti->language = $request->input('language');
        $niti->niti_name = $request->input('niti_name');
        $niti->description = $request->input('description');
        $niti->save();
    
        // If seba_name is selected, associate them with the NitiMaster (if using a relationship)
        if ($request->has('seba_name') && count($request->input('seba_name')) > 0) {
            $sebanames = $request->input('seba_name');
            $sebaknamesString = implode(',', $sebanames); // You could save this in a dedicated column or table if required
            $niti->seba_name = $sebaknamesString; // Or store as a string or in a related table
            $niti->save();
        }
    
        // Save the steps related to this Niti
        if ($request->has('step_of_niti') && count($request->input('step_of_niti')) > 0) {
            foreach ($request->input('step_of_niti') as $step) {
                $nitiStep = new NitiStep();
                $nitiStep->niti_id = $niti->id; // Use the saved Niti ID here
                $nitiStep->step_name = $step;
                $nitiStep->save();
            }
        }
    
        // Redirect with a success message
        return redirect()->back()->with('success', 'Niti saved successfully!');
    }
    
     
    public function manageniti() {
        $manage_niti_master = NitiMaster::with('steps')->where('status', 'active')->get();
        $manage_seba = SebaMaster::all();  // Fetching Seba data, assuming the `Seba` model exists.
        
        return view('templeuser.manage-niti-master', compact('manage_niti_master', 'manage_seba'));
    }
    
    public function editNitiMaster($id) {
        $niti_master = NitiMaster::findOrFail($id);
        $manage_niti_master = NitiMaster::all();  // Adjust this based on your requirements
        return view('templeuser.edit-niti-master', compact('niti_master', 'manage_niti_master'));
    }
    
    public function updateNitiMaster(Request $request, $id)
    {
        // Validate incoming data
        $request->validate([
            'niti_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|string|in:English,Hindi,Odia', // Validate the language
            'seba_name' => 'nullable|array', // Validate the array of seba names
            'seba_name.*' => 'nullable|string|max:255', // Ensure each seba name is a string
            'step_of_niti' => 'nullable|array', // Validate the steps array
            'step_of_niti.*' => 'nullable|string|max:255', // Ensure each step is a string
        ]);
    
        // Update the existing Niti entry
        $niti = NitiMaster::findOrFail($id);
    
        // Update Niti master details
        $niti->niti_name = $request->input('niti_name');
        $niti->description = $request->input('description');
        $niti->language = $request->input('language');
        $niti->seba_name = implode(',', $request->input('seba_name', [])); // Save the selected seba names as a comma-separated string
        $niti->save();
    
        // Update or create steps (if any)
        if ($request->has('step_of_niti')) {
            // Get the IDs of the existing steps
            $existingStepIds = $niti->steps->pluck('id')->toArray();
    
            // Iterate through the incoming steps
            foreach ($request->input('step_of_niti') as $key => $step_name) {
                // If step exists, update it, otherwise create a new one
                $step = isset($niti->steps[$key]) ? $niti->steps[$key] : new NitiStep;
                $step->niti_id = $niti->id;
                $step->step_name = $step_name;
                $step->save();
    
                // Remove the step ID from the existing step IDs list
                if (($key = array_search($step->id, $existingStepIds)) !== false) {
                    unset($existingStepIds[$key]);
                }
            }
    
            // Delete steps that are no longer part of the update
            if (!empty($existingStepIds)) {
                NitiStep::whereIn('id', $existingStepIds)->delete();
            }
        }
    
        // Redirect with a success message
        return redirect()->route('manageniti')->with('success', 'Niti updated successfully!');
    }
    
public function deleteNitiMaster($id)
{
    // Find the Niti record
    $niti = NitiMaster::findOrFail($id);

    // Update the status to 'deleted'
    $niti->status = 'deleted';
    $niti->save();

    // Redirect with a success message
    return redirect()->route('manageniti')->with('success', 'Niti deleted successfully!');
}


}
