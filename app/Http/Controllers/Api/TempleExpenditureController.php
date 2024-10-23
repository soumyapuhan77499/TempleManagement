<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleExpenditure;
use App\Models\VendorDetails;
use Illuminate\Support\Facades\Auth;

class TempleExpenditureController extends Controller
{
    public function saveExpenditure(Request $request)
{
    try {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'Unauthorized. Please log in as a temple user.',
            ], 400); // HTTP 401 Unauthorized
        }
        // Validate the form data
        $request->validate([
            'person_name' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'category_type' => 'required|string',
            'payment_mode' => 'required|string',
            'payment_done_by' => 'required|string|max:255',
            'payment_number' => 'required_if:payment_mode,!=,CASH|string|max:255',
        ]);

        // Generate a random voucher number with 10 characters (capital letters and digits)
        $voucherNumber = strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));

        // Get the authenticated temple ID (assuming you're using the 'templeuser' guard)
        $templeId = $user->temple_id;

        // Create the expenditure record
        $expenditure = TempleExpenditure::create([
            'temple_id' => $templeId,
            'voucher_number' => $voucherNumber,
            'payment_date' => $request->input('payment_date'),
            'amount' => $request->input('amount'),
            'person_name' => $request->input('person_name'),
            'category' => $request->input('category'),
            'category_type' => $request->input('category_type'),
            'payment_mode' => $request->input('payment_mode'),
            'payment_number' => $request->input('payment_number'),
            'payment_done_by' => $request->input('payment_done_by'),
            'payment_description' => $request->input('payment_description'),
        ]);

        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Expenditure recorded successfully',
            'data' => $expenditure
        ], 200); // HTTP 200 OK
    } catch (\Exception $e) {
        // Return error response with 500 status code
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while saving the expenditure',
            'error' => $e->getMessage()
        ], 500); // HTTP 500 Internal Server Error
    }
}

public function manageExpenditure()
{
    try {
        // Get the authenticated temple user's ID
        $user = Auth::guard('api')->user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'Unauthorized. Please log in as a temple user.',
            ], 400); // HTTP 401 Unauthorized
        }

        $templeId = $user->temple_id;

        // Fetch the active expenditures for the temple
        $templeExpenditure = TempleExpenditure::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get();

        // Return success response with the list of expenditures
        return response()->json([
            'status' => 200,
            'message' => 'Temple Expenditure List Retrieved Successfully',
            'data' => $templeExpenditure
        ], 200); // HTTP 200 OK
    } catch (\Exception $e) {
        // Return error response with 500 status code
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while retrieving temple expenditure',
            'error' => $e->getMessage()
        ], 500); // HTTP 500 Internal Server Error
    }
}

public function editExpenditure($id)
{
    try {
        // Find the expenditure by ID
        $expenditure = TempleExpenditure::findOrFail($id);

        // Return success response with expenditure data
        return response()->json([
            'status' => 200,
            'message' => 'Expenditure details retrieved successfully.',
            'data' => $expenditure
        ], 200); // HTTP 200 OK
    } catch (\Exception $e) {
        // Return error response if something goes wrong
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while fetching the expenditure details.',
            'error' => $e->getMessage()
        ], 500); // HTTP 500 Internal Server Error
    }
}


public function updateExpenditure(Request $request, $id)
{
    try {
     
        // Find the expenditure by ID
        $expenditure = TempleExpenditure::findOrFail($id);

        // Update the expenditure record
        $expenditure->update($request->all());

        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Expenditure updated successfully.',
            'data' => $expenditure
        ], 200); // HTTP 200 OK
    } catch (\Exception $e) {
        // Return error response in case of an exception
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while updating the expenditure.',
            'error' => $e->getMessage()
        ], 500); // HTTP 500 Internal Server Error
    }
}

public function deleteExpenditure($id)
{
    try {
        // Find the expenditure record by ID
        $expenditure = TempleExpenditure::find($id);
    
        // Check if the expenditure exists
        if ($expenditure) {
            // Update the status to 'deleted'
            $expenditure->status = 'deleted';
            $expenditure->save();
    
            // Return a success response
            return response()->json([
                'status' => 200,
                'message' => 'Temple Expenditure has been deleted successfully.'
            ], 200); // HTTP 200 OK
        } else {
            // Return error response if the expenditure does not exist
            return response()->json([
                'status' => 400,
                'message' => 'Temple Expenditure not found.'
            ], 400); // HTTP 404 Not Found
        }
    } catch (\Exception $e) {
        // Return error response in case of exception
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while deleting the Temple Expenditure.',
            'error' => $e->getMessage()
        ], 500); // HTTP 500 Internal Server Error
    }
}

public function getVendors()
{
    try {
        // Fetch the authenticated temple user's ID
        $templeId = Auth::guard('api')->user()->temple_id; // Change to 'api' if using API guard
    
        // Fetch vendors from VendorDetails table
        $vendors = VendorDetails::select('vendor_id', 'vendor_name')
                                ->where('temple_id', $templeId)
                                ->where('status', 'active')
                                ->get();
    
        // Return a JSON response with the vendors data
        return response()->json([
            'status' => 200,
            'vendors' => $vendors,
            'message' => 'Vendors fetched successfully.'
        ], 200); // HTTP 200 OK
    } catch (\Exception $e) {
        // Return error response if something goes wrong
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while fetching vendors.',
            'error' => $e->getMessage()
        ], 500); // HTTP 500 Internal Server Error
    }
}
public function printInvoice($id)
{
    try {
        // Fetch the expenditure record by ID
        $expenditure = TempleExpenditure::findOrFail($id);
        
        // Return a success response with the expenditure details
        return response()->json([
            'status' => 200,
            'expenditure' => $expenditure,
            'message' => 'Expenditure invoice fetched successfully.'
        ], 200); // HTTP 200 OK
    } catch (\Exception $e) {
        // Return error response if something goes wrong
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while fetching the invoice.',
            'error' => $e->getMessage()
        ], 500); // HTTP 500 Internal Server Error
    }
}


}
