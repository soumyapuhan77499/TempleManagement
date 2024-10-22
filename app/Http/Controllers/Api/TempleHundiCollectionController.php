<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hundi;
use App\Models\HundiCollection;
use App\Models\HundiTransaction;
use Illuminate\Support\Facades\Auth;


class TempleHundiCollectionController extends Controller
{
    public function saveHundiCollection(Request $request)
    {
        try {
            // Get the authenticated user's temple_id
            $templeId = Auth::guard('api')->user()->temple_id;
    
            if (!$templeId) {
                // Return a 400 response if temple_id is missing
                return response()->json([
                    'status' => 400,
                    'message' => 'Temple ID not found.',
                ], 400);
            }
    
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
    
            // Return a 200 response on success
            return response()->json([
                'status' => 200,
                'message' => 'Hundi collection saved successfully!',
            ], 200);
    
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error saving Hundi collection: ' . $e->getMessage());
    
            // Return a 500 response for server errors
            return response()->json([
                'status' => 500,
                'message' => 'Failed to save Hundi collection. Please try again.',
            ], 500);
        }
    }
    
    public function hundiList()
    {
        try {
            // Get the authenticated user's temple_id
            $templeId = Auth::guard('api')->user()->temple_id;
    
            // Check if the temple ID is valid
            if (!$templeId) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid temple ID. Please authenticate again.',
                ], 400);
            }
    
            // Retrieve active Hundi records for the authenticated temple
            $hundiList = Hundi::where('temple_id', $templeId)->where('status', 'active')->get();
    
            // Return the Hundi list as a JSON response
            return response()->json([
                'status' => 200,
                'data' => $hundiList,
            ], 200);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error managing Hundi: ' . $e->getMessage());
    
            // Handle server error
            return response()->json([
                'status' => 500,
                'message' => 'Server Error. Please try again later.',
            ], 500);
        }
    }
}
