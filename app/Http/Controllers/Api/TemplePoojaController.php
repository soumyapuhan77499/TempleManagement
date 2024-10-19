<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePooja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Make sure to import the Log facade

class TemplePoojaController extends Controller
{
    //
    public function storePoojaAPI(Request $request)
    {
        // Check if the user is authenticated
        $templeId = Auth::guard('api')->user()->temple_id;

    
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }
    
        // Validate the request data
        $validator = \Validator::make($request->all(), [
            'pooja_name' => 'required|string|max:255',
            'pooja_image' => 'required|image|',
            'pooja_price' => 'required|numeric',
            'pooja_descp' => 'nullable|string',
            'inside_temple_id' => 'nullable|integer', // Change to integer if it represents an ID
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors.',
                'errors' => $validator->errors(),
                'status' => 422,
            ], 422);
        }
    
        // Handle file upload and save the image to the 'pooja_images' directory in 'public' storage
        $poojaImagePath = $request->file('pooja_image')->store('pooja_images', 'public');
    
        // Save the pooja data
        $pooja = TemplePooja::create([
            'temple_id' => $templeId,
            'pooja_image' => $poojaImagePath,
            'pooja_name' => $request->pooja_name,
            'pooja_price' => $request->pooja_price,
            'pooja_descp' => $request->pooja_descp,
            'inside_temple_id' => $request->inside_temple_id, // Save the inside temple ID if provided
            'status' => 'active',
        ]);
    
        return response()->json([
            'message' => 'Pooja added successfully!',
            'data' => $pooja,
            'status' => 200,
        ], 201);
    }
    public function managePoojaAPI(Request $request)
    {
        // Check if the user is authenticated
        $templeId = Auth::guard('api')->user()->temple_id;

    
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }
    
        // Fetch active pooja for the current temple
        $poojaList = TemplePooja::where('temple_id', $templeId)
            ->where('status', 'active')
            ->get();
    
        // Map the pooja image URLs
        $poojaList = $poojaList->map(function ($pooja) {
            $pooja->pooja_image_url = asset('storage/' . $pooja->pooja_image); // Map image URL
            return $pooja;
        });
    
        return response()->json([
            'message' => 'Pooja list fetched successfully.',
            'data' => $poojaList,
            'status' => 200,
        ], 200);
    }

    public function updatePooja(Request $request, $id)
    {
        // Log the raw input for debugging
        Log::info('Raw input:', [file_get_contents('php://input')]);
    
        // Authenticate the user
        $templeId = Auth::guard('api')->user()->temple_id; 
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }
    
        // Validate the request
        $request->validate([
            'pooja_name' => 'required|string|max:255',
            'pooja_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pooja_price' => 'required|numeric',
            'pooja_descp' => 'nullable|string',
            'inside_temple_id' => 'nullable|integer',
        ]);
    
        $pooja = TemplePooja::findOrFail($id);
    
        // Handle file upload and save the image
        $poojaImagePath = $pooja->pooja_image; // Keep old image if no new one is uploaded
        if ($request->hasFile('pooja_image')) {
            // Optionally delete the old image here
            if ($pooja->pooja_image) {
                Storage::delete('public/' . $pooja->pooja_image);
            }
            $poojaImagePath = $request->file('pooja_image')->store('pooja_images', 'public');
        }
    
        // Update pooja data
        $pooja->update([
            'pooja_image' => $poojaImagePath,
            'pooja_name' => $request->input('pooja_name'),
            'pooja_price' => $request->input('pooja_price'),
            'pooja_descp' => $request->input('pooja_descp'),
            'inside_temple_id' => $request->input('inside_temple_id'),
        ]);
    
        return response()->json([
            'message' => 'Pooja updated successfully!',
            'data' => $pooja,
            'status' => 200,
        ], 200);
    }

    public function destroyPooja(Request $request, $id)
    {
        // Authenticate the user
        $templeId = Auth::guard('api')->user()->temple_id; 
        if (!$templeId) {
            return response()->json([
                'message' => 'User not authenticated.',
                'data' => null,
                'status' => 401,
            ], 401);
        }

        try {
            // Find the pooja by ID
            $pooja = TemplePooja::findOrFail($id);

            // Update the status to 'deleted'
            $pooja->update(['status' => 'deleted']);

            // Return success response
            return response()->json([
                'message' => 'Pooja deactivated successfully!',
                'data' => $pooja,
                'status' => 200,
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Pooja not found.',
                'data' => null,
                'status' => 404,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deactivating the pooja.',
                'data' => null,
                'status' => 500,
            ], 500);
        }
    }
    
    


}
