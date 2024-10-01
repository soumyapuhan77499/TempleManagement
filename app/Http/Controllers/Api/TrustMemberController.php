<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\TempleTrustMemberDetail;

class TrustMemberController extends Controller
{
 

public function storedata(Request $request): JsonResponse
{
    try {
        $memberPhotoPath = null;

        // Check if the request has a file and store it
        if ($request->hasFile('member_photo')) {
            $memberPhotoPath = $request->file('member_photo')->store('member_photos', 'public');
        }

        // Create a new temple trust member
        TempleTrustMemberDetail::create([
            'temple_id' => Auth::guard('api')->user()->temple_id, // Adjust according to your logic
            'member_name' => $request->member_name,
            'member_photo' => $memberPhotoPath,
            'about_member' => $request->about_member,
            'member_designation' => $request->member_designation,
            'member_contact_no' => $request->member_contact_no,
            'status' => 'active', // or other logic for status
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Member added successfully.',
        ], 200);

    } catch (\Exception $e) {
        // Return error response for client errors
        return response()->json([
            'success' => false,
            'message' => 'Client error: ' . $e->getMessage(),
        ], 400);
    } catch (\Throwable $e) {
        // Return error response for server errors
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage(),
        ], 500);
    }
}

}
