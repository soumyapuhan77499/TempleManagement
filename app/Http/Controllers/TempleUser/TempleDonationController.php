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
    // Store cash donation
    public function storeCashDonation(Request $request)
    {
        // Validation rules
        $request->validate([
            'donated_by' => 'required|string|max:255',
            'donation_amount' => 'required|numeric|min:1',
            'donation_date_time' => 'required|date',
            'phone_number' => 'required|digits:10', // 10-digit phone number
            'address' => 'required|string|max:255',
            'pan_card' => 'nullable|string|max:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', // Valid PAN format
        ]);
    
        // Generate donation ID
        $donation_id = 'DON' . mt_rand(1000000, 9999999);
    
        // Create the donation
        TempleDonation::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id,
            'donation_id' => $donation_id,
            'donated_by' => $request->donated_by,
            'donation_amount' => $request->donation_amount,
            'donation_date_time' => $request->donation_date_time,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'pan_card' => $request->pan_card,
            'type' => 'cash',
            'status' => 'active',
        ]);
    
        // Redirect back to the manage page with a success message
        return redirect()->route('templedonation.manage')->with('success', 'Donation added successfully!');
    }
    
   
    // Show list of donations
    public function managecashDonations()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
     
        $cashdonations = TempleDonation::where('status', 'active')
            ->where('temple_id', $templeId)
            ->where('type','cash')
            ->get();
       
        return view('templeuser.manage-temple-cash-donations', compact('cashdonations'));
    }

    // Edit donation form
    public function editDonation($id)
    {
        $donation = TempleDonation::findOrFail($id);
        return view('templeuser.edit-temple-cash-donation', compact('donation'));
    }

    // Update donation
    public function updateDonation(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'donated_by' => 'required|string|max:255',
            'donation_amount' => 'required|numeric|min:1',
            'donation_date_time' => 'required|date',
            'phone_number' => 'required|string|regex:/^[0-9]{10}$/',
            'address' => 'required|string|max:255',
            'pan_card' => 'required|string|max:255',
        ]);
    
        // Find the donation
        $donation = TempleDonation::findOrFail($id);
    
        // Update the donation record
        $donation->update([
            'donated_by' => $request->donated_by,
            'donation_amount' => $request->donation_amount,
            'donation_date_time' => $request->donation_date_time,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'pan_card' => $request->pan_card,
            'type' => $donation->type, // Preserve the type if it's not being edited
            'status' => $donation->status, // Preserve the status if it's not being edited
        ]);
    
        return redirect()->route('templedonation.manage')->with('success', 'Donation updated successfully!');
    }
    

    // Delete donation (mark as inactive)
   
    public function deleteDonation($id)
    {
        // Find the donation
        $donation = TempleDonation::findOrFail($id);

        // Set status to deleted
        $donation->status = 'deleted';
        $donation->save();

        return redirect()->route('templedonation.manage')->with('success', 'Donation deleted successfully!');
    }

    public function storeonlineDonation(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'donated_by' => 'required|string|max:255',
        'donation_amount' => 'required|numeric|min:1',
        'donation_date_time' => 'required|date',
        'phone_number' => 'required|regex:/^[0-9]{10}$/',
        'address' => 'required|string|max:255',
        'payment_mode' => 'required|string',
        'payment_number' => 'required|string|max:255',
    ]);

    // Create a unique donation ID
    $donation_id = 'DON' . mt_rand(1000000, 9999999);
    
    // Store the donation
    TempleDonation::create([
        'temple_id' => Auth::guard('temples')->user()->temple_id,
        'donation_id' => $donation_id,
        'donated_by' => $validatedData['donated_by'],
        'donation_amount' => $validatedData['donation_amount'],
        'donation_date_time' => $validatedData['donation_date_time'],
        'phone_number' => $validatedData['phone_number'],
        'address' => $validatedData['address'],
        'payment_mode' => $validatedData['payment_mode'],
        'payment_number' => $validatedData['payment_number'],
        'type' => 'online',

        'status' => 'active',
    ]);

    return redirect()->route('templedonation.manage')->with('success', 'Donation added successfully!');
}

public function manageonlineDonations()
{
    $templeId = Auth::guard('temples')->user()->temple_id;
 
    $onlinedonations = TempleDonation::where('status', 'active')
        ->where('temple_id', $templeId)
        ->where('type','online')
        ->get();
   
    return view('templeuser.manage-temple-online-donations', compact('onlinedonations'));
}

public function editDonationonline($id)
{
    $donation = TempleDonation::findOrFail($id);
    return view('templeuser.edit-temple-online-donation', compact('donation'));
}

public function updateDonationonline(Request $request, $id)
{
    $donation = TempleDonation::findOrFail($id);
    
    // Validate the incoming request data
    $validatedData = $request->validate([
        'donated_by' => 'required|string|max:255',
        'donation_amount' => 'required|numeric|min:1',
        'donation_date_time' => 'required|date',
        'phone_number' => 'required|regex:/^[0-9]{10}$/',
        'address' => 'required|string|max:255',
        'payment_mode' => 'required|string',
        'payment_number' => 'required|string|max:255',
    ]);

    // Update the donation
    $donation->update($validatedData);

    return redirect()->route('templedonation.manageonline')->with('success', 'Donation updated successfully!');
}
public function deleteDonationonline($id)
{
    $donation = TempleDonation::findOrFail($id);
    $donation->status = 'deleted'; // Mark as deleted instead of actually deleting
    $donation->save();

    return redirect()->route('templedonation.manageonline')->with('success', 'Donation deleted successfully!');
}

public function storeitemDonation(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'donated_by' => 'required|string|max:255',
        'item_name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'donation_date_time' => 'required|date',
        'phone_number' => 'required|digits:10',
        'address' => 'required|string|max:255',
        'item_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image file
    ]);

    // Handle the file upload for item_image using Laravel's store method
    if ($request->hasFile('item_image')) {
        // Store the file in 'public/inventory_photos' directory
        $imagePath = $request->file('item_image')->store('donations', 'public');
    }
    $donation_id = 'DON' . mt_rand(1000000, 9999999);

    // Store the data in the database
    $templeDonation = new TempleDonation();
    $templeDonation->temple_id = Auth::guard('temples')->user()->temple_id;
    $templeDonation->donation_id = $donation_id;
    $templeDonation->donated_by = $request->donated_by;
    $templeDonation->item_name = $request->item_name;
    $templeDonation->quantity = $request->quantity;
    $templeDonation->donation_date_time = $request->donation_date_time;
    $templeDonation->phone_number = $request->phone_number;
    $templeDonation->address = $request->address;
    $templeDonation->item_image = isset($imagePath) ? $imagePath : null; // Save the image path
    $templeDonation->type ='item';

    $templeDonation->status = 'active';
    $templeDonation->save();

    // Redirect back with success message
    return redirect()->route('templedonation.manageitem')->with('success', 'Item donation added successfully!');
}

public function manageitemDonations()
{
    $templeId = Auth::guard('temples')->user()->temple_id;
 
    $itemdonations = TempleDonation::where('status', 'active')
        ->where('temple_id', $templeId)
        ->where('type','item')
        ->get();
   
    return view('templeuser.manage-temple-item-donations', compact('itemdonations'));
}

public function editDonationitem($id)
{
    $donation = TempleDonation::findOrFail($id);
    return view('templeuser.edit-temple-item-donation', compact('donation'));
}

public function updateDonationitem(Request $request, $id)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'donated_by' => 'required|string|max:255',
        'item_name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'donation_date_time' => 'required|date',
        'phone_number' => 'required|digits:10',
        'address' => 'required|string|max:255',
        'item_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
    ]);

    // Find the donation record by ID
    $donation = TempleDonation::findOrFail($id);

    // Handle file upload if item_image is provided
    if ($request->hasFile('item_image')) {
        // Store the image in 'public/inventory_photos' and get the path
        $imagePath = $request->file('item_image')->store('donations', 'public');

        // Delete the old image if it exists
        if ($donation->item_image) {
            Storage::disk('public')->delete($donation->item_image);
        }

        // Update the donation's item_image field with the new path
        $donation->item_image = $imagePath;
    }

    // Update the donation details
    $donation->donated_by = $request->donated_by;
    $donation->item_name = $request->item_name;
    $donation->quantity = $request->quantity;
    $donation->donation_date_time = $request->donation_date_time;
    $donation->phone_number = $request->phone_number;
    $donation->address = $request->address;

    // Save the updated donation data
    $donation->save();

    // Redirect back with success message
    return redirect()->route('templedonation.manageitem')->with('success', 'Item donation updated successfully!');
}
public function deleteDonationitem($id)
{
    $donation = TempleDonation::findOrFail($id);
    $donation->status = 'deleted'; // Mark as deleted instead of actually deleting
    $donation->save();

    return redirect()->route('templedonation.manageitem')->with('success', 'Donation deleted successfully!');
}

}
