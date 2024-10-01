<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleFestival;
use Illuminate\Support\Facades\Auth;

class TempleFestivalController extends Controller
{
    public function apiStoreFestival(Request $request)
    {
        try {
            // Capture incoming festival data from the form
            $templeId = Auth::guard('api')->user()->temple_id; // Fetch authenticated temple ID
    
            // Insert festival data without validation
            TempleFestival::create([
                'temple_id' => $templeId,
                'festival_name' => $request->input('festival_name'),
                'festival_date' => $request->input('festival_date'),
                'festival_descp' => $request->input('festival_descp'),
                'status' => 'active',
            ]);
    
            // Return a 200 success response
            return response()->json(['success' => 'Festival added successfully!'], 200);
    
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Error adding festival: ' . $e->getMessage());
    
            // Return a 500 server error
            return response()->json(['error' => 'An error occurred while adding the festival.'], 500);
        }
    }

    public function apiManageFestivals(Request $request)
{
    try {
        $templeId = Auth::guard('api')->user()->temple_id;

        // Fetch festivals for the authenticated temple and return in JSON format
        $festivals = TempleFestival::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get();

        // Return a 200 success response with the festivals data
        return response()->json(['festivals' => $festivals, 'success' => 'Festivals retrieved successfully!'], 200);

    } catch (\Exception $e) {
        // Log the exception for debugging
        \Log::error('Error retrieving festivals: ' . $e->getMessage());

        // Return a 500 server error
        return response()->json(['error' => 'An error occurred while retrieving festivals.'], 500);
    }
}

public function apiUpdateFestival(Request $request, $id)
{
    try {
        // Find the festival by ID or fail if not found
        $festival = TempleFestival::findOrFail($id);

        // Update the festival data
        $festival->update([
            'festival_name' => $request->input('festival_name'),
            'festival_date' => $request->input('festival_date'),
            'festival_descp' => $request->input('festival_descp'),
        ]);

        // Return a 200 success response
        return response()->json(['success' => 'Festival updated successfully!'], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Return a 404 error if festival is not found
        return response()->json(['error' => 'Festival not found.'], 404);

    } catch (\Exception $e) {
        // Log the exception for debugging
        \Log::error('Error updating festival: ' . $e->getMessage());

        // Return a 500 server error
        return response()->json(['error' => 'An error occurred while updating the festival.'], 500);
    }
}

    
}
