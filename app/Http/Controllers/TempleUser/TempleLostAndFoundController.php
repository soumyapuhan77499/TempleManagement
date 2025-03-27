<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use App\Models\TempleLostAndFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TempleLostAndFoundController extends Controller
{
    public function lostAndFound()
    {
        $records = TempleLostAndFound::where('status','active')->orderByDesc('created_at')->get();

        return view('templeuser.add-temple-lost-and-found', compact('records'));
    }

public function saveLostAndFound(Request $request)
{
    $request->validate([
        'type' => 'required|in:lost,found',
        'name' => 'required|string|max:255',
        'phone_no' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'item_name' => 'required|string|max:255',
        'item_location' => 'required|string|max:255',
        'description' => 'nullable|string',
        'item_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    try {
        $itemPhotoPath = null;

        if ($request->hasFile('item_photo')) {
            $itemPhotoPath = $request->file('item_photo')->store('lostfound_photos', 'public');
        }

        TempleLostAndFound::create([
            'temple_id'     =>  Auth::guard('temples')->user()->temple_id,
            'type'          => $request->type,
            'name'          => $request->name,
            'phone_no'      => $request->phone_no,
            'address'       => $request->address,
            'item_name'     => $request->item_name,
            'item_location' => $request->item_location,
            'description'   => $request->description,
            'item_photo'    => $itemPhotoPath,
        ]);

        return redirect()->back()->with('success', 'Entry saved successfully!');

    } catch (\Exception $e) {
        Log::error('Lost & Found Save Error: ' . $e->getMessage());

        return redirect()->back()->with('error', 'Something went wrong! Please try again.');
    }
}

public function getSingle($id)
{
    $data = TempleLostAndFound::findOrFail($id);
    return response()->json($data);
}

public function editLostAndFound(Request $request, $id)
{
    $request->validate([
        'type' => 'required|in:lost,found',
        'name' => 'required|string|max:255',
        'phone_no' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'item_name' => 'required|string|max:255',
        'item_location' => 'required|string|max:255',
        'description' => 'nullable|string',
        'item_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    try {
        $record = TempleLostAndFound::findOrFail($id);

        if ($request->hasFile('item_photo')) {
            if ($record->item_photo && \Storage::disk('public')->exists($record->item_photo)) {
                \Storage::disk('public')->delete($record->item_photo);
            }
            $record->item_photo = $request->file('item_photo')->store('lostfound_photos', 'public');
        }

        $record->update([
            'type' => $request->type,
            'name' => $request->name,
            'phone_no' => $request->phone_no,
            'address' => $request->address,
            'item_name' => $request->item_name,
            'item_location' => $request->item_location,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Record updated successfully.');

    } catch (\Exception $e) {
        \Log::error('Update Lost & Found Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong while updating.');
    }
}

public function deleteLostAndFound($id)
{
    try {
        $record = TempleLostAndFound::findOrFail($id);
        $record->status = 'deleted';
        $record->save();

        return redirect()->back()->with('success', 'Entry marked as deleted.');
    } catch (\Exception $e) {
        \Log::error('Delete Lost & Found Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong while deleting.');
    }
}
}
