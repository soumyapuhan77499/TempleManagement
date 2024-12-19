<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PanjiDetails;

class PanjiController extends Controller
{
    public function getPanjiDetails()
{
    try {
        // Fetch panji details with active status
        $panji_details = PanjiDetails::where('status', 'active')->get();

        // Check if data exists
        if ($panji_details->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No active panji details found',
            ], 404);
        }

        // Return successful response with data
        return response()->json([
            'status' => 200,
            'message' => 'Panji details fetched successfully',
            'data' => $panji_details,
        ], 200);
    } catch (\Exception $e) {
        // Log the exception for debugging
        Log::error('Error fetching Panji details: ' . $e->getMessage());

        // Return error response
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while fetching Panji details',
        ], 500);
    }
}
}
