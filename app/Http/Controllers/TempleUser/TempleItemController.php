<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeityDressItem;

class TempleItemController extends Controller
{
    //
  
    public function additem(){
        return view('templeuser.templeitem.temple-add-item');
    }
    public function templemanageitem()
    {
        $items = DeityDressItem::where('status', 'active')
       ->get();
        return view('templeuser.templeitem.temple-manage-item', compact('items'));
    }

 
    // Save a new item
    public function saveitem(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DeityDressItem::create($request->only(['item_name', 'description']));

        return redirect()->route('templeuser.manageitems')->with('success', 'Item added successfully!');
    }

    // Edit an item
    public function edititem($id)
    {
        $item = DeityDressItem::findOrFail($id);
        return view('templeuser.templeitem.temple-edit-item', compact('item'));
    }

    // Update an item
    public function updateitem(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $item = DeityDressItem::findOrFail($id);
        $item->update($request->only(['item_name', 'description']));

        return redirect()->route('templeuser.manageitems')->with('success', 'Item updated successfully!');
    }

    public function deleteitem($id)
    {
        $item = DeityDressItem::findOrFail($id);
        $item->update(['status' => 'deleted']);
    
        return redirect()->route('templeuser.manageitems')->with('success', 'Item status updated to deleted successfully!');
    }
    
}
