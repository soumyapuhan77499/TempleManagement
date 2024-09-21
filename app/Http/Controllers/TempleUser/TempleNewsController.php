<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleNews;
use Illuminate\Support\Facades\Auth;

class TempleNewsController extends Controller
{
    //
    public function addNews()
    {
        return view('templeuser.add-temple-news'); // Create this blade view for adding news
    }
    public function storeNews(Request $request)
    {
    

        TempleNews::create([
            'temple_id' => auth()->user()->temple_id, // Assuming temple_id is linked to user
            'notice_name' => $request->notice_name,
            'notice_date' => $request->notice_date,
            'notice_descp' => $request->notice_descp,
            'status' => 'active',
        ]);

        return redirect()->route('templenews.manageNews')->with('success', 'News added successfully!');
    }
    // Manage active news items
    public function manageNews()
    {
        $newsList = TempleNews::where('status', 'active')->get();
        return view('templeuser.manage-news', compact('newsList')); // Create this blade view for managing news
    }
    // Show edit news form
    public function editNews($id)
    {
        $news = TempleNews::findOrFail($id);
        return view('templeuser.edit-news', compact('news')); // Create this blade view for editing
    }

    // Update news data
    public function updateNews(Request $request, $id)
    {
        $request->validate([
            'notice_name' => 'required|string|max:255',
            'notice_date' => 'required|date',
            'notice_descp' => 'required|string',
        ]);

        $news = TempleNews::findOrFail($id);
        $news->update([
            'notice_name' => $request->notice_name,
            'notice_date' => $request->notice_date,
            'notice_descp' => $request->notice_descp,
        ]);

        return redirect()->route('templenews.manageNews')->with('success', 'News updated successfully!');
    }

    // Soft delete news (change status to deactive)
    public function destroyNews($id)
    {
        $news = TempleNews::findOrFail($id);
        $news->update(['status' => 'deactive']);

        return redirect()->route('templenews.manageNews')->with('success', 'News Deleted Successfully!');
    }

   
}
