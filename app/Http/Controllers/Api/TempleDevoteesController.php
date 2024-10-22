<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDevotee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
            'photo' => 'image|max:2048',
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
        // Get the temple_id from the authenticated user
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
            // Log the incoming request data for debugging
            \Log::info('Update Request Data:', $request->all());
    
            // Validate the incoming request
           
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
                'name' => $request->input('name'),
                'phone_number' => $request->input('phone_number'),
                'dob' => $request->input('dob'),
                'gotra' => $request->input('gotra'),
                'rashi' => $request->input('rashi'),
                'nakshatra' => $request->input('nakshatra'),
                'anniversary_date' => $request->input('anniversary_date'),
                'address' => $request->input('address'),
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Devotee updated successfully.',
                'data' => $devotee,
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

    public function ManageDevotees()
    {
        // Get the authenticated temple ID
        $templeId = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }
    
        // Retrieve active devotees for the authenticated temple
        $devotees = TempleDevotee::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get()
            ->map(function($devotee) {
                // Prepend the full URL to the photo field
                $devotee->photo = url('storage/' . $devotee->photo);
                return $devotee;
            });
    
        // Return the devotees in JSON format
        return response()->json([
            'message' => 'Active devotees retrieved successfully.',
            'data' => $devotees,
            'status' => 200,
        ], 200);
    }
    
    public function destroy($id)
{
    // Get the authenticated temple ID
    $templeId = Auth::guard('api')->user()->temple_id;

    // Check if the user is authenticated
    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    try {
        // Find the devotee by ID
        $devotee = TempleDevotee::where('id', $id)
            ->where('temple_id', $templeId) // Ensure devotee belongs to the authenticated temple
            ->firstOrFail();

        // Check if the devotee is already deleted
        if ($devotee->status === 'deleted') {
            return response()->json([
                'message' => 'Devotee is already deleted.',
                'status' => 400
            ], 400);
        }

        // Update the status to 'deleted'
        $devotee->status = 'deleted';
        $devotee->save();

        // Return success response
        return response()->json([
            'message' => 'Devotee deleted successfully!',
            'status' => 200,
            'data' => $devotee
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error deleting devotee.',
            'status' => 500,
            'error' => $e->getMessage()
        ], 500);
    }
}


    

}
