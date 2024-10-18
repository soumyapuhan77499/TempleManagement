<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsideTemple;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InsideTempleController extends Controller
{
    //
    public function saveInsideTemple(Request $request)
    {
        // Get the logged-in temple's ID
        $temple_id = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401, // Unauthorized
            ], 401);
        }
    
        // Validate the request data
        $request->validate([
            'inside_temple_name' => 'required|string|max:255',
            'inside_temple_about' => 'nullable|string',
            'inside_temple_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for the image
        ]);
    
        // Initialize the image path
        $insideTempleImage = null;
    
        // Check if an image was uploaded and handle it
        if ($request->hasFile('inside_temple_image')) {
            $image = $request->file('inside_temple_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'assets/temple/inside_temple_image';
    
            // Ensure the directory exists
            if (!file_exists(public_path($imagePath))) {
                mkdir(public_path($imagePath), 0777, true); // Create the directory if it doesn't exist
            }
    
            // Move the uploaded image to the folder
            $image->move(public_path($imagePath), $imageName);
    
            // Set the image path to be saved in the database
            $insideTempleImage = $imagePath . '/' . $imageName;
        }
    
        // Save the form data into the database
        $insideTemple = InsideTemple::create([
            'temple_id' => $temple_id,
            'inside_temple_name' => $request->inside_temple_name,
            'inside_temple_image' => $insideTempleImage,
            'description' => $request->inside_temple_about,
        ]);
    
        // Check if the record was successfully created
        if ($insideTemple) {
            // Generate the full image URL
            $imageUrl = $insideTempleImage ? url($insideTempleImage) : null;
    
            // Return a success JSON response
            return response()->json([
                "status" => 200,
                'message' => 'Inside Temple added successfully.',
                'data' => [
                    'temple_id' => $insideTemple->temple_id,
                    'inside_temple_name' => $insideTemple->inside_temple_name,
                    'inside_temple_image' => $insideTemple->inside_temple_image,
                    'description' => $insideTemple->description,
                    'created_at' => $insideTemple->created_at,
                    'updated_at' => $insideTemple->updated_at,
                    'id' => $insideTemple->id,
                    'image_url' => $imageUrl, // Include the image URL here
                ],
            ]);
        } else {
            // Return an error JSON response if saving fails
            return response()->json([
                "status" => 500,
                'message' => 'Failed to add Inside Temple. Please try again.',
            ], 500); // 500 Internal Server Error
        }
    }
    
    public function manageInsideTemple()
    {
        // Get the logged-in temple's ID
        $temple_id = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401, // Unauthorized
            ], 401);
        }
    
        // Get all records related to this temple that are active
        $insideTemple = InsideTemple::where('temple_id', $temple_id)->where('status', 'active')->get();
    
        // Check if records exist
        if ($insideTemple->isNotEmpty()) {
            // Map the data to include image URL and other necessary fields
            $templeData = $insideTemple->map(function($temple) {
                return [
                    'id' => $temple->id,
                    'temple_id' => $temple->temple_id,
                    'inside_temple_name' => $temple->inside_temple_name,
                    'description' => $temple->description,
                    'inside_temple_image' => $temple->inside_temple_image,
                    'image_url' => $temple->inside_temple_image ? url($temple->inside_temple_image) : null,
                    'created_at' => $temple->created_at,
                    'updated_at' => $temple->updated_at,
                ];
            });
    
            // Return a success response
            return response()->json([
                'status' => 200,
                'message' => 'Inside Temple data retrieved successfully.',
                'data' => $templeData,
            ]);
        } else {
            // Return a response if no data is found
            return response()->json([
                'status' => 404,
                'message' => 'No inside temple data found for this temple.',
            ]);
        }
    }
    
    public function updateInsideTemple(Request $request, $id)
    {
        // Get the logged-in temple's ID
        $temple_id = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401, // Unauthorized
            ], 401);
        }
    
        // Log the incoming request data
        Log::info('Incoming request data:', $request->all());
    
        // Validate the request data
        $request->validate([
            'inside_temple_name' => 'required|string|max:255',
            'inside_temple_about' => 'nullable|string',
            'inside_temple_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            $temple = InsideTemple::findOrFail($id); // Fetch the record by id
    
            // Handle image upload if a new image is provided
            if ($request->hasFile('inside_temple_image')) {
                $image = $request->file('inside_temple_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = 'assets/temple/inside_temple_image';
    
                // Ensure the directory exists
                if (!file_exists(public_path($imagePath))) {
                    mkdir(public_path($imagePath), 0777, true);
                }
    
                // Move the uploaded image to the folder
                $image->move(public_path($imagePath), $imageName);
    
                // Set the new image path
                $temple->inside_temple_image = $imagePath . '/' . $imageName;
            }
    
            // Update other fields
            $temple->inside_temple_name = $request->inside_temple_name;
            $temple->description = $request->inside_temple_about;
            $temple->save();
    
            // Log success message
            Log::info('Inside Temple updated successfully:', ['temple_id' => $temple->id]);
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Inside Temple updated successfully.',
                'data' => [
                    'id' => $temple->id,
                    'temple_id' => $temple->temple_id,
                    'inside_temple_name' => $temple->inside_temple_name,
                    'inside_temple_image' => $temple->inside_temple_image,
                    'image_url' => url($temple->inside_temple_image), // Provide full URL
                    'description' => $temple->description,
                    'updated_at' => $temple->updated_at,
                    'created_at' => $temple->created_at,
                ],
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to update Inside Temple.', ['error' => $e->getMessage()]);
    
            // Return error response if something goes wrong
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update Inside Temple.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function deleteInsideTemple($id)
    {
        // Get the logged-in temple's ID
        $temple_id = Auth::guard('api')->user()->temple_id;
    
        // Check if the user is authenticated
        if (!$temple_id) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401, // Unauthorized
            ], 401);
        }
    
        try {
            // Find the inside temple record by ID
            $temple = InsideTemple::findOrFail($id); // Use findOrFail to throw an error if not found
    
            // Update the status to 'deleted'
            $temple->status = 'deleted';
            $temple->save();
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Inside Temple deleted successfully.',
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to delete Inside Temple.', ['error' => $e->getMessage()]);
    
            // Return error response if something goes wrong
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete Inside Temple.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
