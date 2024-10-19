<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleBanner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class TempleBannerController extends Controller
{
    //

    public function storeBanner(Request $request)
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

        // Validate the request
        $request->validate([
            'banner_image' => 'required|file|mimes:jpeg,png,jpg,gif',
            'banner_type' => 'required|string',
        ]);

        try {
            // Store image
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');

            // Create a new banner entry
            $banner = TempleBanner::create([
                'temple_id' => $templeId,
                'banner_image' => $bannerImagePath,
                'banner_type' => $request->banner_type,
                'banner_descp' => $request->banner_descp, // Optional
                'status' => 'active',
            ]);

            // Return success response
            return response()->json([
                'message' => 'Banner added successfully!',
                'data' => $banner,
                'status' => 200,
            ], 200);
            
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                'message' => 'An error occurred while adding the banner.',
                'data' => null,
                'status' => 500,
            ], 500);
        }
    }
    public function manageBanner(Request $request)
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
            // Fetch all active banners for the authenticated temple
            $banners = TempleBanner::where('temple_id', $templeId)
                                    ->where('status', 'active')
                                    ->get();
    
            // Map the banner images to their public URLs
            $banners->transform(function($banner) {
                $banner->banner_image = $banner->banner_image 
                    ? url(Storage::url($banner->banner_image)) 
                    : null; // Map to public URL or null if no image
                return $banner;
            });
    
            // Return success response with banners
            return response()->json([
                'message' => 'Banners retrieved successfully.',
                'data' => $banners,
                'status' => 200,
            ], 200);
            
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json([
                'message' => 'An error occurred while retrieving banners.',
                'data' => null,
                'status' => 500,
            ], 500);
        }
    }
    public function deleteBanner(Request $request, $id)
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
            // Find the banner by ID
            $banner = TempleBanner::findOrFail($id);
            
            // Change the status from 'active' to 'deleted'
            $banner->status = 'deleted';
            $banner->save();

            // Return success response
            return response()->json([
                'message' => 'Banner Deleted successfully!',
              
                'status' => 200,
            ], 200);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle case where banner is not found
            return response()->json([
                'message' => 'Banner not found.',
                'data' => null,
                'status' => 404,
            ], 404);
            
        } catch (\Exception $e) {
            // Handle any other exceptions
            return response()->json([
                'message' => 'An error occurred while deactivating the banner.',
                'data' => null,
                'status' => 500,
            ], 500);
        }
    }
    public function updateBanner(Request $request, $id)
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

    // Validate the request data
    $request->validate([
        'banner_image' => 'nullable|file|mimes:jpeg,png,jpg,gif',
        'banner_type' => 'required|string',
    ]);

    try {
        // Find the banner by ID
        $banner = TempleBanner::findOrFail($id);

        // Update image if provided
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
            $banner->banner_image = $bannerImagePath;
        }

        // Update other fields
        $banner->banner_type = $request->input('banner_type');
        $banner->banner_descp = $request->input('banner_descp'); // Ensure this is allowed in the request
        $banner->status = 'active'; // Default to active
        $banner->save();

        // Return success response
        return response()->json([
            'message' => 'Banner updated successfully!',
            'data' => $banner, // Return updated banner details
            'status' => 200,
        ], 200);
        
    } catch (ModelNotFoundException $e) {
        // Handle case where banner is not found
        return response()->json([
            'message' => 'Banner not found.',
            'data' => null,
            'status' => 404,
        ], 404);
        
    } catch (\Exception $e) {
        // Handle any other exceptions
        return response()->json([
            'message' => 'An error occurred while updating the banner.',
            'data' => null,
            'status' => 500,
        ], 500);
    }
}
}
