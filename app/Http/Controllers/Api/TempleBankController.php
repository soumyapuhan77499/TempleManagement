<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankDetails;
use Illuminate\Support\Facades\Auth;

class TempleBankController extends Controller
{
    public function saveBankDetails(Request $request)
    {
        try {
            // Retrieve the authenticated temple user ID
            $templeUser = Auth::guard('api')->user();
            
            if (!$templeUser) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            // Get temple ID
            $templeId = $templeUser->temple_id;

            // Extract only the relevant fields from the request
            $requestData = $request->only(['bank_name', 'account_no','acc_holder_name', 'ifsc_code', 'branch_name','upi_id']);

            // Add temple_id to the data
            $requestData['temple_id'] = $templeId;

            // Ensure all fields are present as arrays (avoid passing non-arrays)
            if (!is_array($requestData)) {
                return response()->json([
                    'message' => 'Invalid data provided',
                ], 400);
            }

            // Save or update the bank details for the authenticated temple
            $bankData = BankDetails::updateOrCreate(
                ['temple_id' => $templeId],
                $requestData
            );

            // Return a success response
            return response()->json([
                'message' => 'Bank details saved successfully!',
                'data' => $bankData
            ], 200);

        } catch (\Exception $e) {
            // Return a server error response
            return response()->json([
                'message' => 'Failed to save bank details',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
