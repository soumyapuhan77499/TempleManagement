<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\TempleTrustMemberDetail;

class TrustMemberController extends Controller
{
    public function storeTrustMember(Request $request)
    {
        $temple_id = Auth::guard('api')->user()->temple_id;
        if (!$temple_id) {
            return response()->json(['message' => 'User not authenticated.', 'data' => null, 'status' => 401], 401);
        }
    
        // Validate request
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
            'about_member' => 'nullable|string',
        ]);
    
        $memberPhotoPath = null;
        if ($request->hasFile('member_photo')) {
            $memberPhotoPath = $request->file('member_photo')->store('member_photos', 'public');
        }
    
        $trustMember = TempleTrustMemberDetail::create([
            'temple_id' => $temple_id,
            'member_name' => $request->member_name,
            'member_photo' => $memberPhotoPath,
            'temple_designation' => $request->temple_designation,
            'member_designation' => $request->member_designation,
            'dob' => $request->dob,
            'member_contact_no' => $request->member_contact_no,
            'whatsapp_number' => $request->whatsapp_number,
            'email' => $request->email,
            'about_member' => $request->about_member,
            'status' => 'active',
        ]);
    
        return response()->json(['message' => 'Member added successfully.', 'data' => $trustMember, 'status' => 200], 200);
    }
    public function getTrustMembers()
    {
        $temple_id = Auth::guard('api')->user()->temple_id;
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }
    
        // Fetch and map member data, adding full URL for `member_photo`
        $trustmembers = TempleTrustMemberDetail::where('temple_id', $temple_id)
            ->where('status', 'active')
            ->orderBy('hierarchy_position')
            ->get()
            ->map(function ($member) {
                // Append the base URL to the photo path if it exists
                $member->member_photo = $member->member_photo 
                    ? url('storage/' . $member->member_photo)
                    : null;
                return $member;
            });
    
        return response()->json([
            'message' => 'Trust members retrieved successfully.',
            'data' => $trustmembers,
            'status' => 200,
        ], 200);
    }
    
    public function updateTrustMember(Request $request, $id)
    {
        $temple_id = Auth::guard('api')->user()->temple_id;
        if (!$temple_id) {
            return response()->json(['message' => 'User not authenticated.', 'data' => null, 'status' => 401], 401);
        }
    
        $request->validate([
            'member_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'member_designation' => 'required|string|max:255',
            'temple_designation' => 'required|string|max:255',
            'member_contact_no' => 'required|digits:10',
            'whatsapp_number' => 'required|digits:10',
            'email' => 'nullable|email|max:255',
            'about_member' => 'nullable|string',
            'member_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $trustmember = TempleTrustMemberDetail::where('id', $id)->where('temple_id', $temple_id)->first();
        if (!$trustmember) {
            return response()->json(['message' => 'Trust member not found.', 'data' => null, 'status' => 404], 404);
        }
    
        $trustmember->update($request->except('member_photo'));
    
        if ($request->hasFile('member_photo')) {
            $fileName = time() . '.' . $request->member_photo->extension();
            $request->member_photo->move(public_path('uploads/trustmembers'), $fileName);
            $trustmember->member_photo = 'uploads/trustmembers/' . $fileName;
            $trustmember->save();
        }
    
        return response()->json(['message' => 'Trust member updated successfully.', 'data' => $trustmember, 'status' => 200], 200);
    }
    public function deleteTrustMember($id)
    {
        $temple_id = Auth::guard('api')->user()->temple_id;
        if (!$temple_id) {
            return response()->json(['message' => 'User not authenticated.', 'data' => null, 'status' => 401], 401);
        }
    
        $trustmember = TempleTrustMemberDetail::where('id', $id)->where('temple_id', $temple_id)->first();
        if (!$trustmember) {
            return response()->json(['message' => 'Trust member not found.', 'data' => null, 'status' => 404], 404);
        }
    
        $trustmember->status = 'deleted';
        $trustmember->save();
    
        return response()->json(['message' => 'Trust member deleted successfully.', 'data' => null, 'status' => 200], 200);
    }
                

}
