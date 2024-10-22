<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleCommittee;
use App\Models\TempleCommitteeMemberDetail;
use App\Models\TempleSubCommittee;

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
        $templeId = Auth::guard('temples')->user()->temple_id;
        $committeeMembers = TempleCommitteeMemberDetail::where('temple_id', $templeId)
        ->where('status', 'active')->get();
        $committeedetails = TempleCommittee::where('temple_id', $templeId)
        ->where('status', 'active')
        ->whereNull('committee_end_date')
        ->first();
        return view('templeuser.add-temple-sub-committee',compact('committeeMembers','committeedetails'));
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
            'status' => 'active',
             'type' => 'committeemember'
        ]);
    
        
        return redirect()->route('templeuser.managecommitteemember')->with('success', 'Committee member created successfully.');

    }


    public function mngcommitteehierarchy(){
        $templeId = Auth::guard('temples')->user()->temple_id;

        $committeemembers = TempleCommitteeMemberDetail::where('status', 'active')
                            ->where('temple_id', $templeId)
                            ->whereNull('committee_end_date')
                            ->where('type','committeemember')
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
            ->where('type','committeemember')
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

    public function editcommittemember($id) {
        $committeemember = TempleCommitteeMemberDetail::findOrFail($id); // Find the trust member by ID
        return view('templeuser.edit-committee-member', compact('committeemember')); // Return the edit view with the trust member's data
    }

    public function updatecommittemember(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'member_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'member_designation' => 'required|string|max:255',
            'temple_designation' => 'required|string|max:255',
            'member_contact_no' => 'required|digits:10',
            'whatsapp_number' => 'required|digits:10',
            'email' => 'nullable|email',
            'about_member' => 'nullable|string',
            'member_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);
    
        // Find the committee member by ID
        $committeemember = TempleCommitteeMemberDetail::findOrFail($id);
    
        // Update the committee member data
        $committeemember->member_name = $request->input('member_name');
        $committeemember->dob = $request->input('dob');
        $committeemember->member_designation = $request->input('member_designation');
        $committeemember->temple_designation = $request->input('temple_designation');
        $committeemember->member_contact_no = $request->input('member_contact_no');
        $committeemember->whatsapp_number = $request->input('whatsapp_number');
        $committeemember->email = $request->input('email');
        $committeemember->about_member = $request->input('about_member');
    
        // Handle file upload for member photo, if provided
        if ($request->hasFile('member_photo')) {
            // Delete the old photo if it exists
            if ($committeemember->member_photo) {
                Storage::disk('public')->delete($committeemember->member_photo);
            }
    
            // Store the new photo and get its path
            $memberPhotoPath = $request->file('member_photo')->store('member_photos', 'public');
    
            // Update the photo path in the database
            $committeemember->member_photo = $memberPhotoPath;
        }
    
        // Save the updated data to the database
        $committeemember->save();
    
        // Redirect with a success message
        return redirect()->route('templeuser.managecommitteemember')->with('success', 'Committee member updated successfully');
    }

    public function destroycommittemember(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'status' => 'required|string|in:Delete,Suspend,Deactivate',
            'reason' => 'required|string|max:255',
        ]);

        // Find the committee member by ID
        $committeemember = TempleCommitteeMemberDetail::findOrFail($id);

        // Update the status and save the reason
        $committeemember->status = $request->input('status');  // Update status
        $committeemember->reason = $request->input('reason');  // Save reason

        // If the status is 'Delete', you can choose to delete the member or mark it as deleted
        if ($request->input('status') == 'Delete') {
            $committeemember->delete();  // Delete the member from the database
        } else {
            $committeemember->save();  // Save the updated status and reason
        }

        // Redirect back with success message
        return redirect()->route('templeuser.managecommitteemember')->with('success', 'Member status updated successfully.');
    }


    public function storeothermember(Request $request)
    {
        
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
            'status' => 'active',
             'type' => 'othermember'
        ]);
    
        
        return redirect()->route('templeuser.addsubcommittee')->with('success', 'Committee member created successfully.');

    }
    public function storesubcommittee(Request $request)
    {
        // Validate the form data
        $request->validate([
            'sub_committee_name' => 'required|string|max:255',
            'members' => 'required|array',
        ]);
    
        // Save data into TempleSubCommittee model
        $templeSubCommittee = new TempleSubCommittee();
        $templeSubCommittee->sub_committee_name = $request->sub_committee_name;
        $templeSubCommittee->committee_id = $request->committee_id; // If this is coming from the form
        $templeSubCommittee->temple_id = Auth::guard('temples')->user()->temple_id;
    
        // Save the committee details
        $templeSubCommittee->save();
    
        // Loop through each member and insert into the pivot table
        foreach ($request->members as $member_id) {
            DB::table('committee_member_temple_subcommittee')->insert([
                'temple_subcommittee_id' => $templeSubCommittee->id, // The ID of the saved committee
                'committee_member_id' => $member_id, // Each member ID gets its own row
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Committee and members have been saved successfully.');
    }
    
    
}
