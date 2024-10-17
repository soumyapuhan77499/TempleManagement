<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleCommittee;
class TempleCommitteeController extends Controller
{
    //
    public function addnewcommittee(){
        return view('templeuser.add-temple-committee');
    }
    public function addsubcommittee(){
        return view('templeuser.add-temple-sub-committee');
    }
    public function saveCommittee(Request $request)
    {
        // Validate the request data
        $request->validate([
            'committee_creation_date' => 'required|date',
            'financial_period' => 'required|string',
        ]);

    
        $committeeId = 'COM' . mt_rand(1000000, 9999999);
        // Save the data into the database
        TempleCommittee::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id,  
            'committee_id' => $committeeId,  
            'committee_creation_date' => $creationDate,
            'financial_period' => $request->input('financial_period'),
            'status' => 'active',  
        ]);

        // Redirect or return success message
        return redirect()->back()->with('success', 'Committee added successfully!');
    }
}
