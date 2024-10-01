<?php

namespace App\Http\Controllers\TempleUser;
use GuzzleHttp\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleUser;
use App\Models\TempleAboutDetail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Exception\RequestException;

class TempleUserController extends Controller
{
  
    private $apiUrl = 'https://auth.otpless.app';
    private $clientId = 'Q9Z0F0NXFT3KG3IHUMA4U4LADMILH1CB';
    private $clientSecret = '5rjidx7nav2mkrz9jo7f56bmj8zuc1r2';

    public function sendOtp(Request $request)
    {
        $phoneNumber = $request->input('phone');
        $countryCode = '+91'; // Assuming the country code is +91 as in your Blade template
        $fullPhoneNumber = $countryCode . $phoneNumber;
            // Check if the mobile number exists in the database
            $temple = TempleUser::where('mobile_no', $phoneNumber)->first();
    
            if (!$temple) {
                return redirect()->back()->with('message', 'This mobile number is not registered. Please register this number.');
            }
        
        $client = new Client();
        $url = rtrim($this->apiUrl, '/') . '/auth/otp/v1/send';
    
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'clientId'      => $this->clientId,
                    'clientSecret'  => $this->clientSecret,
                ],
                'json' => [
                    'phoneNumber' => $fullPhoneNumber,
                ],
            ]);
    
            $body = json_decode($response->getBody(), true);
    
            if (isset($body['orderId'])) {
                $orderId = $body['orderId'];
                session(['otp_order_id' => $orderId, 'otp_phone' => $fullPhoneNumber]);
                return redirect()->back()->with('otp_sent', true)->with('message', 'OTP sent successfully');
            } else {
                return redirect()->back()->with('message', 'Failed to send OTP. Please try again.');
            }
        } catch (RequestException $e) {
            return redirect()->back()->with('message', 'Failed to send OTP due to an error.');
        }
    }

    public function verifyOtp(Request $request)
    {
        $orderId = session('otp_order_id');
        $otp = $request->input('otp');
        $phoneNumber = session('otp_phone');
        
        // OTP verification logic
        $client = new Client();
        $url = rtrim($this->apiUrl, '/') . '/auth/otp/v1/verify';
    
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'clientId' => $this->clientId,
                    'clientSecret' => $this->clientSecret,
                ],
                'json' => [
                    'orderId' => $orderId,
                    'otp' => $otp,
                    'phoneNumber' => $phoneNumber,
                ],
            ]);
    
            $body = json_decode($response->getBody(), true);
    
            if (isset($body['isOTPVerified']) && $body['isOTPVerified']) {
                // Check if mobile number exists in the temple__user_login table
                $phoneNumber = str_replace('+91', '', $phoneNumber);
                $temple = TempleUser::where('mobile_no', $phoneNumber)->first();
    
                if ($temple) {
                    // Mobile number exists, log the user in and redirect to dashboard
                    Auth::guard('temples')->login($temple);
                    return redirect()->route('templedashboard')->with('success', 'User authenticated successfully.');
                } else {
                    // Mobile number does not exist, redirect to registration page
                    return redirect()->route('temple-register')->with('message', 'Please complete your registration.');
                }
            } else {
                $message = $body['message'] ?? 'Invalid OTP';
                return redirect()->back()->with('message', $message);
            }
        } catch (RequestException $e) {
            return redirect()->back()->with('message', 'Failed to verify OTP due to an error.');
        }
    }
    

    public function templelogin(){
        return view("templelogin");
    }

    public function templedashboard()
    {
       
        return view('templeuser.temple-dashboard');
    }
    public function templeabout()
    {
        // Get the authenticated temple user's temple ID
        $temple_id = Auth::guard('temples')->user()->temple_id;
        
        // Fetch the details from the TempleAboutDetail model, or return null if not found
        $temple = TempleAboutDetail::where('temple_id', $temple_id)->first();

        // Pass the data to the view
        return view('templeuser.temple-about', compact('temple'));
    }

    public function updateTempleDetails(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'temple_about' => 'required|string',
            'temple_history' => 'required|string',
            'endowment' => 'nullable|string',
            'endowment_register_no' => 'required_with:endowment|string', // Required if endowment is checked
            'endowment_document' => 'required_with:endowment|file|mimes:pdf,jpeg,png', // Required if endowment is checked
            'trust' => 'nullable|string',
            'trust_register_no' => 'required_with:trust|string', // Required if trust is checked
            'trust_document' => 'required_with:trust|file|mimes:pdf,jpeg,png', // Required if trust is checked
        ]);
        
    
        // Get the authenticated temple user's temple ID
        $temple_id = Auth::guard('temples')->user()->temple_id;
    
        // Find the temple record or create a new one
        $temple = TempleAboutDetail::where('temple_id', $temple_id)->first();
    
        // Check if endowment_document was uploaded, and store the file if it was
        $endowmentDocPath = $request->hasFile('endowment_document')
            ? $request->file('endowment_document')->store('documents/endowment', 'public')
            : $temple->endowment_document;
    
        // Check if trust_document was uploaded, and store the file if it was
        $trustDocPath = $request->hasFile('trust_document')
            ? $request->file('trust_document')->store('documents/trust', 'public')
            : $temple->trust_document;
    
        // Update or create the temple record
        $temple = TempleAboutDetail::updateOrCreate(
            ['temple_id' => $temple_id],
            [
                'temple_about' => $request->temple_about,
                'temple_history' => $request->temple_history,
                'endowment' => $request->endowment,
                'endowment_register_no' => $request->endowment ? $request->endowment_register_no : null,
                'endowment_document' => $endowmentDocPath,
                'trust' => $request->trust,
                'trust_register_no' => $request->trust ? $request->trust_register_no : null,
                'trust_document' => $trustDocPath,
                'status' => 'active' // Set the status or any other fields you want
            ]
        );
        
    
        return redirect()->route('templedashboard')->with('success', 'Temple information updated successfully.');
    }
    

    

}
