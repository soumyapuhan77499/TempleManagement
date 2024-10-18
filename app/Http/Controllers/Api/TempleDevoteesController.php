<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDevotee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class TempleDevoteesController extends Controller
{
    //
    public function storedata(Request $request)
    {
        // Get the logged-in temple's ID
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
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string',
            'dob' => 'required|date',
            'photo' => 'required|image|max:2048',
            'gotra' => 'required|string|max:255',
            'rashi' => 'required|string|max:255',
            'nakshatra' => 'nullable|string|max:255',
            'anniversary_date' => 'nullable|date',
            'address' => 'required|string|max:500',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('devotees_photos', 'public');
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Photo is required.',
            ], 400);
        }

        // Save data in the database
        try {
            $devotee =  TempleDevotee::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'dob' => $request->dob,
                'photo' => $photoPath,
                'gotra' => $request->gotra,
                'rashi' => $request->rashi,
                'nakshatra' => $request->nakshatra,
                'anniversary_date' => $request->anniversary_date,
                'address' => $request->address,
                'temple_id' => $temple_id, // Associate with the authenticated temple
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Devotee added successfully.',
                'data' => $devotee,
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to add Devotee.', ['error' => $e->getMessage()]);

            // Return error response if something goes wrong
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add Devotee.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        // Assuming you get the temple_id from the authenticated user
        $temple_id = Auth::guard('api')->user()->temple_id;

        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }

        try {
            // Validate the incoming request
            $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:15',
                'dob' => 'required|date',
                'photo' => 'nullable|image',
                'gotra' => 'required|string|max:255',
                'rashi' => 'required|string|max:255',
                'nakshatra' => 'string|max:255',
                'anniversary_date' => 'nullable|date',
                'address' => 'required|string',
            ]);

            // Find the devotee by ID
            $devotee = TempleDevotee::findOrFail($id);

            // Handle photo upload if a new one is provided
            if ($request->hasFile('photo')) {
                // Delete the old photo if exists
                if ($devotee->photo) {
                    Storage::disk('public')->delete($devotee->photo);
                }
                // Store the new photo
                $photoPath = $request->file('photo')->store('photos', 'public');
                $devotee->photo = $photoPath;
            }

            // Update the devotee's data
            $devotee->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'dob' => $request->dob,
                'gotra' => $request->gotra,
                'rashi' => $request->rashi,
                'nakshatra' => $request->nakshatra,
                'anniversary_date' => $request->anniversary_date,
                'address' => $request->address,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Devotee updated successfully.',
                'data' => $devotee, // Optionally return the updated devotee
            ], 200);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the devotee.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
