<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleTrustMemberDetail;
use Illuminate\Support\Facades\Auth;

class TrustMemberController extends Controller
{
    //
    public function addtrustmember(){
        return view('templeuser.addtrustmember');
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
    
        
    
}
