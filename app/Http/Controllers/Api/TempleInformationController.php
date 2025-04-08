<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TempleFestival;
use App\Models\Matha;
use App\Models\NijogaMaster;
use App\Models\TempleAboutDetail;
use App\Models\NearByTemple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TempleInformationController extends Controller
{
    public function getFestival(Request $request)
    {
        try {

            $templeId = 'TEMPLE25402';

            if (!$templeId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Temple ID is required.',
                ], 400);
            }

            $festivals = TempleFestival::where('temple_id', $templeId)
                ->where('status', 'active')
                ->with('subFestivals')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Festivals fetched successfully.',
                'data' => $festivals,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error in getFestival API: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMathaList(Request $request)
    {
        try {

            $templeId = 'TEMPLE25402';

            if (!$templeId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Temple ID is required.',
                ], 400);
            }

            $mathas = Matha::where('temple_id', $templeId)
                ->where('status', 'active')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Matha list fetched successfully.',
                'data' => $mathas
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching matha list: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getNijogaList(Request $request)
    {
        try {
            $templeId = 'TEMPLE25402';

            if (!$templeId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Temple ID is required.',
                ], 400);
            }

            $nijogas = NijogaMaster::where('temple_id', $templeId)
                ->where('status', 'active')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Nijoga list fetched successfully.',
                'data' => $nijogas
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error fetching nijoga list: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTempleAbout(Request $request)
    {
        try {
            $templeId = 'TEMPLE25402';

            if (!$templeId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Temple ID is required.'
                ], 400);
            }

            $temple = TempleAboutDetail::where('temple_id', $templeId)->first();

            if (!$temple) {
                return response()->json([
                    'status' => false,
                    'message' => 'No temple about information found.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Temple about details fetched successfully.',
                'data' => $temple
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error fetching temple about: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getNearbyTemples()
    {
        try {

            $templeId = 'TEMPLE25402';

            $nearbyTemples = NearByTemple::where('status', 'active')
                ->where('temple_id', $templeId)
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Nearby temples fetched successfully.',
                'data' => $nearbyTemples
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
