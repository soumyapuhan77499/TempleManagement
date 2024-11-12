<?php

namespace App\Http\Controllers\templeUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NitiMaster;
use App\Models\SebaMaster;
use App\Models\NitiStep;
use App\Models\NitiItems;
use App\Models\SebayatMaster;


use Illuminate\Support\Facades\Auth;

class NitiController extends Controller
{

    public function addniti(){

        $templeId = Auth::guard('temples')->user()->temple_id;

        $manage_seba = SebaMaster::where('status', 'active')->where('temple_id', $templeId)->get();

        $sebayat_list = SebayatMaster::where('status', 'active')->get();


        return view('templeuser.add-niti', compact('manage_seba','sebayat_list'));

    }

    public function saveNitiMaster(Request $request)
    {

        try {
            // Validate incoming data
            $request->validate([
                'niti_name' => 'required|string|max:255',
                'language' => 'required|string',
                'date_time' => 'required|date',
                'niti_about' => 'nullable|string',
                'description' => 'nullable|string',
                'niti_sebayat' => 'sometimes|array',
                'niti_sebayat.*' => 'string',
                'item_name' => 'sometimes|array',
                'item_name.*' => 'string|max:255',
                'quantity' => 'sometimes|array',
                'quantity.*' => 'numeric|min:0',
                'unit' => 'sometimes|array',
                'unit.*' => 'string|max:10',
                'step_of_niti' => 'sometimes|array',
                'step_of_niti.*' => 'string|max:255',
             
            ]);
            
            // Generate a unique niti_id
            $niti_id = 'NITI' . rand(10000, 99999);
    
            // Get temple ID from authenticated user
            $templeId = Auth::guard('temples')->user()->temple_id;
    
            // Save main Niti data
            $niti = new NitiMaster();
            $niti->niti_id = $niti_id;
            $niti->temple_id = $templeId;
            $niti->language = $request->input('language');
            $niti->niti_name = $request->input('niti_name');
            $niti->date_time = $request->input('date_time');
            $niti->niti_about = $request->input('niti_about');
            $niti->description = $request->input('description');
            $niti->niti_type = $request->boolean('niti_type') ? 'special_niti' : 'daily_niti';
    
            // Save sebayat names as a comma-separated list, only if provided
            if ($request->has('niti_sebayat') && is_array($request->input('niti_sebayat')) && count($request->input('niti_sebayat')) > 0) {
                $niti->niti_sebayat = implode(',', $request->input('niti_sebayat'));
            }
    
            $niti->save();
    
            // Save items related to this Niti (item_name, quantity, unit)
            if ($request->has('item_name') && is_array($request->input('item_name'))) {
                $items = $request->input('item_name');
                $quantities = $request->input('quantity');
                $units = $request->input('unit');
    
                foreach ($items as $index => $itemName) {
                    if ($itemName) {
                        NitiItems::create([
                            'niti_id' => $niti_id,
                            'item_name' => $itemName,
                            'quantity' => $quantities[$index] ?? null,
                            'unit' => $units[$index] ?? null,
                        ]);
                    }
                }
            }
    
          // Check if the 'step_of_niti' exists and is an array

          if ($request->has('step_of_niti') && is_array($request->input('step_of_niti'))) {
            $steps = $request->input('step_of_niti');  // Get all the steps from the form
            $sebas = $request->input('seba_name');     // Get the associated seba_name array
            
            foreach ($steps as $index => $stepName) {
                if ($stepName) {
                    // Ensure the index exists in $sebas and it's an array
                        $sebaNamesString = implode(',', $sebas);
                     
                            
                    // Save the NitiStep model
                    NitiStep::create([
                        'niti_id' => $niti_id,          // The Niti ID (ensure $niti_id is defined)
                        'step_name' => $stepName,       // The step name
                        'seba_name' => $sebaNamesString, // The comma-separated Seba names
                    ]);
                }
            }
        }
        
            return redirect()->back()->with('success', 'Niti details saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving Niti details: ' . $e->getMessage()]);
        }
    }
    
    

     
    public function manageniti()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Fetch NitiMaster with related steps and items
        $manage_niti_master = NitiMaster::with(['steps', 'niti_items'])
                                ->where('status', 'active')
                                ->where('temple_id', $templeId)
                                ->get();
    
        // Fetch Seba data
        $manage_seba = SebaMaster::all();
    
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
