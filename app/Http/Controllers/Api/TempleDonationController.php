<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempleDonation;

class TempleDonationController extends Controller
{
    // Store cash donation
    public function storeCashDonation(Request $request)
    {
        $temple_id = Auth::guard('api')->user()->temple_id;

        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }

        // Validate the request
        $validatedData = $request->validate([
            'donated_by' => 'required|string|max:255',
            'donation_amount' => 'required|numeric|min:1',
            'donation_date_time' => 'required|date',
            'phone_number' => 'required|digits:10',
            'address' => 'required|string|max:255',
            'pan_card' => 'nullable|string|max:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
        ]);

        // Generate a unique donation ID
        $donation_id = 'DON' . mt_rand(1000000, 9999999);

        // Create the donation record
        $donation = TempleDonation::create([
            'temple_id' => $temple_id,
            'donation_id' => $donation_id,
            'donated_by' => $request->donated_by,
            'donation_amount' => $request->donation_amount,
            'donation_date_time' => $request->donation_date_time,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'pan_card' => $request->pan_card,
            'type' => 'cash',
            'status' => 'active',
        ]);

        // Return response
        return response()->json([
            'message' => 'Donation added successfully!',
            'data' => $donation,
            'status' => 200,
        ], 200);
    }

    // Manage donations
    public function manageCashDonations()
    {
        $temple_id = Auth::guard('api')->user()->temple_id;

        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }

        // Fetch cash donations for the authenticated temple
        $cashDonations = TempleDonation::where('status', 'active')
            ->where('temple_id', $temple_id)
            ->where('type', 'cash')
            ->get();

        // Return response
        return response()->json([
            'message' => 'Cash donations retrieved successfully!',
            'data' => $cashDonations,
            'status' => 200,
        ], 200);
    }

    // Update donation
    public function updateDonation(Request $request, $id)
    {
        $temple_id = Auth::guard('api')->user()->temple_id;

        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }

        // Validate the request
        $validatedData = $request->validate([
            'donated_by' => 'required|string|max:255',
            'donation_amount' => 'required|numeric|min:1',
            'donation_date_time' => 'required|date',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'address' => 'required|string|max:255',
            'pan_card' => 'nullable|string|max:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
        ]);

        // Find the donation
        $donation = TempleDonation::findOrFail($id);

        // Check if the donation belongs to the authenticated temple
        if ($donation->temple_id != $temple_id) {
            return response()->json([
                'message' => 'Unauthorized action.',
                'data' => null,
                'status' => 403,
            ], 403);
        }

        // Update the donation record
        $donation->update([
            'donated_by' => $request->donated_by,
            'donation_amount' => $request->donation_amount,
            'donation_date_time' => $request->donation_date_time,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'pan_card' => $request->pan_card,
        ]);

        // Return response
        return response()->json([
            'message' => 'Donation updated successfully!',
            'data' => $donation,
            'status' => 200,
        ], 200);
    }

    // Delete donation (mark as deleted)
    public function deleteDonation($id)
    {
        $temple_id = Auth::guard('api')->user()->temple_id;

        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }

        // Find the donation
        $donation = TempleDonation::findOrFail($id);

        // Check if the donation belongs to the authenticated temple
        if ($donation->temple_id != $temple_id) {
            return response()->json([
                'message' => 'Unauthorized action.',
                'data' => null,
                'status' => 403,
            ], 403);
        }

        // Mark the donation as deleted
        $donation->status = 'deleted';
        $donation->save();

        // Return response
        return response()->json([
            'message' => 'Donation deleted successfully!',
            'data' => $donation,
            'status' => 200,
        ], 200);
    }



    // Store an online donation
    public function storeOnlineDonation(Request $request)
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

        // Validate the incoming request data
        $validatedData = $request->validate([
            'donated_by' => 'required|string|max:255',
            'donation_amount' => 'required|numeric|min:1',
            'donation_date_time' => 'required|date',
            'phone_number' => 'required|regex:/^[0-9]{10}$/',
            'address' => 'required|string|max:255',
            'payment_mode' => 'required|string',
            'payment_number' => 'required|string|max:255',
        ]);

        // Create a unique donation ID
        $donation_id = 'DON' . mt_rand(1000000, 9999999);

        // Store the donation
       $donations = TempleDonation::create([
            'temple_id' => $temple_id,
            'donation_id' => $donation_id,
            'donated_by' => $validatedData['donated_by'],
            'donation_amount' => $validatedData['donation_amount'],
            'donation_date_time' => $validatedData['donation_date_time'],
            'phone_number' => $validatedData['phone_number'],
            'address' => $validatedData['address'],
            'payment_mode' => $validatedData['payment_mode'],
            'payment_number' => $validatedData['payment_number'],
            'type' => 'online',
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Donation added successfully!',
            'data' => $donations,
            'status' => 200,
        ], 200);
    }

    // Manage online donations
    public function manageOnlineDonations()
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

        $onlinedonations = TempleDonation::where('status', 'active')
            ->where('temple_id', $temple_id)
            ->where('type', 'online')
            ->get();

        return response()->json([
            'message' => 'Online donations retrieved successfully.',
            'data' => $onlinedonations,
            'status' => 200,
        ], 200);
    }

    // Update online donation
    public function updateDonationOnline(Request $request, $id)
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

        // Validate the incoming request data
        $validatedData = $request->validate([
            'donated_by' => 'required|string|max:255',
            'donation_amount' => 'required|numeric|min:1',
            'donation_date_time' => 'required|date',
            'phone_number' => 'required|regex:/^[0-9]{10}$/',
            'address' => 'required|string|max:255',
            'payment_mode' => 'required|string',
            'payment_number' => 'required|string|max:255',
        ]);

        // Find the donation
        $donation = TempleDonation::findOrFail($id);
        
        // Update the donation
        $donation->update($validatedData);

        return response()->json([
            'message' => 'Donation updated successfully!',
            'data' =>  $donation,
            'status' => 200,
        ], 200);
    }

    // Delete online donation (mark as deleted)
    public function deleteDonationOnline($id)
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

        // Find the donation
        $donation = TempleDonation::findOrFail($id);
        
        // Mark as deleted
        $donation->status = 'deleted';
        $donation->save();

        return response()->json([
            'message' => 'Donation deleted successfully!',
            'data' =>  $donation,
            'status' => 200,
        ], 200);
    }
}
