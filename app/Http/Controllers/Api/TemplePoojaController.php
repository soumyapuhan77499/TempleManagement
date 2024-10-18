<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePooja;
use Illuminate\Support\Facades\Auth;
class TemplePoojaController extends Controller
{
    //
    public function storePooja(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'pooja_name' => 'required|string|max:255',
            'pooja_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pooja_price' => 'required|numeric',
            'pooja_descp' => 'nullable|string',
        ]);

        // Handle file upload and save the image to the 'pooja_images' directory in 'public' storage
        $poojaImagePath = null;
        if ($request->hasFile('pooja_image')) {
            $poojaImagePath = $request->file('pooja_image')->store('pooja_images', 'public');
        }

        try {
            // Save the pooja data
            $pooja = TemplePooja::create([
                'temple_id' => Auth::guard('api')->user()->temple_id, // Assuming temple_id is linked to user
                'pooja_image' => $poojaImagePath,
                'pooja_name' => $validatedData['pooja_name'],
                'pooja_price' => $validatedData['pooja_price'],
                'pooja_descp' => $validatedData['pooja_descp'],
                'status' => 'active',
            ]);

            // Return success response with status code
            return response()->json([
                'status' => 200,
                'message' => 'Pooja added successfully!',
                'data' => $pooja,
            ], 200); // 200 OK status
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add pooja.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }
    public function managePooja()
    {
        // Get the authenticated temple ID using the 'api' guard
        $templeId = Auth::guard('api')->user()->temple_id; 

        try {
            // Fetch active pooja for the current temple
            $poojaList = TemplePooja::where('temple_id', $templeId)
                ->where('status', 'active')
                ->get();

            // Map the pooja list to include full image URLs
            $poojaList = $poojaList->map(function ($pooja) {
                $pooja->pooja_image_url = url('storage/' . $pooja->pooja_image); // Generate full URL for image
                return $pooja;
            });

            // Return the list of poojas as a JSON response
            return response()->json([
                'status' => 200,
                'message' => 'Active pooja retrieved successfully!',
                'data' => $poojaList,
            ], 200); // 200 OK status
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve pooja.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }
        public function updatePooja(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'pooja_name' => 'required|string|max:255',
            'pooja_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pooja_price' => 'required|numeric',
            'pooja_descp' => 'nullable|string',
        ]);

        try {
            // Find the pooja by ID or fail
            $pooja = TemplePooja::findOrFail($id);

            // Handle file upload and save the image to the 'pooja_images' directory in 'public' storage
            $poojaImagePath = $pooja->pooja_image; // Keep the old image if no new one is uploaded
            if ($request->hasFile('pooja_image')) {
                // Store the new image and get its path
                $poojaImagePath = $request->file('pooja_image')->store('pooja_images', 'public');
            }

            // Update pooja data
            $pooja->update([
                'pooja_image' => $poojaImagePath,
                'pooja_name' => $request->pooja_name,
                'pooja_price' => $request->pooja_price,
                'pooja_descp' => $request->pooja_descp,
            ]);

            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'Pooja updated successfully!',
                'data' => $pooja, // You can return the updated pooja details if needed
            ], 200); // 200 OK status
        } catch (\Exception $e) {
            // Handle the error if pooja not found or other issues
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update pooja details.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }



}
