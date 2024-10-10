<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempleDonation;
class TempleDonationController extends Controller
{
    //
    public function adddonation(){
        return view('templeuser.add-temple-donation');
    }
    // Store new donation
    public function storeDonation(Request $request)
    {
        $request->validate([
            'donation_type' => 'required|string',
            'item_name' => 'required|string',
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048', // Validate file type and size
            'item_desc' => 'required|string',
            'quantity' => 'required|integer',
        ]);
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('temple_donations', 'public'); // Store file in the public disk
        }

        TempleDonation::create([
            'temple_id' =>  Auth::guard('temples')->user()->temple_id,
            'donation_type' => $request->donation_type,
            'item_name' => $request->item_name,
            'photo' => $request->photo,
            'item_desc' => $request->item_desc,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('templedonation.manage')->with('success', 'Donation added successfully!');
    }

    // Show list of donations
    public function manageDonations()
    {
        $donations = TempleDonation::all();
        return view('templeuser.manage-temple-donations', compact('donations'));
    }

    // Edit donation form
    public function editDonation($id)
    {
        $donation = TempleDonation::findOrFail($id);
        return view('templeuser.edit-temple-donation', compact('donation'));
    }

    // Update donation
    public function updateDonation(Request $request, $id)
    {
        $donation = TempleDonation::findOrFail($id);
        
        $request->validate([
            'donation_type' => 'required|string',
            'item_name' => 'required|string',
            'photo' => 'nullable|string',
            'item_desc' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        $donation->update($request->all());

        return redirect()->route('templedonation.manage')->with('success', 'Donation updated successfully!');
    }

    // Delete donation (mark as inactive)
    public function deleteDonation($id)
    {
        $donation = TempleDonation::findOrFail($id);
        $donation->update(['status' => 'inactive']);

        return redirect()->route('templedonation.manage')->with('success', 'Donation marked as inactive!');
    }
}
