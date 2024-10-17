<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use App\Models\TempleSocialMedia;
use App\Models\TemplePhotosVideos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{
    //
    public function socialmedia(){
        $temple_id = Auth::guard('temples')->user()->temple_id;

        // Fetch the temple social media information
        $templeSocialMedia = TempleSocialMedia::where('temple_id', $temple_id)->first();

        return view('templeuser.socialmedia', compact('templeSocialMedia'));
        // return view('templeuser.addsocialmedia');
    }
    public function templephotos(){
        $temple_id = Auth::guard('temples')->user()->temple_id;

        // Fetch the temple social media information
        $templeSocialMedia = TemplePhotosVideos::where('temple_id', $temple_id)->first();

        return view('templeuser.temple-photos', compact('templeSocialMedia'));
        // return view('templeuser.addsocialmedia');
    }

    public function updateSocialMediaUrls(Request $request)
    {
        $temple_id = Auth::guard('temples')->user()->temple_id;

        // Update or create the temple's social media data
        TempleSocialMedia::updateOrCreate(
            ['temple_id' => $temple_id],
            [
                'temple_yt_url' => $request->temple_yt_url,
                'temple_ig_url' => $request->temple_ig_url,
                'temple_fb_url' => $request->temple_fb_url,
                'temple_x_url' => $request->temple_x_url,
                'status' => 1 // Or any other status logic
            ]
        );

        return redirect()->back()->with('success', 'Social media URLs updated successfully');
    }


     // Update the temple social media information
     public function updatePhotosvideos(Request $request)
     {
         $temple_id = Auth::guard('temples')->user()->temple_id;
     
         // Fetch the existing social media data for the temple
         $templeSocialMedia = TemplePhotosVideos::where('temple_id', $temple_id)->first();
     
         // Initialize arrays for new images and videos
         $newImages = [];
         $newVideos = [];
     
         // Handle image uploads
         if ($request->hasFile('temple_images')) {
             foreach ($request->file('temple_images') as $image) {
                 // Store the file in the 'public/uploads/images' directory and return the path
                 $imagePath = $image->store('uploads/images', 'public');
                 $newImages[] = $imagePath;  // Save the stored file path
             }
         }
     
         // Handle video uploads
         if ($request->hasFile('temple_videos')) {
             foreach ($request->file('temple_videos') as $video) {
                 // Store the file in the 'public/uploads/videos' directory and return the path
                 $videoPath = $video->store('uploads/videos', 'public');
                 $newVideos[] = $videoPath;  // Save the stored file path
             }
         }
     
         // Get the existing images and videos if available
         $existingImages = $templeSocialMedia->temple_images ?? [];
         $existingVideos = $templeSocialMedia->temple_videos ?? [];
     
         // Merge new uploads with existing ones
         $allImages = array_merge($existingImages, $newImages);
         
         $allVideos = array_merge($existingVideos, $newVideos);
     
         // Update or create the temple's social media data
         TemplePhotosVideos::updateOrCreate(
             ['temple_id' => $temple_id],
             [
                 'temple_images' => $allImages, // Save all images (existing + new)
                 'temple_videos' => $allVideos, // Save all videos (existing + new)
                
                //  'status' => 1 // Or any other status logic
             ]
         );
     
         return redirect()->back()->with('success', ' Tempel Photos Videos Added Successfully');
     }

   

     
     public function removeMedia(Request $request) {
        \Log::info($request->all()); // Log request data to see what's being passed

        $filePath = $request->filePath;
        $mediaType = $request->mediaType;
    
        // Check if request values are correct
        if (!$filePath || !$mediaType) {
            return response()->json(['success' => false, 'message' => 'Invalid data'], 400);
        }
        $templeSocialMedia = TemplePhotosVideos::where('temple_id', Auth::guard('temples')->user()->temple_id)->first();
    
        if ($mediaType == 'image') {
            $templeSocialMedia->temple_images = array_values(array_diff($templeSocialMedia->temple_images, [$filePath]));
        } elseif ($mediaType == 'video') {
            $templeSocialMedia->temple_videos = array_values(array_diff($templeSocialMedia->temple_videos, [$filePath]));
        }
    
        $templeSocialMedia->save();
    
        // Optionally delete the actual file from the server if desired
        if (file_exists(public_path($filePath))) {
            unlink(public_path($filePath));
        }
    
        return response()->json(['success' => true]);
    }
    
     
}
