<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleMandapDetail;
use Illuminate\Support\Facades\Auth;
class TempleMandapController extends Controller
{
    public function manageMandap()
    {
        // Get the logged-in temple's ID
        $templeId = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401, // Unauthorized
            ], 401);
        }
    
        try {
            // Fetch only active mandaps for the specific temple
            $mandaps = TempleMandapDetail::where('status', 'active')
                ->where('temple_id', $templeId)
                ->get();
    
            // Return the list of mandaps as a JSON response
            return response()->json([
                'status' => 200,
                'message' => 'Active mandaps retrieved successfully!',
                'data' => $mandaps
            ], 200); // 200 OK status
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve mandaps.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }
    
    public function storeMandap(Request $request)
    {
        // Get the logged-in temple's ID
        $templeId = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401, // Unauthorized
            ], 401);
        }
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'mandap_name' => 'required|string|max:255',
            'mandap_description' => 'required|string',
            'booking_type' => 'required|string',
            'event_name' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
        ]);
    
        try {
            // Create a new mandap detail record with additional fields
            $mandap = TempleMandapDetail::create([
                'temple_id' => $templeId, // Use the correct guard for API
                'mandap_name' => $validatedData['mandap_name'],
                'mandap_description' => $validatedData['mandap_description'],
                'booking_type' => $validatedData['booking_type'],
                'event_name' => $validatedData['event_name'],
                'price_per_day' => $validatedData['price_per_day'],
                'status' => 'active', // Default status
            ]);
    
            // Return success response
            return response()->json([
                'status' => 201,
                'message' => 'Mandap details saved successfully!',
                'data' => $mandap
            ], 201); // 201 Created status
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'status' => 500,
                'message' => 'Failed to save mandap details.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }
    
    public function update(Request $request, $id)
    {
        // Get the logged-in temple's ID
        $templeId = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401, // Unauthorized
            ], 401);
        }
    
        // Validate the incoming request
        $validatedData = $request->validate([
            'mandap_name' => 'required|string|max:255',
            'mandap_description' => 'required|string',
            'booking_type' => 'required|in:day-basis,event-basis',
            'event_name' => 'nullable|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
        ]);
    
        try {
            // Find the mandap by ID or fail
            $mandap = TempleMandapDetail::findOrFail($id);
            
            // Update the mandap with the validated data
            $mandap->update($validatedData);
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Mandap details updated successfully!',
                'data' => $mandap,
            ], 200); // 200 OK status
        } catch (\Exception $e) {
            // Handle the error if mandap not found or other issues
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update mandap details.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }
    
    public function destroy($id)
    {
        // Get the logged-in temple's ID
        $templeId = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401, // Unauthorized
            ], 401);
        }
    
        try {
            // Find the mandap by ID or fail
            $mandap = TempleMandapDetail::findOrFail($id);
            $mandap->status = 'deleted'; // Set status to inactive
            $mandap->save(); // Save the changes
    
            return response()->json([
                'status' => 200,
                'message' => 'Mandap status updated to inactive successfully!',
                'data' => [
                    'id' => $mandap->id,
                    'status' => $mandap->status
                ]
            ], 200); // 200 OK status
        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete mandap.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }
    
    



}
