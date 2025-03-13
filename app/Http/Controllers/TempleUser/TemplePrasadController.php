<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePrasad;
use App\Models\TemplePrasadItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TemplePrasadController extends Controller
{
    //
    public function addPrasad(){
        return view('templeuser.add-temple-prasad');
    }

    public function store(Request $request)
    {
        try {
            // Ensure the authenticated temple user exists
            $templeUser = Auth::guard('temples')->user();
            if (!$templeUser) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }
    
            // Validate request data
            $request->validate([
                'prasad_name'  => 'required|string|max:255',
                'prasad_time'  => 'required',
                'prasad_price' => 'required|numeric',
                'prasad_item'  => 'required|array|min:1',
                'description'  => 'nullable|string',
            ]);
    
            // Convert prasad items array to a comma-separated string
            $prasadItems = implode(",", $request->input('prasad_item', []));
    
            // Create new TemplePrasad record
            $prasad = TemplePrasad::create([
                'temple_id'    => $templeUser->temple_id, // Ensure this ID exists
                'prasad_name'  => $request->input('prasad_name'),
                'prasad_time'  => $request->input('prasad_time'),
                'prasad_price' => $request->input('prasad_price'),
                'prasad_item'  => $prasadItems,
                'description'  => $request->input('description'),
                'online_order' => $request->has('online_order') ? 1 : 0,
                'pre_order'    => $request->has('pre_order') ? 1 : 0,
                'offline_order'=> $request->has('offline_order') ? 1 : 0,
            ]);
    
            if ($prasad) {
                return redirect()->back()->with('success', 'Temple Prasad details saved successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to save Temple Prasad details.');
            }
    
        } catch (\Exception $e) {
            // Log full error details for debugging
            Log::error('Error saving temple prasad: ', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            return redirect()->back()->with('error', 'An error occurred while saving the prasad details.');
        }
    }
    
    public function manageprasad()
    {
        // Get the current authenticated temple's ID
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Fetch temple prasad records associated with the current temple's ID
        $prasadas = TemplePrasad::
            where('temple_id', $templeId) // Add condition for temple_id
            ->get();
    
        return view('templeuser.manage-temple-prasads', compact('prasadas'));
    }
    

    public function update(Request $request, $id)
{
    // Validate request data
    $request->validate([
        'prasad_name' => 'required|string|max:255',
        'prasad_time' => 'required',
        'prasad_price' => 'required|numeric',
        'prasad_item' => 'required|array',
        'prasad_item.*' => 'string|max:255',
        'description' => 'nullable|string',
    ]);

    // Find the Prasad record by ID
    $prasad = TemplePrasad::findOrFail($id);

    // Update the record
    $prasad->prasad_name = $request->prasad_name;
    $prasad->prasad_time = $request->prasad_time;
    $prasad->prasad_price = $request->prasad_price;
    $prasad->prasad_item = implode(',', $request->prasad_item); // Store as a comma-separated string
    $prasad->online_order = $request->has('online_order') ? 1 : 0;
    $prasad->pre_order = $request->has('pre_order') ? 1 : 0;
    $prasad->offline_order = $request->has('offline_order') ? 1 : 0;
    $prasad->description = $request->description;

    // Save updated data
    $prasad->save();

    // Redirect back with success message
    return redirect()->back()->with('success', 'Prasad details updated successfully!');
}


public function destroy($id)
{
    $templePrasad = TemplePrasad::findOrFail($id);
    $templePrasad->status = 'deleted';
    $templePrasad->save();  // Delete the main record

    return redirect()->route('templeprasad.manageprasad')->with('success', 'Temple Prasad deleted successfully');
}

}
