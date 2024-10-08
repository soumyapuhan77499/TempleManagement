<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorDetails;
use App\Models\VendorBank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TempleVendorController extends Controller
{
    public function addVendorDetails(){
        return view("templeuser/add-temple-vendors");
    }

    public function saveVendorDetails(Request $request)
    {
         // Validate the form input
        $request->validate([
            'venodr_name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
          
        ]);
    
        // Get the temple_id for the authenticated temple user
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Create a new vendor record
        $vendorDetails = new VendorDetails();
        $vendorDetails->temple_id = $templeId;
        $vendorDetails->vendor_id = 'VENDOR' . rand(10000, 99999);
        $vendorDetails->vendor_name = $request->vendor_name;
        $vendorDetails->phone_no = $request->phone_no;
        $vendorDetails->email_id = $request->email_id;
        $vendorDetails->vendor_category = $request->vendor_category;
        $vendorDetails->payment_type = $request->payment_type;
        $vendorDetails->vendor_gst = $request->vendor_gst;
        $vendorDetails->vendor_address = $request->vendor_address;
        $vendorDetails->upi_id = $request->upi_id;
        // Save the vendor details
        $vendorDetails->save();
    
        // Save multiple bank details if provided
        if (!empty($request->bank_name)) {
            foreach ($request->bank_name as $index => $bankName) {
                // Check if any of the bank fields for the current index are filled
                if (!empty($bankName) || !empty($request->account_no[$index]) || !empty($request->ifsc_code[$index]) || !empty($request->upi_id[$index])) {
                    $vendorBank = new VendorBank();
                    $vendorBank->temple_id = $templeId;
                    $vendorBank->vendor_id = $vendorDetails->vendor_id;
                    $vendorBank->bank_name = $bankName;
                    $vendorBank->account_no = $request->account_no[$index];
                    $vendorBank->ifsc_code = $request->ifsc_code[$index];
                    // Save the bank details
                    $vendorBank->save();
                }
            }
        }
    
        // Redirect or return success response
        return redirect()->route('templeuser.addvendor')->with('success', 'Vendor details saved successfully along with bank details.');
    }

    public function manageVendorDetails()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Fetch active vendors with related bank details
        $vendor_details = VendorDetails::where('temple_id', $templeId)
                            ->where('status', 'active')
                            ->with('vendorBanks') // Eager load the related bank details
                            ->get();
    
        return view('templeuser.manage-temple-vendors', compact('vendor_details'));
    }

    public function deleteVendorDetails($id)
    {
    // Find the vendor by ID
    $vendor = VendorDetails::find($id);
    
    if ($vendor) {
        // Start a database transaction
        \DB::beginTransaction();

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

            // Commit the transaction
            \DB::commit();

            return redirect()->back()->with('success', 'Vendor and associated bank details deleted.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            \DB::rollback();

            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    } else {
        return redirect()->back()->with('error', 'Vendor not found.');
    }
    }

    public function editVendorDetails($id)
    {
        $vendordetails = VendorDetails::with('vendorBanks')->findOrFail($id);
        return view('templeuser.edit-temple-vendor', compact('vendordetails'));
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
            'upi_id' => 'nullable|string|max:255',
            'vendor_address' => 'nullable|string|max:255',
            'bank_name.*' => 'nullable|string|max:255',
            'account_no.*' => 'nullable|numeric',
            'ifsc_code.*' => 'nullable|string|max:11',

        ]);
    
        // Find vendor by ID
        $vendor = VendorDetails::findOrFail($id);
        $vendor->update($validatedData);
        $templeId = Auth::guard('temples')->user()->temple_id;

        // Handle bank details
        $bankIds = $request->bank_id ?? [];
        foreach ($bankIds as $index => $bankId) {
            $bankData = [
                'temple_id' => $templeId, // Include temple_id
                'bank_name' => $request->bank_name[$index],
                'account_no' => $request->account_no[$index],
                'ifsc_code' => $request->ifsc_code[$index],
            ];
    
            if ($bankId) {
                // Update existing bank detail
                $vendor->vendorBanks()->where('id', $bankId)->update($bankData);
            } else {
                // Create a new bank detail
                $vendor->vendorBanks()->create($bankData);
            }
        }
    
        // Set flash message and redirect
        return redirect()->route('templeuser.managevendor')->with('success', 'Vendor details updated successfully!');
    }
    
    
}
