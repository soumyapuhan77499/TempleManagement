<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleAboutDetail;
use Illuminate\Support\Facades\Auth;

class TempleAboutController extends Controller
{
    public function updateTempleDetails(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'temple_about' => 'required|string',
                'temple_history' => 'required|string',
                'endowment' => 'required|string|in:yes,no',
                'endowment_register_no' => 'nullable|string',
                'endowment_document' => 'nullable|file|mimes:pdf,jpeg,png|max:3048', // Added file size limit
                'trust' => 'required|string|in:yes,no',
                'trust_register_no' => 'nullable|string',
                'trust_document' => 'nullable|file|mimes:pdf,jpeg,png|max:3048', // Added file size limit
            ]);
    
            // Get authenticated temple user
            $templeUser = Auth::guard('temples')->user();
    
            if (!$templeUser) {
                return response()->json(['message' => 'Unauthenticated user'], 401);
            }
    
            $temple_id = $templeUser->temple_id;
    
            // Find the temple record by temple_id or create a new one
            $temple = TempleAboutDetail::firstOrNew(['temple_id' => $temple_id]);
    
            // Handle endowment document upload
            if ($request->hasFile('endowment_document')) {
                $endowmentDocPath = $request->file('endowment_document')->store('documents/endowment', 'public');
            } else {
                $endowmentDocPath = $temple->endowment_document; // Use existing document path if no new file is uploaded
            }
    
            // Handle trust document upload
            if ($request->hasFile('trust_document')) {
                $trustDocPath = $request->file('trust_document')->store('documents/trust', 'public');
            } else {
                $trustDocPath = $temple->trust_document; // Use existing document path if no new file is uploaded
            }
    
            // Update or set temple details
            $temple->temple_about = $request->temple_about; // Required field
            $temple->temple_history = $request->temple_history; // Required field
            $temple->endowment = $request->endowment === 'yes'; // Convert to boolean
            $temple->endowment_register_no = $request->endowment_register_no ?? null; // Set if provided
            $temple->endowment_document = $endowmentDocPath; // File path
            $temple->trust = $request->trust === 'yes'; // Convert to boolean
            $temple->trust_register_no = $request->trust_register_no ?? null; // Set if provided
            $temple->trust_document = $trustDocPath; // File path
    
            // Save the record (it will either insert or update)
            $temple->save();
    
            // Return a success response with the updated or newly inserted temple details
            return response()->json([
                'message' => 'Temple information updated successfully',
                'data' => $temple
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation error messages
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            // Log and return server error
            \Log::error('UpdateTempleDetails Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
}
