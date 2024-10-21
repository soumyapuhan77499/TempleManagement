<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleInventoryCategory;
use App\Models\TempleInventoryList;
use Illuminate\Support\Facades\Auth;
class TempleInventoryController extends Controller
{
    //
    public function mnginventorycategory(){
        $templeId = Auth::guard('temples')->user()->temple_id;
        $categories = TempleInventoryCategory::where('status', 'active')
        ->where('temple_id', $templeId)->get();
        return view('templeuser.manage-temple-inventory-category', compact('categories'));
    }
     // Store new category
     public function store(Request $request)
     {
         $request->validate([
             'inventory_categoy' => 'required|string|max:255',
         ]);
 
         TempleInventoryCategory::create([
             'temple_id' => auth()->user()->temple_id, // Assume temple_id from authenticated user
             'inventory_categoy' => $request->inventory_categoy,
             'inventory_descrp' => $request->inventory_descrp,
         ]);
 
         return redirect()->back()->with('success', 'Category added successfully!');
     }
 
     // Update category
     public function update(Request $request, $id)
     {
         // Validate the incoming request
         $request->validate([
             'inventory_categoy' => 'required|string|max:255',
         ]);
     
         // Find the inventory category by ID and update it
         $category = TempleInventoryCategory::findOrFail($id);
         $category->inventory_categoy = $request->input('inventory_categoy');
         $category->inventory_descrp = $request->input('inventory_descrp');
         
         $category->save();
     
         // Redirect back with a success message
         return redirect()->back()->with('success', 'Inventory category updated successfully.');
     }
     
 
     // Deactivate category (soft delete)
     public function destroy($id)
     {
         $category = TempleInventoryCategory::findOrFail($id);
         $category->update(['status' => 'deactive']);
 
         return redirect()->back()->with('danger', 'Category deactivated successfully!');
     }
     public function addInventory(){
     
        $categories = TempleInventoryCategory::where('status', 'active')->get(); // Fetch all categories
        return view('templeuser.add-temple-inventory', compact('categories'));
     }
     public function storeInventory(Request $request)
    {
        // Validate request
        $request->validate([
            'item_name' => 'required',
            'item_desc' => 'required',
            'quantity' => 'required|integer',
            'photo' => 'required|image',
            'inventory_category' => 'required',
            'type' => 'required',
        ]);

        // Handle photo upload
        $photoPath = $request->file('photo')->store('inventory_photos', 'public');

        // Save the data
        TempleInventoryList::create([
            'temple_id' => auth()->user()->temple_id, // Assuming user is associated with a temple
            'item_name' => $request->item_name,
            'item_desc' => $request->item_desc,
            'quantity' => $request->quantity,
            'photo' => $photoPath,
            'inventory_category' => $request->inventory_category,
            'type' => $request->type,
            'status' => 'active', // Set status as active by default
        ]);

        return redirect()->back()->with('success', 'Inventory item added successfully.');
    }
    public function manageInventory(){
        $templeId = Auth::guard('temples')->user()->temple_id;
        $inventoryItems = TempleInventoryList::with('inventorycategory')->where('status','active')
        ->where('temple_id', $templeId)->get();
        return view('templeuser.manage-temple-inventory',compact('inventoryItems'));
    }
    public function editinventory($id)
    {
        $inventory = TempleInventoryList::findOrFail($id);
        $categories = TempleInventoryCategory::where('status','active')->get();
        return view('templeuser.edit-temple-inventory', compact('inventory', 'categories'));
    }

    public function updateinventory(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'item_name' => 'required',
            'item_desc' => 'required',
            'quantity' => 'required|integer',
            'photo' => 'nullable|image',
            'inventory_category' => 'required',
            'type' => 'required',
        ]);

        // Find the inventory item
        $inventory = TempleInventoryList::findOrFail($id);

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('inventory_photos', 'public');
            $inventory->photo = $photoPath;
        }

        // Update the inventory item
        $inventory->update([
            'item_name' => $request->item_name,
            'item_desc' => $request->item_desc,
            'quantity' => $request->quantity,
            'inventory_category' => $request->inventory_category,
            'type' => $request->type,
        ]);

        return redirect()->route('templeinventory.manageinventory')->with('success', 'Inventory item updated successfully.');
    }
    public function deleteinventory($id)
    {
        $inventory = TempleInventoryList::findOrFail($id);

        // Mark as deactive
        $inventory->update(['status' => 'deactive']);
        return redirect()->route('templeinventory.manageinventory')->with('success', 'Inventory item deactivated successfully.');

    }


   
}
