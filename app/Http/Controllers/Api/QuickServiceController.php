<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Parking;
use App\Models\Accomodation;
use App\Models\CommuteMode;
use App\Models\PublicServices;
use App\Models\EmergencyContact;
use App\Models\TemplePrasad;
use App\Models\PanjiDetails;
use App\Models\TempleDarshan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuickServiceController extends Controller
{
    public function getParkingList(Request $request)
    {
        try {
    
            $templeId = 'TEMPLE25402';
    
            if (!$templeId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Temple ID is required.',
                ], 400);
            }
    
            $parkings = Parking::where('temple_id', $templeId)
                ->where('status', 'active')
                ->get()
                ->map(function ($parking) {
                    // Prefix the parking_photo with the base URL
                    if ($parking->parking_photo) {
                        $parking->parking_photo = 'http://temple.mandirparikrama.com/' . ltrim($parking->parking_photo, '/');
                    }
    
                    return $parking;
                });
    
            return response()->json([
                'status' => true,
                'message' => 'Parking list fetched successfully.',
                'data' => $parkings
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching parking list: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function getAccomodationList(Request $request)
    {
        try {
            $templeId = 'TEMPLE25402';
    
            if (!$templeId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Temple ID is required.'
                ], 400);
            }
    
            $accomodations = Accomodation::where('temple_id', $templeId)
                ->where('status', 'active')
                ->get()
                ->map(function ($accomodation) {
                    // Decode the photo JSON string
                    $photos = json_decode($accomodation->photo, true);
    
                    if (is_array($photos)) {
                        $imageUrls = array_map(function ($path) {
                            return "http://temple.mandirparikrama.com/" . ltrim($path, '/');
                        }, $photos);
                    } else {
                        $imageUrls = [];
                    }
    
                    // Add images array to the response
                    $accomodation->images = $imageUrls;
    
                    // Optionally remove the original `photo` field
                    unset($accomodation->photo);
    
                    return $accomodation;
                });
    
            return response()->json([
                'status' => true,
                'message' => 'Accomodation list fetched successfully.',
                'data' => $accomodations
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('Error fetching accomodations: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getCommuteList(Request $request)
    {
        try {
            $templeId = 'TEMPLE25402';
    
            if (!$templeId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Temple ID is required.'
                ], 400);
            }
    
            $commutes = CommuteMode::where('temple_id', $templeId)
                ->where('status', 'active')
                ->get()
                ->map(function ($commute) {
                    // Decode photo array if it's stored as JSON string
                    $photos = is_string($commute->photo) ? json_decode($commute->photo, true) : $commute->photo;
    
                    // Assign first photo or null, and prepend base URL
                    $commute->photo = isset($photos[0])
                        ? 'http://temple.mandirparikrama.com/' . ltrim($photos[0], '/')
                        : null;
    
                    return $commute;
                });
    
            return response()->json([
                'status' => true,
                'message' => 'Commute list fetched successfully.',
                'data' => $commutes
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('Error fetching commute list: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function getEmergencyContacts(Request $request)
    {
        try {
            $templeId = 'TEMPLE25402';

            if (!$templeId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Temple ID is required.'
                ], 400);
            }

            $contacts = EmergencyContact::where('temple_id', $templeId)
                ->where('status', 'active')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Emergency contacts fetched successfully.',
                'data' => $contacts
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error fetching emergency contacts: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPublicServiceList(Request $request)
{
    try {
        $templeId = 'TEMPLE25402';

        if (!$templeId) {
            return response()->json([
                'status' => false,
                'message' => 'Temple ID is required.'
            ], 400);
        }

        $services = PublicServices::where('temple_id', $templeId)
            ->where('status', 'active')
            ->get()
            ->map(function ($service) {
                $photoArray = json_decode($service->photo, true);

                if ($service->service_type === 'beach') {
                    // Return full URL for each photo in array
                    $service->photo = array_map(function ($path) {
                        return 'http://temple.mandirparikrama.com/' . ltrim($path, '/');
                    }, $photoArray ?? []);
                } else {
                    // Return only the first image as a string
                    $service->photo = isset($photoArray[0])
                        ? 'http://temple.mandirparikrama.com/' . ltrim($photoArray[0], '/')
                        : null;
                }

                return $service;
            });

        return response()->json([
            'status' => true,
            'message' => 'Public services fetched successfully.',
            'data' => $services
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error fetching public services: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Internal Server Error',
            'error' => $e->getMessage()
        ], 500);
    }
}

    

public function getTemplePrasadList(Request $request)
{
    try {
        $templeId = 'TEMPLE25402';

        if (!$templeId) {
            return response()->json([
                'status' => false,
                'message' => 'Temple ID is required.'
            ], 400);
        }

        $prasadas = TemplePrasad::where('temple_id', $templeId)->get()->map(function ($prasad) {
            // Prepend the full URL to the prasad photo path
            $prasad->prasad_photo = url( $prasad->prasad_photo);
            return $prasad;
        });

        return response()->json([
            'status' => true,
            'message' => 'Temple prasad list fetched successfully.',
            'data' => $prasadas
        ], 200);

    } catch (\Exception $e) {

        Log::error('Error fetching prasad list: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Internal Server Error',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function getPanji()
{
    try {
        $events = PanjiDetails::where('status', 'active')->get();

        return response()->json([
            'status' => true,
            'message' => 'Panji details fetched successfully.',
            'data' => $events,
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error fetching Panji details: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong while fetching Panji details.',
        ], 500);
    }
}
public function getDarshan()
{
    try {
        $templeId = 'TEMPLE25402';

        $darshans = TempleDarshan::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get();

        // Map through the darshans to update the image path
        $darshans = $darshans->map(function ($darshan) {
            // Prepend the full URL to the darshan image path
            $darshan->darshan_image = url($darshan->darshan_image);
            return $darshan;
        });

        // Group darshans by darshan_day
        $groupedDarshans = $darshans->groupBy('darshan_day');

        return response()->json([
            'status' => true,
            'message' => 'Darshan details fetched successfully.',
            'data' => [
                'groupedDarshans' => $groupedDarshans,
            ]
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error fetching Darshan details: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong while fetching Darshan details.',
        ], 500);
    }
}

}
