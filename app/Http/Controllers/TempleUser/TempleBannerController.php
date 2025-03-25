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
            'banner_image' => 'required|file|mimes:jpeg,png,jpg,gif',
            'banner_type' => 'required|string',
        ]);
    
        // Store image
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
        }
    
        // Create a new banner entry
        TempleBanner::create([
            'temple_id' =>  Auth::guard('temples')->user()->temple_id,
            'banner_image' => $bannerImagePath,
            'banner_type' => $request->banner_type,
            'banner_descp' => $request->banner_descp,
            'status' => 'active',
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
