<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleUser;
use Illuminate\Support\Facades\Auth;

class TempleRegisterController extends Controller
{

    public function registerTemple(Request $request)
{
    // Validate form inputs
    $request->validate([
        'temple_name' => 'required|string|max:255',
        'user_name' => 'required|string|max:255',
        'mobile_no' => 'required|digits:10', // Validate mobile number to be 10 digits
        'temple_address' => 'required|string',
    ]);

    try {
        // Create a new temple record
        $temple = TempleUser::create([
            'temple_id' => 'TEMPLE' . rand(10000, 99999),
            'temple_name' => $request->input('temple_name'),
            'user_name' => $request->input('user_name'),
            'mobile_no' => $request->input('mobile_no'),
            'temple_trust_name' => $request->input('temple_trust_name'),
            'trust_contact_no' => $request->input('trust_contact_no'),
            'temple_address' => $request->input('temple_address'),
        ]);

        // Check if the temple creation returned null
        if (!$temple) {
            return response()->json([
                'error' => 'Temple data not found.'
            ], 404); // Return 404 if temple creation fails or returns null
        }

        // Return success response in JSON format
        return response()->json([
            'message' => 'Temple registered successfully.',
            'temple' => $temple
        ], 200); // 200 for success

    } catch (\Exception $e) {
        // Error handling: Log the error and return a JSON error response
        \Log::error('Error registering temple: ' . $e->getMessage());

        return response()->json([
            'error' => 'An error occurred while registering the temple. Please try again later.'
        ], 500); // 500 for server error
    }
}

}
