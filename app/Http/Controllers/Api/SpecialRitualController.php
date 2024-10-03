<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpecialRitual;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SpecialRitualController extends Controller
{
    public function apiSaveSpecialRitual(Request $request)
{
    try {
        // Get temple_id from authenticated temple user
        $templeId = Auth::guard('api')->user()->temple_id;

        // Initialize new SpecialRitual model
        $ritual = new SpecialRitual();
        $ritual->temple_id = $templeId; // Assuming temple_id is linked to the authenticated user
        $ritual->spcl_ritual_name = $request->spcl_ritual_name;
        $ritual->spcl_ritual_date = $request->spcl_ritual_date;
        $ritual->spcl_ritual_time = $request->spcl_ritual_time;
        $ritual->spcl_ritual_period = $request->spcl_ritual_period;
        $ritual->spcl_ritual_tithi = $request->spcl_ritual_tithi;
        $ritual->description = $request->description;

        // Handle image upload if present
        if ($request->hasFile('spcl_ritual_image')) {
            $image = $request->file('spcl_ritual_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/temple/special_ritual_images'), $imageName);
            $ritual->spcl_ritual_image = 'assets/temple/special_ritual_images/' . $imageName;
        }

        // Handle video upload if present
        if ($request->hasFile('spcl_ritual_video')) {
            $video = $request->file('spcl_ritual_video');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('assets/temple/special_ritual_videos'), $videoName);
            $ritual->spcl_ritual_video = 'assets/temple/special_ritual_videos/' . $videoName;
        }

        // Save the ritual details
        $ritual->save();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Special Ritual saved successfully.',
            'data' => $ritual
        ], 200);

    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('Error saving special ritual: ' . $e->getMessage());

        // Return server error response
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while saving the special ritual. Please try again.'
        ], 500);
    }
}

public function manageSpecialRitual()
{
    try {
        // Get the authenticated user's temple ID
        $templeId = Auth::guard('api')->user()->temple_id;

        // Fetch all active special rituals belonging to the authenticated temple
        $special_rituals = SpecialRitual::where('status', 'active')
                                         ->where('temple_id', $templeId)
                                         ->get();

        // Return JSON response with the data
        return response()->json([
            'success' => true,
            'data' => $special_rituals
        ], 200);
    } catch (\Exception $e) {
        // Log the error for debugging purposes
        Log::error('Error fetching yearly rituals: ' . $e->getMessage());

        // Return server error response
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while fetching the yearly rituals. Please try again.'
        ], 500);
    }
}

public function updateSpecialRitual(Request $request, $id)
{
    try {
       
        // Find the special ritual by its ID
        $specialRitual = SpecialRitual::findOrFail($id);

        // Update ritual details
        $specialRitual->spcl_ritual_name = $request->spcl_ritual_name;
        $specialRitual->spcl_ritual_date = $request->spcl_ritual_date;
        $specialRitual->spcl_ritual_tithi = $request->spcl_ritual_tithi;
        $specialRitual->spcl_ritual_time = $request->spcl_ritual_time;
        $specialRitual->spcl_ritual_period = $request->spcl_ritual_period;
        $specialRitual->description = $request->description;

        // Handle image upload
        if ($request->hasFile('spcl_ritual_image')) {
            $image = $request->file('spcl_ritual_image');
            $imagePath = 'assets/temple/special_ritual_images/' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/temple/special_ritual_images'), $imagePath);
            $specialRitual->spcl_ritual_image = $imagePath;
        }

        // Handle video upload
        if ($request->hasFile('spcl_ritual_video')) {
            $video = $request->file('spcl_ritual_video');
            $videoPath = 'assets/temple/special_ritual_videos/' . time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('assets/temple/special_ritual_videos'), $videoPath);
            $specialRitual->spcl_ritual_video = $videoPath;
        }

        // Save the updated ritual
        $specialRitual->save();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Yearly Special Ritual updated successfully!',
            'data' => $specialRitual
        ], 200);

    } catch (ModelNotFoundException $e) {
        // Return client error if ritual not found
        return response()->json([
            'success' => false,
            'message' => 'Yearly Special Ritual not found.'
        ], 404);
    } catch (\Exception $e) {
        // Log error with full stack trace
        Log::error($e->getMessage(), ['exception' => $e]);
        return response()->json([
            'success' => false,
            'message' => 'An error occurred',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function deleteSpecialRitual($id)
{
    try {
        // Find the special ritual by ID
        $ritual = SpecialRitual::findOrFail($id);

        // Mark the ritual as deleted by updating the status
        $ritual->status = 'deleted'; // Update the status to indicate it's deleted
        $ritual->save();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Special Ritual marked as deleted successfully.',
        ], 200);

    } catch (ModelNotFoundException $e) {
        // Return client error response if ritual not found
        return response()->json([
            'success' => false,
            'message' => 'Special Ritual not found.',
        ], 404);

    } catch (\Exception $e) {
        // Log the error for debugging purposes
        Log::error('Error deleting special ritual: ' . $e->getMessage());

        // Return server error response
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while deleting the special ritual. Please try again.',
        ], 500);
    }
}


}
