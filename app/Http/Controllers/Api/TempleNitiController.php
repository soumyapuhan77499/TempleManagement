<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NitiMaster;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\NitiManagement;
use Carbon\Carbon;

class TempleNitiController extends Controller
{
    public function manageNiti(Request $request)
{
    try {
        $templeId = 'TEMPLE25402'; // You can make this dynamic using Auth if needed

        $nitis = NitiMaster::where('status', 'active')
        ->where('temple_id', $templeId)
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->where('niti_type', 'daily')
                  ->where('niti_status', 'Upcoming');
            })->orWhere(function ($q) {
                $q->where('niti_type', 'special')
                  ->where('niti_status', 'Started');
            });
        })
        ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Niti list fetched successfully.',
            'data' => $nitis
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error fetching Niti list: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong while fetching Niti data.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function startNiti(Request $request)
{
    try {
        // Validate request
        $request->validate([
            'niti_id' => 'required|string|exists:temple__niti_details,niti_id',
        ]);

        // Authenticated user from sanctum guard 'niti_admin'
        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        // Create a new entry in temple__niti_management
        $nitiManagement = new NitiManagement();
        $nitiManagement->niti_id = $request->niti_id;
        $nitiManagement->sebak_id = $user->sebak_id;
        $nitiManagement->date = Carbon::now()->toDateString();
        $nitiManagement->start_time = Carbon::now()->format('H:i:s');
        $nitiManagement->niti_status = 'Started';
        $nitiManagement->save();

        NitiMaster::where('niti_id', $request->niti_id)->update([
            'niti_status' => 'Started'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Niti started successfully.',
            'data' => $nitiManagement
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to start Niti.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
