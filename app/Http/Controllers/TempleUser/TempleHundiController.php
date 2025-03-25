<?php

namespace App\Http\Controllers\templeuser;

use App\Http\Controllers\Controller;
use App\Models\HundiCollection;
use App\Models\HundiTransaction;
use App\Models\Hundi;
use App\Models\TempleCommitteeMemberDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TempleHundiController extends Controller
{
    

    public function addHundi(){

        return view('templeuser.add-temple-hundi');

    }

    public function manageHundi(){

        $templeId = Auth::guard('temples')->user()->temple_id;

        $hundiList = Hundi::where('temple_id', $templeId)->where('status', 'active')->get();

        return view('templeuser.manage-temple-hundi', compact('hundiList'));

    }
// save hundi
    public function saveHundi(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'hundi_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Get the authenticated user's temple_id
        $templeId = Auth::guard('temples')->user()->temple_id;

        // Create a new Hundi record
        Hundi::create([
            'temple_id' => $templeId,
            'hundi_name' => $request->input('hundi_name'),
            'description' => $request->input('description'),
        ]);

        // Redirect or return success response
        return redirect()->back()->with('success', 'Hundi has been successfully created.');
    }

    public function editHundi($id)
{
    // Fetch the hundi record by its ID
    $hundi = Hundi::findOrFail($id);

    // Pass the hundi data to the view
    return view('templeuser.edit-temple-hundi', compact('hundi'));
}

public function updateHundi(Request $request, $id)
{
    // Validate the form data
    $request->validate([
        'hundi_name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Find the Hundi by ID and update it
    $hundi = Hundi::findOrFail($id);
    $hundi->hundi_name = $request->hundi_name;
    $hundi->description = $request->description;
    $hundi->save();

    // Redirect back with a success message
    return redirect()->route('templeuser.managehundi')->with('success', 'Hundi updated successfully.');
}

public function deleteHundi($id)
{
    // Find the Hundi by ID
    $hundi = Hundi::findOrFail($id);

    // Update the status to 'deleted' or any status you prefer for soft deletion
    $hundi->status = 'deleted'; // or use a constant if you prefer

    // Save the changes
    $hundi->save();

    // Redirect back with a success message
    return redirect()->route('templeuser.managehundi')->with('success', 'Hundi marked as deleted successfully.');
}

// hundi collection start

public function addHundiCollection(){
        
    $templeId = Auth::guard('temples')->user()->temple_id;

    $hundi_names = Hundi::where('temple_id', $templeId)->where('status', 'active')->get();

    $member_details = TempleCommitteeMemberDetail::where('temple_id', $templeId)->where('status', 'active')->where('type','committeemember')->get();

    return view('templeuser.add-temple-hundi-collection', compact('hundi_names','member_details'));
}

  public function saveHundiCollection(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'hundi_name' => 'required|string|max:255',
        'hundi_open_date' => 'required|date',
        'opened_by' => 'required|string|max:255',
    ]);

    // Get the authenticated user's temple_id
    $templeId = Auth::guard('temples')->user()->temple_id;

    try {
        // Create a new HundiCollection entry
        $hundiCollection = HundiCollection::create([
            'temple_id' => $templeId,
            'hundi_name' => $request->hundi_name,
            'hundi_open_date' => $request->hundi_open_date,
            'present_member' => implode(',', $request->input('present_member', [])),
            'opened_by' => $request->opened_by,
            'collection_amount' => $request->grand_total
        ]);

        // Save the transactions to the HundiTransaction model using the same transaction ID
        $cashTypes = [1, 2, 5, 10, 20, 50, 100, 200, 500, 1000];
        foreach ($cashTypes as $cashType) {
            $numberOfCash = $request->{'cash_' . $cashType};
            if ($numberOfCash > 0) {
                HundiTransaction::create([
                    'temple_id' => $templeId,
                    'collection_id' => $hundiCollection->id,
                    'cash_type' => $cashType,
                    'no_of_cash' => $numberOfCash,
                    'total_amount' => $numberOfCash * $cashType,
                ]);
            }
        }

        // Redirect with a success message
        return redirect()->back()->with('success', 'Hundi collection saved successfully!');

    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error saving Hundi collection: ' . $e->getMessage());

        // Redirect back with an error message
        return redirect()->back()->with('error', 'Failed to save Hundi collection. Please try again.');
    }
}

}
