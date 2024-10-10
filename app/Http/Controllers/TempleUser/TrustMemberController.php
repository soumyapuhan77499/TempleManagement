<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleTrustMemberDetail;
use App\Models\TempleTrustDetail;

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
                'trust_end_date' => $request->trust_end_date,
                'total_day' => $request->total_day,
            ]
        );
        
    
        return redirect()->route('templeuser.addtrustmember')->with('success', 'Temple information updated successfully.');
    }
    
    public function storedata(Request $request)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'member_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_member' => 'nullable|string',
            'member_designation' => 'nullable|string',
            'member_contact_no' => 'nullable|string|max:15',
        ]);

        $memberPhotoPath = null;
        if ($request->hasFile('member_photo')) {
            $memberPhotoPath = $request->file('member_photo')->store('member_photos', 'public');
        }

        TempleTrustMemberDetail::create([
            'temple_id' =>  Auth::guard('temples')->user()->temple_id, // Adjust according to your logic
            'member_name' => $request->member_name,
            'member_photo' => $memberPhotoPath,
            'about_member' => $request->about_member,
            'member_designation' => $request->member_designation,
            'member_contact_no' => $request->member_contact_no,
            'status' => 'active', // or other logic for status
        ]);

        return redirect()->route('templeuser.addtrustmember')->with('success', 'Member added successfully.');
    }
    public function manageTrustMember()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        $trustmembers = TempleTrustMemberDetail::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get(); // Fetch only active trust members for the specific temple
    
        return view('templeuser.manage-trust-members', compact('trustmembers'));
    }
    
    
    public function edit($id) {
        $trustmember = TempleTrustMemberDetail::findOrFail($id); // Find the trust member by ID
        return view('templeuser.edit-trust-member', compact('trustmember')); // Return the edit view with the trust member's data
    }
    
    public function update(Request $request, $id) {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'member_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Assuming photo is optional
            'member_designation' => 'required|string|max:255',
            'member_contact_no' => 'required|digits:10',
            'about_member' => 'nullable|string',
        ]);
    
        $trustmember = TempleTrustMemberDetail::findOrFail($id); // Find trust member by ID
    
        // Update the trust member data
        $trustmember->member_name = $request->member_name;
        $trustmember->member_designation = $request->member_designation;
        $trustmember->member_contact_no = $request->member_contact_no;
        $trustmember->about_member = $request->about_member;
    
        // Handle file upload if a new member photo is uploaded
        if ($request->hasFile('member_photo')) {
            $fileName = time() . '.' . $request->member_photo->extension();
            $request->member_photo->move(public_path('uploads/trustmembers'), $fileName);
            $trustmember->member_photo = 'uploads/trustmembers/' . $fileName;
        }
    
        $trustmember->save(); // Save the updated data
    
        return redirect()->route('templeuser.managetrustmember')->with('success', 'Trust member updated successfully!');
    }
    public function destroy($id) {
        $trustmember = TempleTrustMemberDetail::findOrFail($id); // Find the trust member by ID
        $trustmember->status = 'deactive'; // Change status to 'deactive'
        $trustmember->save(); // Save the updated status
    
        return redirect()->route('templeuser.managetrustmember')->with('success', 'Trust member deleted successfully!');
    }
    public function mnghierarchy(){
        $templeId = Auth::guard('temples')->user()->temple_id;
    
        $trustmembers = TempleTrustMemberDetail::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get(); // Fetch only active trust members for the specific temple
        return view('templeuser.manage-trust-hierarchy',compact('trustmembers'));
    }
    public function searchMembers(Request $request)
    {
        $query = $request->input('member_name');
    
        // Retrieve matching members from the database
        $members = TempleTrustMemberDetail::where('member_name', 'LIKE', '%' . $query . '%')->get();
    
        return response()->json($members);
    }
    
    public function ajaxSearchMember(Request $request)
{
    $searchTerm = $request->input('searchTerm');

    // Query to fetch members whose name matches the search term and return their designation too
    $members = TempleTrustMemberDetail::where('member_name', 'LIKE', '%' . $searchTerm . '%')
                                       ->limit(10) // Optional: limit the number of results
                                       ->get(['member_name', 'designation']); // Fetch only name and designation

    return response()->json($members);
}

}
