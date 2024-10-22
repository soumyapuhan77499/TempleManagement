<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hundi;
use Illuminate\Support\Facades\Auth;

class TempleHundiController extends Controller
{
    public function saveHundi(Request $request)
    {
        try {
            // Get the authenticated user's temple_id
            $templeId = Auth::guard('api')->user()->temple_id;
    
            // Check if the temple ID is valid
            if (!$templeId) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid temple ID. Please authenticate again.',
                ], 400);
            }
    
            // Create a new Hundi record
            Hundi::create([
                'temple_id' => $templeId,
                'hundi_name' => $request->input('hundi_name'),
                'description' => $request->input('description'),
            ]);
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Hundi has been successfully created.',
            ], 200);
    
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating Hundi: ' . $e->getMessage());
    
            // Handle server error
            return response()->json([
                'status' => 500,
                'message' => 'Server Error. Please try again later.',
            ], 500);
        }
    }
    
    public function manageHundi()
    {
        try {
            // Get the authenticated user's temple_id
            $templeId = Auth::guard('api')->user()->temple_id;
    
            // Check if the temple ID is valid
            if (!$templeId) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Invalid temple ID. Please authenticate again.',
                ], 400);
            }
    
            // Retrieve active Hundi records for the authenticated temple
            $hundiList = Hundi::where('temple_id', $templeId)->where('status', 'active')->get();
    
            // Return the Hundi list as a JSON response
            return response()->json([
                'status' => 200,
                'data' => $hundiList,
            ], 200);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error managing Hundi: ' . $e->getMessage());
    
            // Handle server error
            return response()->json([
                'status' => 500,
                'message' => 'Server Error. Please try again later.',
            ], 500);
        }
    }
    
    public function updateHundi(Request $request, $id)
    {
        try {
            // Find the Hundi by ID
            $hundi = Hundi::findOrFail($id);
    
            // Check if Hundi name is provided
            if (!$request->has('hundi_name')) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Hundi name is required.',
                ], 400);
            }
    
            // Update the Hundi details
            $hundi->hundi_name = $request->hundi_name;
            $hundi->description = $request->description ?? null;
            $hundi->save();
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Hundi updated successfully.',
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If the Hundi ID is not found, return 400 error
            return response()->json([
                'status' => 400,
                'message' => 'Hundi not found.',
            ], 400);
        } catch (\Exception $e) {
            // Log the error and return 500 error for server issues
            \Log::error('Error updating Hundi: ' . $e->getMessage());
    
            return response()->json([
                'status' => 500,
                'message' => 'Server Error. Please try again later.',
            ], 500);
        }
    }
    
    public function deleteHundi($id)
    {
        try {
            // Find the Hundi by ID
            $hundi = Hundi::findOrFail($id);
    
            // Soft delete the Hundi by updating the status
            $hundi->status = 'deleted'; // Or use a constant for status
    
            // Save the changes
            $hundi->save();
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Hundi marked as deleted successfully.',
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle Hundi not found error
            return response()->json([
                'status' => 400,
                'message' => 'Hundi not found.',
            ], 400);
    
        } catch (\Exception $e) {
            // Handle server error and log it
            \Log::error('Error deleting Hundi: ' . $e->getMessage());
    
            return response()->json([
                'status' => 500,
                'message' => 'Server Error. Please try again later.',
            ], 500);
        }
    }
        

}
