<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use App\Models\TempleSocialMedia;
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
     // Update the temple social media information
     public function updateTempleSocialMedia(Request $request, $temple_id)
     {
         // Validate the request
         $validated = $request->validate([
             'temple_images.*' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
             'temple_videos.*' => 'nullable|file|mimes:mp4,avi,mov|max:50000',
             'temple_yt_url' => 'nullable|url',
             'temple_ig_url' => 'nullable|url',
             'temple_fb_url' => 'nullable|url',
             'temple_x_url' => 'nullable|url',
         ]);
 
         // Find the temple social media record or create a new one
         $templeSocialMedia = TempleSocialMedia::updateOrCreate(
             ['temple_id' => $temple_id],
             [
                 'temple_yt_url' => $request->temple_yt_url,
                 'temple_ig_url' => $request->temple_ig_url,
                 'temple_fb_url' => $request->temple_fb_url,
                 'temple_x_url' => $request->temple_x_url,
             ]
         );
 
         // Handle the uploaded images
         if ($request->hasFile('temple_images')) {
             foreach ($request->file('temple_images') as $file) {
                 $path = $file->store('images/temple', 'public');
                 // Save or update the paths in the database
                 // Example: Assuming you have a pivot table or a related model for images
             }
         }
 
         // Handle the uploaded videos
         if ($request->hasFile('temple_videos')) {
             foreach ($request->file('temple_videos') as $file) {
                 $path = $file->store('videos/temple', 'public');
                 // Save or update the paths in the database
                 // Example: Assuming you have a pivot table or a related model for videos
             }
         }
 
         return redirect()->route('temple_social_media.index')->with('success', 'Temple social media information updated successfully.');
     }
}
