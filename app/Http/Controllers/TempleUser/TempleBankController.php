<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankDetails;
use Illuminate\Support\Facades\Auth;


class TempleBankController extends Controller
{

    public function addbank(){
        return view('templeuser/add-temple-bank');
    }

    public function managebank()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
        $bankdata = BankDetails::where('temple_id', $templeId)->where('status','active')->get(); // Use get() to retrieve multiple records
        return view('templeuser/manage-temple-bank', compact('bankdata'));
    }
    

    public function savebank(Request $request)
    {
        // Validate the request data
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'account_no' => 'required|string|max:17',
            'ifsc_code' => 'required|string|max:15',
            'acc_holder_name' => 'required|string|max:255',
            'upi_id' => 'nullable|string|max:255'
        ]);

        // Create a new bank detail entry
        BankDetails::create([
            'temple_id' => auth()->user()->temple_id, // Assuming you are saving the temple_id based on the logged-in user
            'bank_name' => $request->input('bank_name'),
            'branch_name' => $request->input('branch_name'),
            'account_no' => $request->input('account_no'),
            'ifsc_code' => $request->input('ifsc_code'),
            'acc_holder_name' => $request->input('acc_holder_name'),
            'upi_id' => $request->input('upi_id')
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Bank details saved successfully!');
    }

    public function deletebank($id)
{
    $bank = BankDetails::find($id);
    if ($bank) {
        $bank->status = 'deleted';
        $bank->save();
        return redirect()->back()->with('success', 'Bank record marked as deleted successfully.');
    } else {
        return redirect()->back()->with('danger', 'Bank record not found.');
    }
}

public function editbank($id)
{
    $bank = BankDetails::findOrFail($id);
    return view('templeuser.edit-temple-bank', compact('bank')); // Create this blade view for editing
}


public function updateBank(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'bank_name' => 'required|string|max:255',
        'branch_name' => 'required|string|max:255',
        'account_no' => 'required|string|max:17',
        'ifsc_code' => 'required|string|max:15',
        'acc_holder_name' => 'required|string|max:255',
        'upi_id' => 'nullable|string|max:255'
    ]);

    // Find the existing bank detail entry by ID
    $bank = BankDetails::find($id);

    if (!$bank) {
        return redirect()->back()->with('danger', 'Bank details not found.');
    }

    // Update the bank details
    $bank->update([
        'bank_name' => $request->input('bank_name'),
        'branch_name' => $request->input('branch_name'),
        'account_no' => $request->input('account_no'),
        'ifsc_code' => $request->input('ifsc_code'),
        'acc_holder_name' => $request->input('acc_holder_name'),
        'upi_id' => $request->input('upi_id')
    ]);

    // Redirect back with a success message
    return redirect()->route('templeuser.managebank')->with('success', 'Bank details updated successfully!');
}

}
