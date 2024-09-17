<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleUser;
use Illuminate\Support\Facades\Auth;
class TempleRegistrationController extends Controller
{
    public function templeregister(){
        return view("temple-register");
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
            // Create a new temple record
            $temple = TempleUser::create([
                'temple_id' => 'TEMPLE' . rand(10000, 99999),
                'temple_name' => $request->input('temple_name'),
                'user_name' => $request->input('user_name'),
                'mobile_no' => $request->input('mobile_no'),
                'temple_trust_name' => $request->input('temple_trust_name'),
                'trust_contact_no' => $request->input('trust_contact_no'),
                'temple_address' => $request->input('temple_address'),
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
