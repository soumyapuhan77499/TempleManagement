<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleCommittee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class TempleCommitteeController extends Controller
{
    //
    public function addnewcommittee()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Fetch active committee details for the temple
        $committeedetails = TempleCommittee::where('temple_id', $templeId)
            ->where('status', 'active')
            ->whereNull('committee_end_date')
            ->first();
    
        // Check if $committeedetails is null
        if ($committeedetails) {
            // Parse the committee creation date and calculate total days
            $committeeStartDate = Carbon::parse($committeedetails->committee_creation_date);
            $today = Carbon::today();
            $totalDays = $committeeStartDate->diffInDays($today);
        } else {
            // Set default values if no committee is found
            $committeeStartDate = null; // or set to a default value, like Carbon::today()
            $today = Carbon::today();
            $totalDays = 0; // No days counted if no committee is present
        }
    
        return view('templeuser.add-temple-committee', compact('committeedetails', 'committeeStartDate', 'today', 'totalDays'));
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

    public function addcommitteemember(){
        $templeId = Auth::guard('temples')->user()->temple_id;
        $committeedetails = TempleCommittee::where('temple_id', $templeId)
                            ->where('status', 'active')
                            ->whereNull('committee_end_date')
                            ->first();
        return view('templeuser.add-committee-member',compact('committeedetails'));
    }

    public function storecommitteemember(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'trust_name' => 'required|string|max:255',
            'trust_number' => 'required|string|max:255',
            'trust_start_date' => 'required|date',
            'member_name' => 'required|string|max:255',
            'member_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'member_designation' => 'nullable|string|max:255',
            'temple_designation' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'member_contact_no' => 'nullable|string|max:15',
           
            'whatsapp_number' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'hierarchy_position' => 'nullable|integer',
            'trustee_start_date' => 'nullable|date',
            'trustee_end_date' => 'nullable|date',
            'about_member' => 'nullable|string', // `about_member` is not mandatory
        ]);
        // Handle file upload for member photo, if provided
        $memberPhotoPath = null;
        if ($request->hasFile('member_photo')) {
            $memberPhotoPath = $request->file('member_photo')->store('member_photos', 'public');
        }
    
        // Create a new trust member with the validated data
        TempleCommitteeMemberDetail::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id, // Adjust based on your auth logic
            'trust_number' => $request->trust_number, // Assuming trust_id is part of the request
            'member_name' => $request->member_name,
            'member_photo' => $memberPhotoPath,
            'temple_designation' => $request->temple_designation,
            'member_designation' => $request->member_designation,
            'dob' => $request->dob,
            'member_contact_no' => $request->member_contact_no,
            'whatsapp_number' => $request->whatsapp_number,
            'email' => $request->email,
            'about_member' => $request->about_member, // Optional field
           
            'trust_start_date' => $request->trust_start_date,
          
            'status' => 'active', // Assuming new members have active status
        ]);
    
        // Redirect to the route with success message
        return redirect()->route('templeuser.addtrustmember')->with('success', 'Member added successfully.');
    }
    
}
