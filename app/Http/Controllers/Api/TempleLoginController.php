<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\TempleUser;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class TempleLoginController extends Controller
{
    private $apiUrl;
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->apiUrl = 'https://auth.otpless.app';
        $this->clientId = 'Q9Z0F0NXFT3KG3IHUMA4U4LADMILH1CB';
        $this->clientSecret = '5rjidx7nav2mkrz9jo7f56bmj8zuc1r2';
    }

    public function sendOtp(Request $request)
    {
        $phoneNumber = $request->input('phone');
        $countryCode = '+91';  // Assuming country code is +91, modify if needed
        $fullPhoneNumber = $countryCode . $phoneNumber;

        $client = new Client();
        $url = rtrim($this->apiUrl, '/') . '/auth/otp/v1/send';

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'clientId'     => $this->clientId,
                    'clientSecret' => $this->clientSecret,
                ],
                'json' => [
                    'phoneNumber' => $fullPhoneNumber,
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            // Log the response for debugging
            // Log::info("Response Body: " . print_r($body, true));

            if (isset($body['orderId'])) {
                $orderId = $body['orderId'];
                session(['otp_order_id' => $orderId]);
                session(['otp_phone' => $fullPhoneNumber]);

                return response()->json(['message' => 'OTP sent successfully', 'order_id' => $orderId, 'phone' => $fullPhoneNumber], 200);
            } else {
                return response()->json(['message' => 'Failed to send OTP. Please try again.'], 400);
            }
        } catch (RequestException $e) {
            Log::error("Request Exception: " . $e->getMessage());
            return response()->json(['message' => 'Failed to send OTP due to an error.'], 500);
        }
    }
    

public function verifyOtp(Request $request)
{
    // Get orderId, otp, and phoneNumber from request
    $orderId = $request->input('orderId');
    $otp = $request->input('otp');
    $phoneNumber = $request->input('phoneNumber');

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
                // Mobile number exists, authenticate the user
                Auth::guard('temples')->login($temple);

                return response()->json([
                    'message' => 'User authenticated successfully.',
                    'status' => 'success',
                    'redirect_url' => route('templedashboard')
                ], 200);
            } else {
                // Mobile number does not exist, ask to register
                return response()->json([
                    'message' => 'Please complete your registration.',
                    'status' => 'registration_required',
                    'redirect_url' => route('temple-register')
                ], 404);
            }
        } else {
            $message = $body['message'] ?? 'Invalid OTP';
            return response()->json(['message' => $message], 400);
        }
    } catch (RequestException $e) {
        return response()->json([
            'message' => 'Failed to verify OTP due to an error.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
