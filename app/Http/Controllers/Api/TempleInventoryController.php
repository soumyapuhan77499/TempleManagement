<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleInventoryCategory;
use App\Models\TempleInventoryList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class TempleInventoryController extends Controller
{
    //
    public function storeCategory(Request $request)
{
    // Check if user is authenticated
    $templeId = Auth::guard('api')->user()->temple_id;
    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    // Validate the incoming request
    $request->validate([
        'inventory_categoy' => 'required|string|max:255',
        'inventory_descrp' => 'nullable|string|max:500', // Optional description validation
    ]);

    try {
        // Create the new inventory category
        $category = TempleInventoryCategory::create([
            'temple_id' => $templeId, // Get temple_id from authenticated user
            'inventory_categoy' => $request->input('inventory_categoy'),
            'inventory_descrp' => $request->input('inventory_descrp'),
        ]);

        return response()->json([
            'message' => 'Category added successfully!',
            'data' => $category,
            'status' => 201,
        ], 201);

    } catch (\Exception $e) {
        // Handle any exceptions that occur
        return response()->json([
            'message' => 'Error occurred while adding the category.',
            'error' => $e->getMessage(),
            'status' => 500,
        ], 500);
    }
}

public function updateCategory(Request $request, $id)
{
    // Check if the user is authenticated
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    // Validate the incoming request
    $request->validate([
        'inventory_categoy' => 'required|string|max:255',
        'inventory_descrp' => 'nullable|string|max:500', // Optional description validation
    ]);

    try {
        // Find the inventory category by ID and update it
        $category = TempleInventoryCategory::findOrFail($id);
        $category->inventory_categoy = $request->input('inventory_categoy');
        $category->inventory_descrp = $request->input('inventory_descrp');
        
        $category->save();

        // Return a success response
        return response()->json([
            'message' => 'Inventory category updated successfully.',
            'data' => $category,
            'status' => 200,
        ], 200);
    } catch (\Exception $e) {
        // Handle any exceptions that occur
        return response()->json([
            'message' => 'Error occurred while updating the inventory category.',
            'error' => $e->getMessage(),
            'status' => 500,
        ], 500);
    }
}
public function mngInventoryCategory()
{
    // Check if the user is authenticated
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    try {
        // Retrieve active inventory categories for the authenticated temple
        $categories = TempleInventoryCategory::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get();

        // Return a success response with the categories
        return response()->json([
            'message' => 'Inventory categories retrieved successfully.',
            'data' => $categories,
            'status' => 200,
        ], 200);
    } catch (\Exception $e) {
        // Handle any exceptions that occur
        return response()->json([
            'message' => 'Error occurred while retrieving inventory categories.',
            'error' => $e->getMessage(),
            'status' => 500,
        ], 500);
    }
}
public function destdestroyInventoryCategoryroy($id)
{
    // Check if the user is authenticated
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    try {
        // Find the category by ID and deactivate it
        $category = TempleInventoryCategory::findOrFail($id);
        $category->update(['status' => 'deactive']);

        // Return a success response
        return response()->json([
            'message' => 'Category deactivated successfully!',
            
            'status' => 200,
        ], 200);
    } catch (\Exception $e) {
        // Handle any exceptions that occur
        return response()->json([
            'message' => 'Error occurred while deactivating the category.',
            'error' => $e->getMessage(),
            'status' => 500,
        ], 500);
    }
}



public function storeInventory(Request $request)
{
    // Check if the user is authenticated
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    // Validate request
    $request->validate([
        'item_name' => 'required',
        'item_desc' => 'nullable', // item_desc is now optional
        'quantity' => 'required|integer',
        'photo' => 'required|image',
        'inventory_category' => 'required',
        'type' => 'required',
    ]);

    try {
        // Handle photo upload
        $photoPath = $request->file('photo')->store('inventory_photos', 'public');

        // Save the data
        $ineventory = TempleInventoryList::create([
            'temple_id' => $templeId, // Use authenticated user's temple_id
            'item_name' => $request->item_name,
            'item_desc' => $request->item_desc,
            'quantity' => $request->quantity,
            'photo' => $photoPath,
            'inventory_category' => $request->inventory_category,
            'type' => $request->type,
            'status' => 'active', // Set status as active by default
        ]);

        return response()->json([
            'message' => 'Inventory item added successfully.',
            'data' => $ineventory,
            'status' => 201,
        ], 201);
    } catch (\Exception $e) {
        // Handle any exceptions that occur
        return response()->json([
            'message' => 'Error occurred while adding inventory item.',
            'error' => $e->getMessage(),
            'status' => 500,
        ], 500);
    }
}

public function mngInventory()
{
    // Check if the user is authenticated
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    try {
        // Retrieve active inventory items for the authenticated user's temple
        $inventoryItems = TempleInventoryList::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get();

            $inventoryItems->map(function ($item) {
                $item->photo_url =  asset('storage/' . $item->photo);;
                return $item;
            });

        // Check if there are any items
        if ($inventoryItems->isEmpty()) {
            return response()->json([
                'message' => 'No active inventory items found.',
                'data' => [],
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'message' => 'Inventory items retrieved successfully.',
            'data' => $inventoryItems,
            'status' => 200,
        ], 200);
    } catch (\Exception $e) {
        // Handle any exceptions that occur
        return response()->json([
            'message' => 'Error occurred while retrieving inventory items.',
            'error' => $e->getMessage(),
            'status' => 500,
        ], 500);
    }
}

public function updateInventory(Request $request, $id)
{
    // Check if the user is authenticated
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    // Validate request
    $request->validate([
        'item_name' => 'required|string|max:255',
        'item_desc' => 'nullable|string',
        'quantity' => 'required|integer',
        'photo' => 'nullable|image',
        'inventory_category' => 'required|string',
        'type' => 'required|string',
    ]);

    try {
        // Find the inventory item
        $inventory = TempleInventoryList::findOrFail($id);

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($inventory->photo) {
                Storage::disk('public')->delete($inventory->photo);
            }
            // Store the new photo
            $photoPath = $request->file('photo')->store('inventory_photos', 'public');
            $inventory->photo = $photoPath; // Update photo path
        }

        // Update the inventory item
        $inventory->update([
            'item_name' => $request->item_name,
            'item_desc' => $request->item_desc,
            'quantity' => $request->quantity,
            'inventory_category' => $request->inventory_category,
            'type' => $request->type,
        ]);

        return response()->json([
            'message' => 'Inventory item updated successfully.',
            'data' => $inventory,
            'status' => 200,
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'message' => 'Inventory item not found.',
            'data' => null,
            'status' => 404,
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error occurred while updating inventory item.',
            'error' => $e->getMessage(),
            'status' => 500,
        ], 500);
    }
}

public function destdestroyInventory(Request $request, $id)
{
    // Check if the user is authenticated
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    try {
        // Find the inventory item
        $inventory = TempleInventoryList::findOrFail($id);

        // Mark as deactive
        $inventory->update(['status' => 'deactive']);

        return response()->json([
            'message' => 'Inventory item deactivated successfully.',
          
            'status' => 200,
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'message' => 'Inventory item not found.',
            'data' => null,
            'status' => 404,
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error occurred while deactivating inventory item.',
            'error' => $e->getMessage(),
            'status' => 500,
        ], 500);
    }
}




}
