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
    // Get the logged-in temple's ID
    $temple_id = Auth::guard('api')->user()->temple_id;

    // Check if the user is authenticated
    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401, // Unauthorized
        ], 401);
    }

    // Validate the request data
    $validatedData = $request->validate([
        'bank_name' => 'required|string|max:255',
        'branch_name' => 'required|string|max:255',
        'account_no' => 'required|string|max:17',
        'ifsc_code' => 'required|string|max:15',
        'acc_holder_name' => 'required|string|max:255',
        'upi_id' => 'nullable|string|max:255'
    ]);

    try {
        // Create a new bank detail entry
        $bankDetails = BankDetails::create([
            'temple_id' => $temple_id,
            'bank_name' => $validatedData['bank_name'],
            'branch_name' => $validatedData['branch_name'],
            'account_no' => $validatedData['account_no'],
            'ifsc_code' => $validatedData['ifsc_code'],
            'acc_holder_name' => $validatedData['acc_holder_name'],
            'upi_id' => $validatedData['upi_id'],
            'status' => 'active',
        ]);

        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Bank details saved successfully!',
            'data' => $bankDetails,
        ], 200);

    } catch (\Exception $e) {
        // Handle exception and return error response
        return response()->json([
            'status' => 500,
            'message' => 'Failed to save bank details.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getBankDetails()
{
    // Get the logged-in temple's ID
    $temple_id = Auth::guard('api')->user()->temple_id;

    // Check if the user is authenticated
    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401, // Unauthorized
        ], 401);
    }

    $bankdata = BankDetails::where('temple_id', $temple_id)->where('status', 'active')->get();

    // Check if there are active bank details
    if ($bankdata->isEmpty()) {
        return response()->json([
            'status' => 200,
            'message' => 'No active bank details found for this temple.',
            'data' => [],
        ], 200);
    }

    // Return success response
    return response()->json([
        'status' => 200,
        'message' => 'Bank details retrieved successfully.',
        'data' => $bankdata,
    ], 200);
}

public function updateBank(Request $request, $id)
{
    // Get the logged-in temple's ID
    $temple_id = Auth::guard('api')->user()->temple_id;

    // Check if the user is authenticated
    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401, // Unauthorized
        ], 401);
    }

    // Validate the request data
    $validatedData = $request->validate([
        'bank_name' => 'required|string|max:255',
        'branch_name' => 'required|string|max:255',
        'account_no' => 'required|string|max:17',
        'ifsc_code' => 'required|string|max:15',
        'acc_holder_name' => 'required|string|max:255',
        'upi_id' => 'nullable|string|max:255'
    ]);

    try {
        // Find the existing bank detail entry by ID
        $bank = BankDetails::find($id);

        // Check if bank details exist
        if (!$bank) {
            return response()->json([
                'status' => 404,
                'message' => 'Bank details not found.',
            ], 404);
        }

        // Update the bank details
        $bank->update([
            'bank_name' => $validatedData['bank_name'],
            'branch_name' => $validatedData['branch_name'],
            'account_no' => $validatedData['account_no'],
            'ifsc_code' => $validatedData['ifsc_code'],
            'acc_holder_name' => $validatedData['acc_holder_name'],
            'upi_id' => $validatedData['upi_id'],
        ]);

        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Bank details updated successfully!',
            'data' => $bank,
        ], 200);

    } catch (\Exception $e) {
        // Handle exception and return error response
        return response()->json([
            'status' => 500,
            'message' => 'Failed to update bank details.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function deleteBank($id)
{
    // Get the logged-in temple's ID
    $temple_id = Auth::guard('api')->user()->temple_id;

    // Check if the user is authenticated
    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401, // Unauthorized
        ], 401);
    }

    try {
        // Find the existing bank detail entry by ID
        $bank = BankDetails::find($id);

        // Check if bank record exists
        if (!$bank) {
            return response()->json([
                'status' => 404,
                'message' => 'Bank record not found.',
            ], 404);
        }

        // Mark the bank record as deleted
        $bank->status = 'deleted';
        $bank->save();

        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Bank record marked as deleted successfully.',
            'data' => $bank,
        ], 200);

    } catch (\Exception $e) {
        // Handle exception and return error response
        return response()->json([
            'status' => 500,
            'message' => 'Failed to delete bank record.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    



}
