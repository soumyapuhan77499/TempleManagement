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
            'contact_number' => 'nullable|string|max:15',
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
            'status' => 'active', // or other logic for status
        ]);

        return redirect()->route('templeuser.addtrustmember')->with('success', 'Member added successfully.');
    }
}
