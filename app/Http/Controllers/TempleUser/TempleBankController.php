<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankDetails;
use Illuminate\Support\Facades\Auth;


class TempleBankController extends Controller
{
    public function bankdetails(){

        $templeId = Auth::guard('temples')->user()->temple_id;

        $bankdata = BankDetails::where('temple_id', $templeId)->first();
    
        if (!$bankdata) {
            $bankdata = new BankDetails();
            $bankdata->temple_id = $templeId;
        }
    
        return view('templeuser/temple-bank', compact('bankdata'));
    }


    public function savebankdetails(Request $request)
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Validate the incoming request data
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'ifsc_code' => 'required|size:10',
            'acc_holder_name' => 'required|string|max:255',
            'account_no' => 'required|digits_between:10,12',
            'upi_id' => 'required|string|max:255',
        ]);
    
        // Update or create the bank details for the authenticated Pandit
        $bankdata = BankDetails::updateOrCreate(
            ['temple_id' => $templeId],
            $request->all()
        );
    
        // Redirect back with success message upon successful save
        return redirect()->back()->with('success', 'Bank details saved successfully!');
    }
}
