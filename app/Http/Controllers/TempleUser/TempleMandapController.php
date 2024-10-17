<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleMandapDetail;
use Illuminate\Support\Facades\Auth;
class TempleMandapController extends Controller
{
    //
    public function addmandap(){
        return view('templeuser.add-temple-mandap');
    }
    public function storeMandap(Request $request)
    {
      
        // Create a new mandap detail with additional fields
        TempleMandapDetail::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id, // Assuming user is authenticated
            'mandap_name' => $request->mandap_name,
            'mandap_description' => $request->mandap_description,
            'booking_type' => $request->booking_type,
            'event_name' => $request->event_name,
            'price_per_day' => $request->price_per_day,
            'status' => 'active', // Default status
        ]);

        return redirect()->route('templemandap.managemandap')->with('success', 'Mandap details saved successfully!');
    }
    public function manageMandap()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;

        $mandaps = TempleMandapDetail::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get(); // Fetch only active mandaps for the specific temple

        return view('templeuser.manage-mandap', compact('mandaps'));
    }
    public function edit($id)
    {
        $mandap = TempleMandapDetail::findOrFail($id);
        return view('templeuser.edit-mandap', compact('mandap')); // Create this Blade view for editing
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mandap_name' => 'required|string|max:255',
            'mandap_description' => 'required|string',
            'booking_type' => 'required|in:day-basis,event-basis',
            'event_name' => 'nullable|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        $mandap = TempleMandapDetail::findOrFail($id);
        $mandap->update($request->all());

        return redirect()->route('templemandap.managemandap')->with('success', 'Mandap details updated successfully!');
    }
    public function destroy($id)
    {
        $mandap = TempleMandapDetail::findOrFail($id);
        $mandap->status = 'deleted'; // Set status to inactive
        $mandap->save(); // Save the changes

        return redirect()->route('templemandap.managemandap')->with('success', 'Mandap status updated to inactive successfully!');
    }



}
