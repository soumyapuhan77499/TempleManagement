<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleCommittee;
use App\Models\TempleCommitteeMemberDetail;

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
        // Check if committee details exist before proceeding
        if (empty($request->committee_id) || empty($request->committee_creation_date) || empty($request->financial_period)) {
            return redirect()->back()->with('error', 'Still committee is not created.');
        }
    
        // Validate the incoming request
        $request->validate([
            'committee_id' => 'required|string|max:255',
            'member_name' => 'required|string|max:255',
            'member_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'member_designation' => 'nullable|string|max:255',
            'temple_designation' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'member_contact_no' => 'nullable|string|max:15',
            'whatsapp_number' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'about_member' => 'nullable|string',
        ]);
    
        // Handle file upload for member photo, if provided
        $memberPhotoPath = null;
        if ($request->hasFile('member_photo')) {
            $memberPhotoPath = $request->file('member_photo')->store('member_photos', 'public');
        }
    
        // Create a new committee member record
        TempleCommitteeMemberDetail::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id,
            'committee_id' => $request->committee_id,
            'member_name' => $request->member_name,
            'member_photo' => $memberPhotoPath,
            'member_designation' => $request->member_designation,
            'temple_designation' => $request->temple_designation,
            'dob' => $request->dob,
            'member_contact_no' => $request->member_contact_no,
            'whatsapp_number' => $request->whatsapp_number,
            'email' => $request->email,
            'about_member' => $request->about_member,
            'committee_creation_date' => $request->committee_creation_date,
            // 'financial_period' => $request->financial_period,
            'status' => 'active'
        ]);
    
        return redirect()->back()->with('success', 'Committee member created successfully.');
    }


    public function mngcommitteehierarchy(){
        $templeId = Auth::guard('temples')->user()->temple_id;

        $committeemembers = TempleCommitteeMemberDetail::where('status', 'active')
                            ->where('temple_id', $templeId)
                            ->whereNull('committee_end_date')
                            ->get(); // Fetch only active trust members for the specific temple
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
        
        return view('templeuser.manage-committee-hierarchy',compact('committeemembers','committeedetails' ,'today', 'totalDays'));
    }

    public function saveCommitteeHierarchyPosition(Request $request, $id)
    {
        $request->validate([
            'hierarchy_position' => 'required|integer',
        ]);

        $trustMember = TempleCommitteeMemberDetail::findOrFail($id);
        $trustMember->hierarchy_position = $request->hierarchy_position;
        $trustMember->save();

        // Return with success message for SweetAlert
        return redirect()->back()->with('success', 'Hierarchy position updated successfully!');
    }


    public function managecommitteemember()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Fetch active trust members for the specific temple, ordered by hierarchy_position
        $committeemembers = TempleCommitteeMemberDetail::where('temple_id', $templeId)
            ->where('status', 'active')
            ->whereNull('committee_end_date')
            ->orderBy('hierarchy_position', 'asc') // Order by hierarchy_position in ascending order
            ->get();

            
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
        return view('templeuser.manage-committee-members', compact('committeemembers','committeedetails','today', 'totalDays'));
    }

    
}
