<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleTitle;

class TempleTitleController extends Controller
{
    //
    public function mngtitle(){
        $templetitles = TempleTitle::where('status', '!=', 'deactive')->get();
        return view('superadmin.manage-temple-title', compact('templetitles'));
    }

    // Add a new title
    public function addTitle(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        TempleTitle::create([
            'title' => $request->title,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Title added successfully!');
    }

    // Update an existing title
    public function updateTitle(Request $request, $id) {
        // dd('hd');
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $templeTitle = TempleTitle::findOrFail($id);
        $templeTitle->update([
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Title updated successfully!');
    }

    // Delete or deactivate a title
    public function deleteTitle($id) {
        $templeTitle = TempleTitle::findOrFail($id);
        $templeTitle->update([
            'status' => 'deactive',
        ]);

        return redirect()->back()->with('success', 'Title deactivated successfully!');
    }
}
