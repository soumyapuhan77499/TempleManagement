<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Parking;
use App\Models\Accomodation;
use App\Models\NitiMaster;
use App\Models\CommuteMode;
use App\Models\PublicServices;
use App\Models\EmergencyContact;
use App\Models\TemplePrasad;
use App\Models\PanjiDetails;
use App\Models\TempleDarshan;
use App\Models\DarshanDetails;
use App\Models\DarshanManagement;
use App\Models\PrasadManagement;
use App\Models\TemplePrasadItem;
use App\Models\TemplePrasadManagement;
use Carbon\Carbon;

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
                ->where('language', $request->language)
                ->get()
                ->map(function ($parking) {
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
                ->where('language', $request->language)
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
                ->where('language', $request->language)
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
                ->where('language', $request->language)
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

    public function getTemplePrasadList()
    {
        try {
            $nitiMaster = NitiMaster::where('status', 'active')->latest()->first();

            if (!$nitiMaster || !$nitiMaster->day_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Niti not found or day_id missing.'
                ], 404);
            }

            $dayId = $nitiMaster->day_id;
            // Step 1: Get all Prasad master records
            $prasads = TemplePrasad::where('language','Odia')->get();

            // Step 2: Attach today's PrasadManagement data
            $prasadList = $prasads->map(function ($prasad) use ($dayId) {
                $todayLog = PrasadManagement::where('prasad_id', $prasad->id)
                ->where('day_id', $dayId)
                ->where('language', $request->language)
                ->latest()
                ->first();

                return [
                    'prasad_id'     => $prasad->id,
                    'prasad_name'   => $prasad->prasad_name,
                    'english_prasad_name'   => $prasad->english_prasad_name,
                    'prasad_type'   => $prasad->prasad_type,
                    'prasad_photo'  => $prasad->prasad_photo,
                    'prasad_item'   => $prasad->prasad_item,
                    'description'   => $prasad->description,
                    'online_order'  => $prasad->online_order,
                    'pre_order'     => $prasad->pre_order,
                    'offline_order' => $prasad->offline_order,
                    'master_prasad_status' => $prasad->prasad_status,
                    'today_status'  => $prasad->prasad_status ?? null,
                    'start_time'    => $todayLog->start_time ?? null,
                    'date'          => $todayLog->date ?? null,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Filtered Prasad list fetched successfully.',
                'data' => $prasadList
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch prasad list.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPanji($language, $date)
    {
        try {
    
            // Fetch matching Panji records
            $Events = PanjiDetails::where('status', 'active')
                ->where('language', $language)
                ->whereDate('date', $date)
                ->get();
    
            return response()->json([
                'status' => true,
                'message' => 'Panji details fetched successfully.',
                'data' => [
                    'Events' => $Events,
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching Panji details: ' . $e->getMessage());
    
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while fetching Panji details.',
                'error' => $e->getMessage()
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

    public function getDarshanListApi()
    {
        try {

            $nitiMaster = NitiMaster::where('status', 'active')->latest()->first();

            if (!$nitiMaster || !$nitiMaster->day_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Niti not found or day_id missing.'
                ], 404);
            }

            $dayId = $nitiMaster->day_id;

            // Step 1: Fetch all active darshans
            $darshans = DarshanDetails::where('status', 'active')->where('language','Odia')->get();

            // Step 2: Append today’s management data (if available)
            $darshanList = $darshans->map(function ($darshan) use ($dayId) {
                $todayLog = DarshanManagement::where('darshan_id', $darshan->id)
                ->where('day_id', $dayId)
                ->latest()
                    ->first();

                return [
                    'darshan_id'     => $darshan->id,
                    'darshan_name'   => $darshan->darshan_name,
                    'english_darshan_name'   => $darshan->english_darshan_name,
                    'darshan_type'   => $darshan->darshan_type,
                    'description'    => $darshan->description,
                    'darshan_status' => $darshan->darshan_status ?? null,
                    'start_time'     => $todayLog->start_time ?? null,
                    'end_time'       => $todayLog->end_time ?? null,
                    'duration'       => $todayLog->duration ?? null,
                    'date'           => $todayLog->date ?? null,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Darshan list fetched successfully.',
                'data' => $darshanList
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch darshan list',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}