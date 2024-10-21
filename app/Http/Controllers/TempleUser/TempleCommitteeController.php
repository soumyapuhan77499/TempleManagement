<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleCommittee;
use Illuminate\Support\Facades\Auth;

class TempleCommitteeController extends Controller
{
    //
    public function addnewcommittee(){
        $templeId = Auth::guard('temples')->user()->temple_id;
        $committeedetails = TempleCommittee::where('temple_id', $templeId)->first();
        $committeeStartDate = Carbon::parse($committeedetails->committee_creation_date);
        $today = Carbon::today();
        $totalDays = $committeeStartDate->diffInDays($today);


        return view('templeuser.add-temple-committee',compact('committeedetails','committeeStartDate','today', 'totalDays'));
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
    
        // Check if there is an active committee with no end date for the current temple
        $activeCommittee = TempleCommittee::where('temple_id', Auth::guard('temples')->user()->temple_id)
            ->where('status', 'active')
            ->whereNull('committee_end_date')
            ->first();
    
        // If an active committee exists without an end date, display a SweetAlert message
        if ($activeCommittee) {
            return redirect()->back()->with('error', 'You have to deactivate the current committee before starting a new one.');
        }
    
        // Generate a unique committee ID
        $committeeId = 'COM' . mt_rand(1000000, 9999999);
    
        // Save the new committee data into the database
        TempleCommittee::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id,  
            'committee_id' => $committeeId,  
            'committee_creation_date' => $request->input('committee_creation_date'),
            'financial_period' => $request->input('financial_period'),
            'status' => 'active',  
        ]);
    
        // Redirect or return success message
        return redirect()->back()->with('success', 'Committee added successfully!');
    }
    
}
