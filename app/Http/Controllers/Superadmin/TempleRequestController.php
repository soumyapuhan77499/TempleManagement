<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleUser;

class TempleRequestController extends Controller
{
    //
    public function templerequests(){
        $templeusers = TempleUser::all();
        return view('superadmin.temple_requests',compact('templeusers'));
    }
    public function updateStatus($id, $status) {
        // Find the temple user by ID
        $templeUser = TempleUser::findOrFail($id);
    
        // Update the temple_status
        $templeUser->temple_status = $status;
        $templeUser->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Temple status updated successfully!');
    }
    
}
