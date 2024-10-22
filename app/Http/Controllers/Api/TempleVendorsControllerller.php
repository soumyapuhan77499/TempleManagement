<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorDetails;
use App\Models\VendorBank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TempleVendorsControllerller extends Controller
{
    public function saveVendorDetails(Request $request)
    {
        // Validate the form input
        $request->validate([
            'vendor_name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
        ]);
    
        try {
            // Get the temple_id for the authenticated temple user
            $templeId = Auth::guard('api')->user()->temple_id;

            if (!$templeId) {
                return response()->json([
                    'status' => '400',
                    'message' => 'Invalid Temple ID',
                ], 400); // 400 Client Error
            }
            // Create a new vendor record
            $vendorDetails = new VendorDetails();
            $vendorDetails->temple_id = $templeId;
            $vendorDetails->vendor_id = 'VENDOR' . rand(10000, 99999);
            $vendorDetails->vendor_name = $request->vendor_name;
            $vendorDetails->phone_no = $request->phone_no;
            $vendorDetails->email_id = $request->email_id ?? null; // Use null coalescing to handle optional field
            $vendorDetails->vendor_category = $request->vendor_category ?? null;
            $vendorDetails->payment_type = $request->payment_type ?? null;
            $vendorDetails->vendor_gst = $request->vendor_gst ?? null;
            $vendorDetails->vendor_address = $request->vendor_address ?? null;
    
            // Save the vendor details
            $vendorDetails->save();
    
            // Save multiple bank details if provided
            if (!empty($request->bank_name)) {
                foreach ($request->bank_name as $index => $bankName) {
                    // Check if any of the bank fields for the current index are filled
                    if (!empty($bankName) || !empty($request->account_no[$index]) || !empty($request->ifsc_code[$index])) {
                        $vendorBank = new VendorBank();
                        $vendorBank->temple_id = $templeId;
                        $vendorBank->vendor_id = $vendorDetails->vendor_id;
                        $vendorBank->bank_name = $bankName;
                        $vendorBank->account_no = $request->account_no[$index];
                        $vendorBank->ifsc_code = $request->ifsc_code[$index];
                        $vendorBank->upi_id = $request->upi_id[$index] ?? null;
    
                        // Save the bank details
                        $vendorBank->save();
                    }
                }
            }
    
            // Return success response
            return response()->json([
                'status' => '200',
                'message' => 'Vendor details saved successfully along with bank details.',
                'vendor_id' => $vendorDetails->vendor_id
            ], 200); // HTTP 200 OK
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation error response
            return response()->json([
                'status' => '400',
                'message' => 'Validation error occurred.',
                'errors' => $e->errors()
            ], 400); // HTTP 400 Bad Request
    
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => '500',
                'message' => 'An error occurred while saving vendor details. Please try again.',
                'error' => $e->getMessage()
            ], 500); // HTTP 500 Internal Server Error
        }
    }
    

public function manageVendorDetails()
{
    try {
        $templeId = Auth::guard('api')->user()->temple_id;

        // Check if temple ID is valid
        if (!$templeId) {
            return response()->json([
                'status' => '400',
                'message' => 'Invalid Temple ID',
            ], 400); // 400 Client Error
        }

        // Fetch active vendors with related bank details
        $vendor_details = VendorDetails::where('temple_id', $templeId)
                            ->where('status', 'active')
                            ->with('vendorBanks') // Eager load the related bank details
                            ->get();

        // Check if vendor details exist
        if ($vendor_details->isEmpty()) {
            return response()->json([
                'message' => 'No vendor details found',
                'data' => [],
                'status' => 200
            ], 200); // 404 Not Found
        }

        return response()->json([
            'message' => 'Vendor details fetched successfully',
            'vendor_details' => $vendor_details,
            'status' => 200
        ], 200); // 200 Success
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Server error',
            'error' => $e->getMessage(),
        ], 500); // 500 Server Error
    }
}

public function editVendorDetails($id)
{
    // Find the vendor details along with related bank information
    $vendordetails = VendorDetails::with('vendorBanks')->findOrFail($id);

    // Return a JSON response
    return response()->json($vendordetails);
}

public function updateVendorDetails(Request $request, $id)
{
    try {
        // Find vendor by ID
        $vendor = VendorDetails::findOrFail($id);
        
        // Update vendor details without validation
        $vendor->vendor_name = $request->vendor_name;
        $vendor->phone_no = $request->phone_no;
        $vendor->email_id = $request->email_id ?? null; // Handle optional field
        $vendor->vendor_category = $request->vendor_category ?? null;
        $vendor->payment_type = $request->payment_type ?? null;
        $vendor->vendor_gst = $request->vendor_gst ?? null;
        $vendor->vendor_address = $request->vendor_address ?? null;
        
        // Save the updated vendor details
        $vendor->save();

        $templeId = Auth::guard('api')->user()->temple_id;

        if (!$templeId) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid Temple ID',
            ], 400); // 400 Client Error
        }

        // Handle bank details
        $bankIds = $request->bank_id ?? [];
        foreach ($bankIds as $index => $bankId) {
            $bankData = [
                'temple_id' => $templeId, // Include temple_id
                'bank_name' => $request->bank_name[$index] ?? null,
                'account_no' => $request->account_no[$index] ?? null,
                'ifsc_code' => $request->ifsc_code[$index] ?? null,
                'upi_id' => $request->upi_id[$index] ?? null, // Handle optional field
            ];

            if ($bankId) {
                // Update existing bank detail
                $vendor->vendorBanks()->where('id', $bankId)->update($bankData);
            } else {
                // Create a new bank detail
                $vendor->vendorBanks()->create($bankData);
            }
        }

        // Return a JSON response
        return response()->json([
            'status' => 200,
            'message' => 'Vendor details updated successfully!'
        ], 200); // HTTP 200 OK

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle case where vendor is not found
        return response()->json([
            'status' => 404,
            'message' => 'Vendor not found.',
        ], 404); // HTTP 404 Not Found

    } catch (\Exception $e) {
        // Return error response
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while updating vendor details. Please try again.',
            'error' => $e->getMessage()
        ], 500); // HTTP 500 Internal Server Error
    }
}

public function deleteVendorDetails($id)
{
    // Find the vendor by ID
    $vendor = VendorDetails::find($id);
    
    if ($vendor) {
        // Start a database transaction
        try {
            // Update the status of the vendor to 'deleted'
            $vendor->status = 'deleted';
            $vendor->save();

            // Retrieve all related bank records and update their status to 'deleted'
            $vendorBanks = $vendor->vendorBanks; // Using the relationship defined in the VendorDetails model

            foreach ($vendorBanks as $bank) {
                $bank->status = 'deleted';
                $bank->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Vendor and associated bank details deleted successfully.'
            ], 200); // HTTP 200 OK
        } catch (\Exception $e) {
            // Return server error response
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while deleting the vendor details.',
                'error' => $e->getMessage()
            ], 500); // HTTP 500 Internal Server Error
        }
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'Vendor not found.'
        ], 404); // HTTP 404 Not Found
    }
}



}
