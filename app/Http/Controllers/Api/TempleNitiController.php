<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NitiMaster;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\NitiManagement;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

class TempleNitiController extends Controller
{

    public function manageNiti(Request $request)
    {
        try {
            $templeId = 'TEMPLE25402';
    
            $today = now()->toDateString();
    
            // Fetch Nitis with additional 'start_time' if started today
            $nitis = NitiMaster::where('status', 'active')
                ->where('temple_id', $templeId)
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('niti_type', 'daily');
                    })->orWhere(function ($q) {
                        $q->where('niti_type', 'special')
                            ->where('niti_status', 'Started');
                    });
                })
                ->with(['todayStartTime' => function ($query) use ($today) {
                    $query->where('niti_status', 'Started')
                          ->whereDate('date', $today)
                          ->select('niti_id', 'start_time');
                }])
                ->get()
                ->map(function ($niti) {
                    return [
                        'niti_id'     => $niti->niti_id,
                        'niti_name'   => $niti->niti_name,
                        'niti_type'   => $niti->niti_type,
                        'niti_status' => $niti->niti_status,
                        'start_time'  => optional($niti->todayStartTime)->start_time,
                    ];
                });
    
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


public function pauseNiti(Request $request)
{
    try {
        // Validate input
        $request->validate([
            'niti_id' => 'required|string|exists:temple__niti_details,niti_id',
        ]);

        // Get authenticated Niti Admin
        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        // Check if there is any Niti in 'Started' state for the given Niti ID
        $startedNiti = NitiManagement::where('niti_id', $request->niti_id)
        ->where('niti_status', 'Started')
        ->whereDate('date', Carbon::today())  // ✅ Filter by today's date
        ->latest()
        ->first();

        if (!$startedNiti) {
            return response()->json([
                'status' => false,
                'message' => 'This Niti is not in Started state by any Sebak.'
            ], 400);
        }

        // ✅ Insert new row for paused state for the current sebak
        $pausedNiti = new NitiManagement();
        $pausedNiti->niti_id = $request->niti_id;
        $pausedNiti->sebak_id = $user->sebak_id;
        $pausedNiti->date = Carbon::now()->toDateString();
        $pausedNiti->pause_time = Carbon::now()->format('H:i:s');
        $pausedNiti->niti_status = 'Paused';
        $pausedNiti->save();

        // ✅ Update main NitiMaster status as well
        NitiMaster::where('niti_id', $request->niti_id)->update([
            'niti_status' => 'Paused'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Niti paused successfully and logged as new entry.',
            'data' => $pausedNiti
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to pause Niti.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function resumeNiti(Request $request)
{
    try {
        // Validate request
        $request->validate([
            'niti_id' => 'required|string|exists:temple__niti_details,niti_id',
        ]);

        // Get authenticated Niti Admin
        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        // Check if a Paused Niti exists for today
        $pausedNiti = NitiManagement::where('niti_id', $request->niti_id)
            ->where('niti_status', 'Paused')
            ->whereDate('date', Carbon::today())
            ->latest()
            ->first();

        if (!$pausedNiti) {
            return response()->json([
                'status' => false,
                'message' => 'No paused Niti found for today.'
            ], 400);
        }

        // ✅ Insert new record for resumed state
        $resumedNiti = new NitiManagement();
        $resumedNiti->niti_id = $request->niti_id;
        $resumedNiti->sebak_id = $user->sebak_id;
        $resumedNiti->date = Carbon::today()->toDateString();
        $resumedNiti->resume_time = Carbon::now()->format('H:i:s');
        $resumedNiti->niti_status = 'Resumed';
        $resumedNiti->save();

        // ✅ Update master table
        NitiMaster::where('niti_id', $request->niti_id)->update([
            'niti_status' => 'Resumed'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Niti resumed successfully.',
            'data' => $resumedNiti
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to resume Niti.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function stopNiti(Request $request)
{
    try {
        // Validate request
        $request->validate([
            'niti_id' => 'required|string|exists:temple__niti_details,niti_id',
        ]);

        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        // Get the latest started/resumed Niti for today for this user
        $activeNiti = NitiManagement::where('niti_id', $request->niti_id)
            ->where('sebak_id', $user->sebak_id)
            ->whereIn('niti_status', ['Started', 'Resumed'])
            ->whereDate('date', Carbon::today())
            ->latest()
            ->first();

        if (!$activeNiti || !$activeNiti->start_time && !$activeNiti->resume_time) {
            return response()->json([
                'status' => false,
                'message' => 'No active Niti found to stop.'
            ], 400);
        }

        // Determine the starting point (start_time or resume_time)
        $startTime = $activeNiti->resume_time ?? $activeNiti->start_time;
        $startDateTime = Carbon::parse($activeNiti->date . ' ' . $startTime);
        $endDateTime = Carbon::now();

        // Calculate time difference
        $runningTime = $startDateTime->diff($endDateTime);
        $formattedRunningTime = $runningTime->format('%H:%I:%S');

        // Save new completed entry
        $completedNiti = new NitiManagement();
        $completedNiti->niti_id = $request->niti_id;
        $completedNiti->sebak_id = $user->sebak_id;
        $completedNiti->date = Carbon::today()->toDateString();
        $completedNiti->end_time = $endDateTime->format('H:i:s');
        $completedNiti->running_time = $formattedRunningTime;
        $completedNiti->duration = $formattedRunningTime;
        $completedNiti->niti_status = 'Completed';
        $completedNiti->save();

        // Update NitiMaster
        NitiMaster::where('niti_id', $request->niti_id)->update([
            'niti_status' => 'Completed'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Niti stopped and completed successfully.',
            'data' => $completedNiti
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to stop Niti.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
