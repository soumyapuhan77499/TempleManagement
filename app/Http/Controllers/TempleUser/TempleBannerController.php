<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleBanner;
use Illuminate\Support\Facades\Auth;

class TempleBannerController extends Controller
{
    //
    public function addbanner(){
        return view('templeuser.add-temple-banner');
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'banner_image' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'banner_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:51200', // max ~50MB
            'banner_type' => 'required|string',
        ]);

        $bannerImagePath = null;
        $bannerVideoPath = null;

        // Store image
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
        }

        // Store video (optional)
        if ($request->hasFile('banner_video')) {
            $bannerVideoPath = $request->file('banner_video')->store('banner_videos', 'public');
        }

        // Save to DB
        TempleBanner::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id,
            'banner_image' => $bannerImagePath,
            'banner_video' => $bannerVideoPath,
            'banner_type' => $request->banner_type,
            'banner_descp' => $request->banner_descp,
        ]);

        return redirect()->route('templebanner.managebanner')->with('success', 'Banner added successfully!');

    }

    // Edit banner
    public function editBanner($id)
    {
        $banner = TempleBanner::findOrFail($id);
        return view('templeuser.edit-banner', compact('banner'));
    }
    
    // Update banner
    public function updateBanner(Request $request, $id)
    {
            $request->validate([
                'banner_image' => 'nullable|file|mimes:jpeg,png,jpg,gif',
                'banner_type' => 'required|string',
            ]);
        
            $banner = TempleBanner::findOrFail($id);
        
            // Update image if provided
            if ($request->hasFile('banner_image')) {
                $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
                $banner->banner_image = $bannerImagePath;
            }

            if ($request->hasFile('banner_video')) {
                $bannerVideoPath = $request->file('banner_video')->store('banner_video', 'public');
                $banner->banner_video = $bannerVideoPath;
            }
        
            // Update other fields
            $banner->banner_type = $request->banner_type;
            $banner->banner_descp = $request->banner_descp;
            $banner->status = 'active'; // Default to active
            $banner->save();
        
            return redirect()->route('templebanner.managebanner')->with('success', 'Banner updated successfully!');
    }

    public function manageBanner()
    {
        // Get the current temple's ID from the authenticated user
        $templeId = Auth::guard('temples')->user()->temple_id;
        
        // Fetch all banners where the temple_id matches and the status is active
        $banners = TempleBanner::where('temple_id', $templeId)
                                ->where('status', 'active')
                                ->get();
        
        // Pass the banners to the view
        return view('templeuser.manage-banner', compact('banners'));
    }

    public function deleteBanner($id)
    {
        $banner = TempleBanner::findOrFail($id);
        
        // Change the status from 'active' to 'deactive'
        $banner->status = 'deleted';
        $banner->save();

        return redirect()->route('templebanner.managebanner')->with('success', 'Banner deactivated successfully!');
    }
    


}
