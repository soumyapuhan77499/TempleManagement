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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'prasad_start_time' => 'required',
            'prasad_start_period' => 'required',
            'prasad_end_time' => 'required',
            'prasad_end_period' => 'required',
            'online_order' => 'nullable',
            'pre_order' => 'nullable',
            'offline_order' => 'nullable',
            'prasad_name' => 'required|array',
            'prasad_price' => 'required|array',
        ]);

        $prasadId = 'PRASAD' . mt_rand(1000000, 9999999);

        try {
            // Save the main temple prasad details in 'temple_prasads' table
            $templePrasad = TemplePrasad::create([
                'temple_id' => Auth::guard('temples')->user()->temple_id,
                'temple_prasad_id' => $prasadId,
                'prasad_start_time' => $request->prasad_start_time,
                'prasad_start_period' => $request->prasad_start_period,
                'prasad_end_time' => $request->prasad_end_time,
                'prasad_end_period' => $request->prasad_end_period,
                'full_prasad_price' => $request->full_prasad_price,
                'online_order' => $request->has('online_order') ? 1 : 0,
                'pre_order' => $request->has('pre_order') ? 1 : 0,
                'offline_order' => $request->has('offline_order') ? 1 : 0,
            ]);

            // Save the additional prasad details in 'temple_prasad_details' table
            foreach ($request->prasad_name as $key => $prasadName) {
                TemplePrasadItem::create([
                    'temple_id' => Auth::guard('temples')->user()->temple_id,
                    'temple_prasad_id' => $templePrasad->temple_prasad_id,
                    'prasad_name' => $prasadName,
                    'prasad_price' => $request->prasad_price[$key],
                ]);
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save prasad details. Please try again.');
        }

        return redirect()->back()->with('success', 'Prasad details have been saved successfully!');
    }

    public function manageprasad()
    {
        // Get the current authenticated temple's ID
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Fetch temple prasad records associated with the current temple's ID
        $templePrasads = TemplePrasad::with('prasadItems')
            ->where('temple_id', $templeId) // Add condition for temple_id
            ->get();
    
        return view('templeuser.manage-temple-prasads', compact('templePrasads'));
    }
    
    public function edit($id)
{
    $templePrasad = TemplePrasad::with('prasadItems')->findOrFail($id);
    return view('templeuser.edit-temple-prasad', compact('templePrasad'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'prasad_start_time' => 'required',
        'prasad_end_time' => 'required',
        'full_prasad_price' => 'required|numeric',
        'prasad_name.*' => 'required',
        'prasad_price.*' => 'required|numeric',
    ]);

    $templePrasad = TemplePrasad::findOrFail($id);
    $templePrasad->update([
        'prasad_start_time' => $request->input('prasad_start_time'),
        'prasad_end_time' => $request->input('prasad_end_time'),
        'full_prasad_price' => $request->input('full_prasad_price'),
        'pre_order' => $request->has('pre_order'),
        'offline_order' => $request->has('offline_order'),
    ]);

    // Delete existing items
    $templePrasad->prasadItems()->delete();

    // Add updated prasad items
    $prasadItems = [];
    foreach ($request->input('prasad_name') as $key => $name) {
        $prasadItems[] = [
            'temple_id' => Auth::guard('temples')->user()->temple_id,

            'prasad_name' => $name,
            'prasad_price' => $request->input('prasad_price')[$key],
        ];
    }
    $templePrasad->prasadItems()->createMany($prasadItems);

    return redirect()->route('templeprasad.manageprasad')->with('success', 'Temple Prasad updated successfully');
}

public function destroy($id)
{
    $templePrasad = TemplePrasad::findOrFail($id);
    $templePrasad->prasadItems()->delete();  // Remove related prasad items
    $templePrasad->delete();  // Delete the main record

    return redirect()->route('templeprasad.manageprasad')->with('success', 'Temple Prasad deleted successfully');
}

}
