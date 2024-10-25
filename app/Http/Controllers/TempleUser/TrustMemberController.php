<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleTrustMemberDetail;
use App\Models\TempleTrustDetail;
use Carbon\Carbon; // Import Carbon for date manipulation
use DB;
use Illuminate\Support\Facades\Auth;

class TrustMemberController extends Controller
{
    //
    public function addtrustmember(){
        $temple_id = Auth::guard('temples')->user()->temple_id;
        $trustDetail = TempleTrustDetail::where('temple_id', $temple_id)->first();
        return view('templeuser.addtrustmember',compact('trustDetail'));
    }
    public function templetruststore(Request $request)
    {
        $request->validate([
            'trust_name' => 'required|string|max:255',
            'trust_number' => 'required|string|max:255',
            'trust_start_date' => 'required|date',
        ]);
        
    
        // Get the authenticated temple user's temple ID
        $temple_id = Auth::guard('temples')->user()->temple_id;
    
        // Find the temple record or create a new one
        $temple = TempleTrustDetail::where('temple_id', $temple_id)->first();
    
 
        // Update or create the temple record
        $temple = TempleTrustDetail::updateOrCreate(
            ['temple_id' => $temple_id],
            [
               'trust_name' => $request->trust_name,
                'trust_number' => $request->trust_number,
                'trust_start_date' => $request->trust_start_date,
              
            ]
        );
        
    
        return redirect()->route('templeuser.addtrustmember')->with('success', 'Temple information updated successfully.');
    }
    
    public function storedata(Request $request)
    {
        // Validate the incoming request
        $request->validate([
           
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

       
        $memberPhotoPath = null;
        if ($request->hasFile('member_photo')) {
            $memberPhotoPath = $request->file('member_photo')->store('member_photos', 'public');
        }
    
        // Create a new trust member with the validated data
        TempleTrustMemberDetail::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id, // Adjust based on your auth logic
           
            'member_name' => $request->member_name,
            'member_photo' => $memberPhotoPath,
            'temple_designation' => $request->temple_designation,
            'member_designation' => $request->member_designation,
            'dob' => $request->dob,
            'member_contact_no' => $request->member_contact_no,
            'whatsapp_number' => $request->whatsapp_number,
            'email' => $request->email,
            'about_member' => $request->about_member, // Optional field
           
         
          
            'status' => 'active', // Assuming new members have active status
        ]);
    
        // Redirect to the route with success message
        return redirect()->route('templeuser.managetrustmember')->with('success', 'Member added successfully.');
    }
    public function saveHierarchyPosition(Request $request, $id)
    {
        $request->validate([
            'hierarchy_position' => 'required|integer',
        ]);

        $trustMember = TempleTrustMemberDetail::findOrFail($id);
        $trustMember->hierarchy_position = $request->hierarchy_position;
        $trustMember->save();

        // Return with success message for SweetAlert
        return redirect()->back()->with('success', 'Hierarchy position updated successfully!');
    }

    public function manageTrustMember()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Fetch active trust members for the specific temple, ordered by hierarchy_position
        $trustmembers = TempleTrustMemberDetail::where('temple_id', $templeId)
            ->where('status', 'active')
            ->orderBy('hierarchy_position')
            ->get();
        return view('templeuser.manage-trust-members', compact('trustmembers'));
    }
    
    
    
    public function edit($id) {
        $trustmember = TempleTrustMemberDetail::findOrFail($id); // Find the trust member by ID
        return view('templeuser.edit-trust-member', compact('trustmember')); // Return the edit view with the trust member's data
    }
    
    public function update(Request $request, $id) {
        // Validate the incoming request
        $request->validate([
            'member_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'member_designation' => 'required|string|max:255',
            'temple_designation' => 'required|string|max:255',
            'member_contact_no' => 'required|digits:10',
            'whatsapp_number' => 'required|digits:10',
            'email' => 'nullable|email|max:255',
            'about_member' => 'nullable|string',
            'member_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Find the trust member by ID
        $trustmember = TempleTrustMemberDetail::findOrFail($id);
    
        // Update the trust member data
        $trustmember->member_name = $request->member_name;
        $trustmember->dob = $request->dob;
        $trustmember->member_designation = $request->member_designation;
        $trustmember->temple_designation = $request->temple_designation;
        $trustmember->member_contact_no = $request->member_contact_no;
        $trustmember->whatsapp_number = $request->whatsapp_number;
        $trustmember->email = $request->email;
        $trustmember->about_member = $request->about_member;
    
        // Handle file upload if a new member photo is uploaded
        if ($request->hasFile('member_photo')) {
            $fileName = time() . '.' . $request->member_photo->extension();
            $request->member_photo->move(public_path('uploads/trustmembers'), $fileName);
            $trustmember->member_photo = 'uploads/trustmembers/' . $fileName;
        }
    
        // Save the updated data
        $trustmember->save();
    
        // Redirect back with success message
        return redirect()->route('templeuser.managetrustmember')->with('success', 'Trust member updated successfully!');
    }
    
    public function destroy($id) {
        $trustmember = TempleTrustMemberDetail::findOrFail($id); // Find the trust member by ID
        $trustmember->status = 'deleted'; // Change status to 'deactive'
        $trustmember->save(); // Save the updated status
    
        return redirect()->route('templeuser.managetrustmember')->with('success', 'Trust member deleted successfully!');
    }
    public function mnghierarchy(){
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        $trustmembers = TempleTrustMemberDetail::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get(); // Fetch only active trust members for the specific temple

        $trustdetails = TempleTrustDetail::where('temple_id', $templeId)
            ->first();
            $trustStartDate = Carbon::parse($trustdetails->trust_start_date);
            $today = Carbon::today();
            $totalDays = $trustStartDate->diffInDays($today);
        return view('templeuser.manage-trust-hierarchy',compact('trustmembers','trustdetails' ,'today', 'totalDays'));
    }

    public function deactivateTrustMembers()
    {
        // Get the temple ID from the authenticated user
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        // Fetch the temple trust detail
        $templeTrust = TempleTrustDetail::where('temple_id', $templeId)->first();
    
        if ($templeTrust) {
            // Get today's date
            $today = Carbon::today();
    
            // Update the trust_end_date to today
            $templeTrust->trust_end_date = $today;
    
            // Calculate total days between trust_start_date and trust_end_date
            $trustStartDate = Carbon::parse($templeTrust->trust_start_date);
            $totalDays = $trustStartDate->diffInDays($today);
    
            // Update total_day and trust_end_date in TempleTrustDetail table
            $templeTrust->total_day = $totalDays;
            $templeTrust->save();
        }
    
        // Update all trust members' status to 'deactive' and set trust_end_date to today's date
        TempleTrustMemberDetail::where('temple_id', $templeId)
            ->where('status', 'active') // Only update active members
            ->update([
                'status' => 'deactive',
                'trust_end_date' => $today
            ]);
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'All trust members have been deactivated, and the trust end date has been updated.');
    }
    
   
    public function saveTrustMemberOrder(Request $request)
    {
        $order = $request->order;
    
        foreach ($order as $item) {
            // Update each member's hierarchy_position based on the new order
            DB::table('temple__trust_member_details')
                ->where('id', $item['id'])
                ->update(['hierarchy_position' => $item['position']]);
        }
    
        return response()->json(['status' => 'success', 'message' => 'Order saved successfully!']);
    }
    
}
