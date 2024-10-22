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
            'message' => 'Vendor details saved successfully along with bank details.',
            'vendor_id' => $vendorDetails->vendor_id
        ], 201); // HTTP 201 Created

    } catch (\Exception $e) {
       
        // Return error response
        return response()->json([
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
            ], 404); // 404 Not Found
        }

        return response()->json([
            'message' => 'Vendor details fetched successfully',
            'vendor_details' => $vendor_details,
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
    // Validate the request
    $validatedData = $request->validate([
        'vendor_name' => 'required|string|max:255',
        'phone_no' => 'required|numeric',
        'email_id' => 'nullable|email',
        'vendor_category' => 'required|string|max:255',
        'payment_type' => 'nullable|string|max:255',
        'vendor_gst' => 'nullable|string|max:15',
        'vendor_address' => 'nullable|string|max:255',
        'bank_name.*' => 'nullable|string|max:255',
        'account_no.*' => 'nullable|numeric',
        'ifsc_code.*' => 'nullable|string|max:11',
    ]);

    // Find vendor by ID
    $vendor = VendorDetails::findOrFail($id);
    $vendor->update($validatedData);
    $templeId = Auth::guard('api')->user()->temple_id;

    // Handle bank details
    $bankIds = $request->bank_id ?? [];
    foreach ($bankIds as $index => $bankId) {
        $bankData = [
            'temple_id' => $templeId, // Include temple_id
            'bank_name' => $request->bank_name[$index],
            'account_no' => $request->account_no[$index],
            'ifsc_code' => $request->ifsc_code[$index],
            'upi_id' => $request->upi_id[$index],
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
    return response()->json(['message' => 'Vendor details updated successfully!'], 200);
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


            return response()->json(['message' => 'Vendor and associated bank details deleted.'], 200);
        } catch (\Exception $e) {
           

            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    } else {
        return response()->json(['error' => 'Vendor not found.'], 404);
    }
}


}
