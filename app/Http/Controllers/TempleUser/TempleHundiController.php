<?php

namespace App\Http\Controllers\templeuser;

use App\Http\Controllers\Controller;
use App\Models\HundiCollection;
use App\Models\HundiTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TempleHundiController extends Controller
{
    public function addHundiCollection(){
        return view('templeuser.add-temple-hundi-collection');
    }

  public function saveHundiCollection(Request $request)
{
    // Validate the incoming request data
    $request->validate([
       
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
