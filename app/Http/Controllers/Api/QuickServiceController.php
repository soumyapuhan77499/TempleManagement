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
                ->get();

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
                ->get();

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
                ->get();

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
                ->get();

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

            $prasadas = TemplePrasad::where('temple_id', $templeId)->get();

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
