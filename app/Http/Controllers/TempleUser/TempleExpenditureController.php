<?php

namespace App\Http\Controllers\templeuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleExpenditure;
use App\Models\VendorDetails;
use Illuminate\Support\Facades\Auth;

class TempleExpenditureController extends Controller
{
    public function addExpenditure(){
        return view('templeuser/add-expenditure');
    }

    public function getVendors() {
        $templeId = Auth::guard('temples')->user()->temple_id;

        // Fetch vendors from VendorDetails table
        $vendors = VendorDetails::select('vendor_id', 'vendor_name')->where('temple_id',$templeId)->where('status','active')->get();
    
        // Return a JSON response
        return response()->json($vendors);
    }
    
    public function saveExpenditure(Request $request)
    {
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
        $templeId = Auth::guard('api')->user()->temple_id;

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

        // Redirect or return a success response
        return redirect()->route('templeuser.manageexpenditure')->with('success', 'Expenditure recorded successfully.');
    }

    public function printInvoice($id)
    {
        $expenditure = TempleExpenditure::findOrFail($id);
        return view('templeuser.print_invoice', compact('expenditure'));
    }

    public function manageExpenditure(){
        $templeId = Auth::guard('temples')->user()->temple_id;

        $templeExpenditure = TempleExpenditure::where('status','active')->where('temple_id',$templeId)->get(); // Assuming relation with Vendor
        return view('templeuser.manage-temple-expenditure', compact('templeExpenditure'));

    }
    

    public function updateExpenditure(Request $request, $id)
    {
        $request->validate([
            'person_name' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'category_type' => 'required|string',
            'payment_mode' => 'required|string',
            'payment_number' => 'required|string',
            'payment_done_by' => 'required|string|max:255',
            'payment_description' => 'nullable|string',
        ]);
    
        $expenditure = TempleExpenditure::findOrFail($id);
        $expenditure->update($request->all());
    
        return redirect()->route('templeuser.manageexpenditure')->with('success', 'Expenditure updated successfully.');
    }

    public function deleteExpenditure($id)
    {
        // Find the expenditure record by ID
        $expenditure = TempleExpenditure::find($id);
    
        // Check if the expenditure exists
        if ($expenditure) {
            // Update the status to 'deleted'
            $expenditure->status = 'deleted';
            $expenditure->save();
    
            // Return success response or redirect with a success message
            return redirect()->back()->with('success', 'Temple Expenditure has been deleted successfully.');
        } else {
            // Return error response if the expenditure does not exist
            return redirect()->back()->with('danger', 'Temple Expenditure not found.');
        }
    }
    
    
    
}
