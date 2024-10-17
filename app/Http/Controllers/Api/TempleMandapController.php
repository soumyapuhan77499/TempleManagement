<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleMandapDetail;
use Illuminate\Support\Facades\Auth;
class TempleMandapController extends Controller
{
    //
    public function storeMandap(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'mandap_name' => 'required|string|max:255',
            'mandap_description' => 'required|string',
            'booking_type' => 'required|string',
            'event_name' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        try {
            // Create a new mandap detail record with additional fields
            $mandap = TempleMandapDetail::create([
                'temple_id' => Auth::guard('api')->user()->temple_id, // Use the correct guard for API
                'mandap_name' => $validatedData['mandap_name'],
                'mandap_description' => $validatedData['mandap_description'],
                'booking_type' => $validatedData['booking_type'],
                'event_name' => $validatedData['event_name'],
                'price_per_day' => $validatedData['price_per_day'],
                'status' => 'active', // Default status
            ]);

            // Return success response
            return response()->json([
                'message' => 'Mandap details saved successfully!',
                'data' => $mandap
            ], 201); // 201 Created status
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'message' => 'Failed to save mandap details.',
                'error' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }

}
