<?php

namespace App\Http\Controllers\templeUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NitiMaster;
use App\Models\SebaMaster;
use App\Models\NitiStep;
use App\Models\NitiItems;
use App\Models\TempleSubNiti;
use App\Models\SebayatMaster;
use App\Models\TemplePrasad;
use App\Models\Darshan;
use App\Models\NitiManagement;
use App\Models\DarshanDetails;


use Illuminate\Support\Facades\Auth;

class NitiController extends Controller
{

    public function addniti()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        $manage_seba = SebaMaster::where('status', 'active')->where('temple_id', $templeId)->get();
        $sebayat_list = SebayatMaster::where('status', 'active')->get();

        $daily_nitis = NitiMaster::where('status', 'active')->where('niti_type','daily')->get();

    
        // ✅ Fetch Mahaprasads and Darshans
        $mahaprasads = TemplePrasad::where('temple_id', $templeId)
            ->where('status', 'active')
            ->get(['id', 'prasad_name as name']);
    
        $darshans = DarshanDetails::where('temple_id', $templeId)
            ->where('status', 'active')
            ->get(['id', 'darshan_name as name']);
    
        return view('templeuser.add-niti', compact('manage_seba', 'sebayat_list', 'mahaprasads', 'darshans','daily_nitis'));
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
            $niti->after_special_niti = $request->input('after_special_niti');
            $niti->niti_about = $request->input('niti_about');
            $niti->description = $request->input('description');
    
            // ✅ Correctly save niti_type
            $niti->niti_type = $request->input('niti_type') === 'special' ? 'special' : 'daily';
    
            // ✅ Correctly save niti_privacy
            $niti->niti_privacy = $request->input('niti_privacy') === 'private' ? 'private' : 'public';

            $niti->connected_mahaprasad_id = $request->input('connected_mahaprasad_id');
            $niti->connected_darshan_id = $request->input('connected_darshan_id');

    
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

            // ✅ Save Sub Niti
            if ($request->filled('sub_niti_name')) {
                $subNitiNames = $request->input('sub_niti_name');

                foreach ($subNitiNames as $subNitiName) {
                    if (!empty($subNitiName)) {
                        TempleSubNiti::create([
                            'temple_id'     => $templeId,
                            'niti_id'       => $niti_id,
                            'sub_niti_name' => $subNitiName,
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

    public function editNitiMaster($id)
{
    $niti = NitiMaster::with([
        'steps',
        'niti_items',
        'subNitis',
        'afterSpecial'
    ])->where('niti_id', $id)->firstOrFail();

    $daily_nitis = NitiMaster::where('status', 'active')->get();
    $sebayat_list = SebaMaster::all();
    $manage_seba = SebaMaster::all();
   
    $mahaprasads = TemplePrasad::where('status', 'active')
    ->get(['id', 'prasad_name as name']);

$darshans = DarshanDetails::where('status', 'active')
    ->get(['id', 'darshan_name as name']);

    $subNitis = TempleSubNiti::where('niti_id', $niti->niti_id)->get(); // or []

    // fallback in case $subNitis is empty
    if ($subNitis->isEmpty()) {
        $subNitis = collect(); // makes sure it's a Collection, not null
    }
        $nitiItems = $niti->niti_items ?? collect();
    $nitiSteps = $niti->steps ?? collect();
    $selectedSebayats = json_decode($niti->niti_sebayat ?? '[]', true);

    return view('templeuser.edit-niti-master', compact(
        'niti',
        'daily_nitis',
        'sebayat_list',
        'manage_seba',
        'mahaprasads',
        'darshans',
        'subNitis',
        'nitiItems',
        'nitiSteps',
        'selectedSebayats'
    ));
}
public function updateNitiMaster(Request $request, $id)
{
    try {
        $request->validate([
            'language'           => 'nullable|string|max:50',
            'niti_name'          => 'required|string|max:255',
            'date_time'          => 'nullable|date',
            'niti_about'         => 'nullable|string',
            'description'        => 'nullable|string',
            'niti_type'          => 'nullable|string|in:special,daily',
            'niti_privacy'       => 'nullable|string|in:public,private',
            'after_special_niti' => 'nullable|string',
        ]);

        $niti = NitiMaster::findOrFail($id);

        $niti->language     = $request->input('language');
        $niti->niti_name    = $request->input('niti_name');
        $niti->date_time    = $request->input('date_time');
        $niti->after_special_niti = $request->input('after_special_niti');
        $niti->niti_about   = $request->input('niti_about');
        $niti->description  = $request->input('description');
        $niti->niti_type    = $request->input('niti_type'); // special OR daily
        $niti->niti_privacy = $request->input('niti_privacy', 'public');

        $niti->connected_mahaprasad_id = $request->input('connected_mahaprasad_id');
        $niti->connected_darshan_id    = $request->input('connected_darshan_id');

        $niti->save();

        // ✅ Update Sub Niti
        TempleSubNiti::where('niti_id', $niti->niti_id)->delete();

        if ($request->filled('sub_niti_name')) {
            $templeId = Auth::guard('temples')->user()->temple_id;

            foreach ($request->input('sub_niti_name') as $subName) {
                if (!empty($subName)) {
                    TempleSubNiti::create([
                        'temple_id'     => $templeId,
                        'niti_id'       => $niti->niti_id,
                        'sub_niti_name' => $subName,
                    ]);
                }
            }
        }

        return redirect()->route('manageniti')->with('success', 'Niti updated successfully!');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('manageniti')->with('error', 'Niti not found.');
    } catch (\Exception $e) {
        return redirect()->route('manageniti')->with('error', 'Error while updating Niti: ' . $e->getMessage());
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
