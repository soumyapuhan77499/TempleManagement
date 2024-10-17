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
                'temple_id' => Auth::guard('api')->user()->temple_id, // Assuming you are saving the temple_id based on the logged-in user
                'bank_name' => $validatedData['bank_name'],
                'branch_name' => $validatedData['branch_name'],
                'account_no' => $validatedData['account_no'],
                'ifsc_code' => $validatedData['ifsc_code'],
                'acc_holder_name' => $validatedData['acc_holder_name'],
                'upi_id' => $validatedData['upi_id'],
                'status' => 'active', // Assuming the new record will be active by default
            ]);

            // Return success response
            return response()->json([
                'message' => 'Bank details saved successfully!',
                'data' => $bankDetails,
            ], 200);

        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'message' => 'Failed to save bank details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getBankDetails()
    {
        $templeId = Auth::guard('api')->user()->temple_id;
        $bankdata = BankDetails::where('temple_id', $templeId)->where('status', 'active')->get();
        
        if ($bankdata->isEmpty()) {
            return response()->json([
                'message' => 'No active bank details found for this temple.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'Bank details retrieved successfully.',
            'data' => $bankdata,
        ], 200);
    }

    public function updateBank(Request $request, $id)
    {
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

            if (!$bank) {
                return response()->json([
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
                'message' => 'Bank details updated successfully!',
                'data' => $bank,
            ], 200);

        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'message' => 'Failed to update bank details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function deleteBank($id)
    {
        try {
            // Find the existing bank detail entry by ID
            $bank = BankDetails::find($id);

            if (!$bank) {
                return response()->json([
                    'message' => 'Bank record not found.',
                ], 404);
            }

            // Mark the bank record as deleted
            $bank->status = 'deleted';
            $bank->save();

            // Return success response
            return response()->json([
                'message' => 'Bank record marked as deleted successfully.',
                'data' => $bank,
            ], 200);

        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'message' => 'Failed to delete bank record.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



}
