<?php

namespace App\Http\Controllers\Api;

use App\Models\TempleCommittee;
use App\Models\TempleCommitteeMemberDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class TempleCommitteeController extends Controller
{
    public function addnewcommittee()
    {
        $templeId = Auth::guard('api')->user()->temple_id;
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }
    
        $committeedetails = TempleCommittee::where('temple_id', $templeId)
            ->where('status', 'active')
            ->whereNull('committee_end_date')
            ->first();
    
        if ($committeedetails) {
            $committeeStartDate = Carbon::parse($committeedetails->committee_creation_date);
            $today = Carbon::today();
            $totalDays = $committeeStartDate->diffInDays($today);
        } else {
            $committeeStartDate = null;
            $today = Carbon::today();
            $totalDays = 0;
        }
    
        return response()->json([
            'status' => 200,
            'data' => compact('committeedetails', 'committeeStartDate', 'today', 'totalDays'),
        ]);
    }
    
    public function saveCommittee(Request $request)
    {
        $templeId = Auth::guard('api')->user()->temple_id;
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }
    
        $request->validate([
            'committee_creation_date' => 'required|date',
            'financial_period' => 'required|string',
        ]);
    
        $activeCommittee = TempleCommittee::where('temple_id', $templeId)
            ->where('status', 'active')
            ->whereNull('committee_end_date')
            ->first();
    
        if ($activeCommittee) {
            return response()->json([
                'status' => 200,
                'message' => 'You have to deactivate the current committee before starting a new one.',
            ]);
        }
    
        $committeeId = 'COM' . mt_rand(1000000, 9999999);
    
        TempleCommittee::create([
            'temple_id' => $templeId,
            'committee_id' => $committeeId,
            'committee_creation_date' => $request->input('committee_creation_date'),
            'financial_period' => $request->input('financial_period'),
            'status' => 'active',
        ]);
    
        return response()->json([
            'status' => 200,
            'message' => 'Committee added successfully!',
        ]);
    }
    

    public function getcommitteemember()
    {
        $templeId = Auth::guard('api')->user()->temple_id;
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }

        $committeedetails = TempleCommittee::where('temple_id', $templeId)
            ->where('status', 'active')
            ->whereNull('committee_end_date')
            ->first();

        return response()->json([
            'status' => 200,
            'committeedetails' => $committeedetails
        ], 200);
    }

    public function storeCommitteeMember(Request $request)
    {
        $request->validate([
            'committee_id' => 'string',
            'committee_creation_date' => 'date',
            'financial_period' => 'string'
        ]);
    
        // Check if committee exists in the database or any other business logic
        if (empty($request->committee_id) || empty($request->committee_creation_date) || empty($request->financial_period)) {
            return response()->json([
                'status' => 200,
                'message' => 'Committee is not yet created.'
            ], 200);
        }

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

        $memberPhotoPath = null;
        if ($request->hasFile('member_photo')) {
            $memberPhotoPath = $request->file('member_photo')->store('member_photos', 'public');
        }

        TempleCommitteeMemberDetail::create([
            'temple_id' => Auth::guard('api')->user()->temple_id,
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
            'status' => 'active',
            'type' => 'committeemember'
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Committee member created successfully.'
        ], 200);
    }


    public function mngcommitteehierarchy()
{
    $templeId = Auth::guard('api')->user()->temple_id;

    $committeemembers = TempleCommitteeMemberDetail::where('status', 'active')
        ->where('temple_id', $templeId)
        ->where('type', 'committeemember')
        ->get();

    $committeedetails = TempleCommittee::where('temple_id', $templeId)
        ->where('status', 'active')
        ->whereNull('committee_end_date')
        ->first();

    return response()->json([
        'status' => 200,
        'data' => compact('committeemembers', 'committeedetails'),
    ]);
}


public function saveCommitteeHierarchyPosition(Request $request, $id)
{
    // Check if the user is authenticated
    $temple_id = Auth::guard('api')->user()->temple_id;
    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    // Validate input
    $request->validate([
        'hierarchy_position' => 'required|integer',
    ]);

    // Find the committee member
    try {
        $trustMember = TempleCommitteeMemberDetail::findOrFail($id);
        $trustMember->hierarchy_position = $request->hierarchy_position;
        $trustMember->save();

        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Hierarchy position updated successfully!',
            'data' => $trustMember
        ], 200);
    } catch (ModelNotFoundException $e) {
        // Return error response if member not found
        return response()->json([
            'status' => 404,
            'message' => 'Committee member not found.',
            'data' => null
        ], 404);
    } catch (\Exception $e) {
        // Return generic error response
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while updating the hierarchy position.',
            'data' => null
        ], 500);
    }
}

public function manageCommitteeMember()
{
    // Check if the user is authenticated
    $temple_id = Auth::guard('api')->user()->temple_id;
    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    try {
        // Fetch active committee members for the temple
        $committeemembers = TempleCommitteeMemberDetail::where('temple_id', $temple_id)
            ->where('status', 'active')
            ->whereNull('committee_end_date')
            ->where('type', 'committeemember')
            ->orderBy('hierarchy_position', 'asc')
            ->get();

        // Fetch committee details for the temple
        $committeedetails = TempleCommittee::where('temple_id', $temple_id)
            ->where('status', 'active')
            ->whereNull('committee_end_date')
            ->first();

        // Calculate total days since committee creation if details exist
        if ($committeedetails) {
            $committeeStartDate = Carbon::parse($committeedetails->committee_creation_date);
            $today = Carbon::today();
            $totalDays = $committeeStartDate->diffInDays($today);
        } else {
            $totalDays = 0; // Default to 0 days if no committee is found
        }

        // Return response with data
        return response()->json([
            'status' => 200,
            'message' => 'Committee members retrieved successfully.',
            'data' => [
                'committeemembers' => $committeemembers,
                'committeedetails' => $committeedetails,
                'totalDays' => $totalDays
            ]
        ], 200);
    } catch (\Exception $e) {
        // Handle any errors that may occur
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while retrieving committee members.',
            'data' => null
        ], 500);
    }
}


    // Additional functions for managing committee members (update, delete, etc.) would follow a similar structure:
    // - Use `$templeId` for authentication
    // - Validate incoming data
    // - Return structured JSON responses with `status` and `message` keys for success/error feedback
}
