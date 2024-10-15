<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleUser;
use App\Models\TempleTitle;
use App\Models\TempleTrustDetail;
use Illuminate\Support\Facades\Auth;

class TempleRegistrationController extends Controller
{
    public function templeregister() {
        // Fetch all active temple titles from the database
        $temple_titles = TempleTitle::where('status', 'active')->get();
    
        // Pass the temple titles to the view
        return view("temple-register", compact('temple_titles'));
    }
    

    public function registerTemple(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'temple_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'mobile_no' => 'required|digits:10', // Validate mobile number to be 10 digits
            'temple_address' => 'required|string',
        ]);
    
        try {
            // Generate a random temple_id once to use for both tables
            $temple_id = 'TEMPLE' . rand(10000, 99999);
    
            // Create a new temple record in temple_user table
            $temple = TempleUser::create([
                'temple_id' => $temple_id,
                'temple_title' => $request->input('temple_title'),
                'temple_name' => $request->input('temple_name'),
                'user_name' => $request->input('user_name'),
                'mobile_no' => $request->input('mobile_no'),
                'temple_address' => $request->input('temple_address'),
            ]);
    
            // Create a new trust record in temple_trust_detail table
            $temple_trust = TempleTrustDetail::create([
                'temple_id' => $temple_id, // Use the same temple_id as above
                'trust_name' => $request->input('temple_trust_name'),
                'trust_number' => $request->input('trust_number'),
                'trust_contact_no' => $request->input('trust_contact_no'),
            ]);
    
            // Success message on successful creation
            return redirect()->route('templedashboard')->with('success', 'Temple registered successfully.');
    
        } catch (\Exception $e) {
            // Error handling: Log the error and show a user-friendly message
            \Log::error('Error registering temple: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while registering the temple. Please try again later.');
        }
    }
    
    
    public function logout(Request $request)
    {
        // Log the user out using the 'temples' guard
        Auth::guard('temples')->logout();
        
        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate the session token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect to the login page or any other page you prefer
        return redirect()->route('templelogin')->with('success', 'You have successfully logged out.');
    }
    
}
