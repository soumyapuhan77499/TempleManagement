<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\NitiadminLogin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TempleNitiLoginController extends Controller
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
        // Validate input
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid phone number.'], 422);
        }

        $phoneNumber = $request->input('phone');
        $countryCode = '+91';
        $fullPhoneNumber = $countryCode . $phoneNumber;

        // Check if phone number exists in DB
        $temple = NitiadminLogin::where('mobile_no', $phoneNumber)->first();
        if (!$temple) {
            return response()->json(['message' => 'Mobile number is not registered.'], 404);
        }

        $client = new Client();
        $url = rtrim($this->apiUrl, '/') . '/auth/otp/v1/send';

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'clientId' => $this->clientId,
                    'clientSecret' => $this->clientSecret,
                ],
                'json' => [
                    'phoneNumber' => $fullPhoneNumber,
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            if (isset($body['orderId'])) {
                session(['otp_order_id' => $body['orderId']]);
                session(['otp_phone' => $fullPhoneNumber]);

                return response()->json([
                    'message' => 'OTP sent successfully.',
                    'order_id' => $body['orderId'],
                    'phone' => $fullPhoneNumber
                ], 200);
            }

            return response()->json(['message' => 'Failed to send OTP.'], 400);
        } catch (RequestException $e) {
            Log::error("OTP Send Error: " . $e->getMessage());
            return response()->json(['message' => 'Error while sending OTP.'], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderId' => 'required|string',
            'otp' => 'required|digits:6',
            'phoneNumber' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input for OTP verification.'], 422);
        }

        $orderId = $request->input('orderId');
        $otp = $request->input('otp');
        $phoneNumber = $request->input('phoneNumber');

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
                $cleanPhone = str_replace('+91', '', $phoneNumber);
                $temple = NitiadminLogin::where('mobile_no', $cleanPhone)->first();

                if ($temple) {
                    $token = $temple->createToken('Temple User Token')->plainTextToken;
                    return response()->json([
                        'message' => 'OTP verified successfully.',
                        'user' => $temple,
                        'token' => $token,
                        'token_type' => 'Bearer'
                    ], 200);
                } else {
                    return response()->json(['message' => 'Mobile number not found.'], 404);
                }
            } else {
                return response()->json(['message' => $body['message'] ?? 'OTP verification failed.'], 400);
            }
        } catch (RequestException $e) {
            Log::error("OTP Verify Error: " . $e->getMessage());
            return response()->json(['message' => 'Error during OTP verification.'], 500);
        }
    }
}
