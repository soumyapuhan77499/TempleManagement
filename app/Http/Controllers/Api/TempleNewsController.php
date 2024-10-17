<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleNews;
use Illuminate\Support\Facades\Auth;

class TempleNewsController extends Controller
{
    //
    public function storeNews(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'notice_name' => 'required|string|max:255',
            'notice_date' => 'required|date',
            'notice_descp' => 'required|string',
        ]);
    
        try {
            // Create a new news entry
            $templeNews = TempleNews::create([
                'temple_id' => Auth::guard('api')->user()->temple_id, // Assuming temple_id is linked to the user
                'notice_name' => $validatedData['notice_name'],
                'notice_date' => $validatedData['notice_date'],
                'notice_descp' => $validatedData['notice_descp'],
                'status' => 'active',
            ]);
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'News added successfully!',
                'data' => $templeNews,
            ], 200);
    
        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add news.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function manageNews(Request $request)
    {
        try {
            // Get the temple ID from the authenticated user
            $templeId = Auth::guard('api')->user()->temple_id;
    
            // Retrieve the list of active news for the temple
            $newsList = TempleNews::where('status', 'active')
                ->where('temple_id', $templeId)
                ->get();
    
            // Return the news list as a JSON response
            return response()->json([
                'status' => 200,
                'message' => 'News list retrieved successfully!',
                'data' => $newsList,
            ], 200);
    
        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve news list.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function updateNews(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'notice_name' => 'required|string|max:255',
            'notice_date' => 'required|date',
            'notice_descp' => 'required|string',
        ]);
    
        try {
            // Find the news by ID or fail
            $news = TempleNews::findOrFail($id);
    
            // Update the news details
            $news->update([
                'notice_name' => $validatedData['notice_name'],
                'notice_date' => $validatedData['notice_date'],
                'notice_descp' => $validatedData['notice_descp'],
            ]);
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'News updated successfully!',
                'data' => $news
            ], 200);
    
        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'status' => 500,
                'message' => 'Failed to update news.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroyNews($id)
    {
        try {
            // Find the news by ID or fail
            $news = TempleNews::findOrFail($id);
    
            // Update the status to 'deleted'
            $news->update(['status' => 'deleted']);
    
            // Return success response
            return response()->json([
                'status' => 200,
                'message' => 'News deleted successfully!'
            ], 200);
    
        } catch (\Exception $e) {
            // Handle exception and return error response
            return response()->json([
                'status' => 500,
                'message' => 'Failed to delete news.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    




}
