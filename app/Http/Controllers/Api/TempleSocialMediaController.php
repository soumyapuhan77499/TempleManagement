<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TempleSocialMedia;
use App\Models\TemplePhotosVideos;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TempleSocialMediaController extends Controller
{
    //
    public function socialmedia()
    {
        // Get the logged-in temple's ID
        $temple_id = Auth::guard('api')->user()->temple_id;
    
        // Fetch the temple social media information
        $templeSocialMedia = TempleSocialMedia::where('temple_id', $temple_id)->first();
    
        // Check if social media data exists
        if (!$templeSocialMedia) {
            return response()->json([
                'message' => 'Social media information not found.',
                'data' => null,
                'status' => 200, // Include the status code in the response
            ], 200); // Return 404 Not Found
        }
    
        // Return success response with social media data
        return response()->json([
            'message' => 'Social media information retrieved successfully.',
            'data' => $templeSocialMedia,
            'status' => 200, // Include the status code in the response
        ], 200); // Return 200 OK
    }
    
    public function updateSocialMediaUrls(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'temple_yt_url' => 'nullable|url|max:255',
            'temple_ig_url' => 'nullable|url|max:255',
            'temple_fb_url' => 'nullable|url|max:255',
            'temple_x_url' => 'nullable|url|max:255',
        ]);
    
        // Get the logged-in temple's ID
        $temple_id = Auth::guard('api')->user()->temple_id;
    
        // Update or create the temple's social media data
        $socialMedia = TempleSocialMedia::updateOrCreate(
            ['temple_id' => $temple_id],
            [
                'temple_yt_url' => $validatedData['temple_yt_url'] ?? null,
                'temple_ig_url' => $validatedData['temple_ig_url'] ?? null,
                'temple_fb_url' => $validatedData['temple_fb_url'] ?? null,
                'temple_x_url' => $validatedData['temple_x_url'] ?? null,
                'status' => 1 // Set status to active
            ]
        );
    
        // Return success response
        return response()->json([
            'message' => 'Social media URLs updated successfully!',
            'data' => $socialMedia,
            'status' => 200, // Include the status code in the response
        ], 200); // Return 200 OK
    }
    
    public function getTemplePhotos()
    {
        $temple_id = Auth::guard('api')->user()->temple_id;
    
        // Fetch the temple photos and videos
        $templePhotosVideos = TemplePhotosVideos::where('temple_id', $temple_id)->first();
    
        if (!$templePhotosVideos) {
            return response()->json([
                'message' => 'No photos or videos found for this temple.',
                'data' => [
                    'temple_id' => $temple_id,
                    'temple_images' => [],
                    'temple_videos' => []
                ],
                'status' => 200, // Include the status code in the response
            ], 200); // Return 200 OK
        }
    
        // Generate structured output for images and videos
        $formattedImages = array_map(function ($image) {
            return ['uri' => Storage::url($image)];
        }, $templePhotosVideos->temple_images ?? []);
    
        $formattedVideos = array_map(function ($video) {
            return ['uri' => Storage::url($video)];
        }, $templePhotosVideos->temple_videos ?? []);
    
        // Return the images and videos as a JSON response
        return response()->json([
            'message' => 'Temple photos and videos retrieved successfully.',
            'data' => [
                'temple_id' => $temple_id,
                'temple_images' => $formattedImages, // Array of image URLs formatted
                'temple_videos' => $formattedVideos  // Array of video URLs formatted
            ],
            'status' => 200, // Include the status code in the response
        ], 200); // Return 200 OK
    }
    
    public function updatePhotosvideos(Request $request)
    {
        $temple_id = Auth::guard('api')->user()->temple_id;
    
        // Validate the request to ensure images and videos are files
        $request->validate([
            'temple_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB per image
            'temple_videos.*' => 'mimes:mp4,avi,mov|max:20480', // Max 20MB per video
        ]);
    
        // Fetch the existing photos and videos data for the temple
        $templePhotosVideos = TemplePhotosVideos::where('temple_id', $temple_id)->first();
    
        // Initialize arrays for new images and videos
        $newImages = [];
        $newVideos = [];
    
        // Handle image uploads
        if ($request->hasFile('temple_images')) {
            foreach ($request->file('temple_images') as $image) {
                // Store the file in the 'public/uploads/images' directory and return the path
                $imagePath = $image->store('uploads/images', 'public');
    
                // Debugging output: Log the path of the stored image
                \Log::info("Stored image path: " . $imagePath);
                $newImages[] = $imagePath;  // Save the stored file path
            }
        }
    
        // Handle video uploads
        if ($request->hasFile('temple_videos')) {
            foreach ($request->file('temple_videos') as $video) {
                // Store the file in the 'public/uploads/videos' directory and return the path
                $videoPath = $video->store('uploads/videos', 'public');
    
                // Debugging output: Log the path of the stored video
                \Log::info("Stored video path: " . $videoPath);
                $newVideos[] = $videoPath;  // Save the stored file path
            }
        }
    
        // Get the existing images and videos if available
        $existingImages = $templePhotosVideos->temple_images ?? [];
        $existingVideos = $templePhotosVideos->temple_videos ?? [];
    
        // Merge new uploads with existing ones
        $allImages = array_merge($existingImages, $newImages);
        $allVideos = array_merge($existingVideos, $newVideos);
    
        // Update or create the temple's photos and videos data
        TemplePhotosVideos::updateOrCreate(
            ['temple_id' => $temple_id],
            [
                'temple_images' => $allImages, // Save all images (existing + new)
                'temple_videos' => $allVideos, // Save all videos (existing + new)
            ]
        );
    
        // Generate URLs for images and videos
        $imageUrls = array_map(function($image) {
            return Storage::url($image);
        }, $allImages);
    
        $videoUrls = array_map(function($video) {
            return Storage::url($video);
        }, $allVideos);
    
        // Return success response with URLs
        return response()->json([
            'message' => 'Temple photos and videos added successfully.',
            'data' => [
                'temple_id' => $temple_id,
                'temple_images' => $imageUrls, // Include URLs for all images
                'temple_videos' => $videoUrls, // Include URLs for all videos
            ],
            'status' => 200, // Include the status code in the response
        ], 200); // Return 200 OK
    }
    
    
    
}
