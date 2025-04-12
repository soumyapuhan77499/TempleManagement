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
                'step_of_niti' => 'sometimes|array',
                'seba_name' => 'sometimes|array',
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
    
            // ✅ Correctly save niti_type
            $niti->niti_type = $request->input('niti_type') === 'special' ? 'special' : 'daily';
    
            // ✅ Correctly save niti_privacy
            $niti->niti_privacy = $request->input('niti_privacy') === 'private' ? 'private' : 'public';
    
            // ✅ Save sebayat list as CSV if present
            if ($request->filled('niti_sebayat')) {
                $niti->niti_sebayat = implode(',', $request->niti_sebayat);
            }
    
            $niti->save();
    
            // ✅ Save Niti Items
            if ($request->filled('item_name')) {
                $items = $request->input('item_name');
                $quantities = $request->input('quantity');
                $units = $request->input('unit');
    
                foreach ($items as $index => $itemName) {
                    if (!empty($itemName)) {
                        NitiItems::create([
                            'niti_id' => $niti_id,
                            'item_name' => $itemName,
                            'quantity' => $quantities[$index] ?? null,
                            'unit' => $units[$index] ?? null,
                        ]);
                    }
                }
            }
    
            // ✅ Save Niti Steps with specific seba_name
            if ($request->filled('step_of_niti')) {
                $steps = $request->input('step_of_niti');
                $sebas = $request->input('seba_name');
    
                foreach ($steps as $index => $stepName) {
                    if (!empty($stepName)) {
                        $stepSebas = $sebas[$index] ?? [];
                        $sebaNamesString = is_array($stepSebas) ? implode(',', $stepSebas) : '';
    
                        NitiStep::create([
                            'niti_id' => $niti_id,
                            'step_name' => $stepName,
                            'seba_name' => $sebaNamesString,
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

    public function editNitiMaster($nitiId)
{
    // Fetch NitiMaster record (use first() to get a single instance)
    $niti = NitiMaster::where('niti_id', $nitiId)->first();

    // If the NitiMaster record doesn't exist, redirect with an error message
    if (!$niti) {
        return redirect()->route('manageniti')->with('error', 'NitiMaster not found');
    }

    // Fetch related NitiItems (assuming there's a relationship defined)
    $nitiItems = $niti->niti_items;

    // Fetch SebaMaster and SebayatMaster for the dropdown
    $manage_seba = SebaMaster::where('status', 'active')->get();

    $niti_step = NitiStep::where('status', 'active')->get();

    // Fetch the SebayatMaster list
    $sebayat_list = SebayatMaster::where('status', 'active')->get();

    // Split the niti_sebayat field (which stores the selected Sebayats) into an array
    $selectedSebayats = explode(',', $niti->niti_sebayat);

    // Fetch related NitiSteps (assuming there's a relationship defined)
    $nitiSteps = $niti->steps;

 // For each step, convert the 'seba_names' field into an array
 foreach ($nitiSteps as $step) {
     $step->seba_name = explode(',', $step->seba_name); // Ensure `seba_names` is an array
 }

    // Pass data to the view
    return view('templeuser.edit-niti-master', compact('niti', 'nitiItems', 'manage_seba', 'sebayat_list', 'nitiSteps', 'selectedSebayats'));
}


public function updateNitiMaster(Request $request, $id)
{
    try {
        // Validate incoming data
        $request->validate([
            'niti_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|string|in:English,Hindi,Odia',
        ]);

        // Find the existing Niti entry
        $niti = NitiMaster::findOrFail($id);

        // Update Niti master details
        $niti->language = $request->input('language');
        $niti->niti_name = $request->input('niti_name');
        $niti->date_time = $request->input('date_time');
        $niti->niti_about = $request->input('niti_about');
        $niti->description = $request->input('description');
        $niti->niti_type = $request->boolean('niti_type') ? 'special' : 'daily';

        // Handle `niti_sebayat` as a comma-separated string if provided
        if ($request->has('niti_sebayat') && is_array($request->input('niti_sebayat'))) {
            $niti->niti_sebayat = implode(',', $request->input('niti_sebayat'));
        }

        $niti->save();

        // Update or create related items for this Niti
        if ($request->has('item_name') && is_array($request->input('item_name'))) {
            // Remove existing items related to this Niti
            NitiItems::where('niti_id', $niti->id)->delete();

            $items = $request->input('item_name');
            $quantities = $request->input('quantity');
            $units = $request->input('unit');

            foreach ($items as $index => $itemName) {
                if ($itemName) {
                    NitiItems::create([
                        'niti_id' => $niti->id,
                        'item_name' => $itemName,
                        'quantity' => $quantities[$index] ?? null,
                        'unit' => $units[$index] ?? null,
                    ]);
                }
            }
        }

        // Update or create related steps for this Niti
        if ($request->has('step_of_niti') && is_array($request->input('step_of_niti'))) {
            // Remove existing steps related to this Niti
            NitiStep::where('niti_id', $niti->id)->delete();

            $steps = $request->input('step_of_niti');
            $sebas = $request->input('seba_name');

            foreach ($steps as $index => $stepName) {
                if ($stepName) {
                    // Ensure that `$sebas` has an entry at `$index`
                    $sebaNamesString = isset($sebas[$index]) ? implode(',', (array)$sebas[$index]) : '';

                    NitiStep::create([
                        'niti_id' => $niti->id,
                        'step_name' => $stepName,
                        'seba_name' => $sebaNamesString,
                    ]);
                }
            }
        }

        // Redirect with a success message
        return redirect()->route('manageniti')->with('success', 'Niti updated successfully!');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('manageniti')->with('error', 'Niti not found.');
    } catch (\Exception $e) {
        return redirect()->route('manageniti')->with('error', 'An error occurred while updating the Niti: ' . $e->getMessage());
    }
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
