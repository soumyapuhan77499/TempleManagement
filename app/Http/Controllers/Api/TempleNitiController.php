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

        $today = now()->toDateString();

        // Fetch Nitis with additional 'start_time' if started today
        $nitis = NitiMaster::where('status', 'active')
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
            ->orderBy('date_time', 'desc') // Order by date_time ascending
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
        $nitiManagement->date = Carbon::now()->setTimezone('Asia/Kolkata')->toDateString();
        $nitiManagement->start_time = Carbon::now()->setTimezone('Asia/Kolkata')->format('H:i:s');
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
        $pausedNiti->start_time = $startedNiti->start_time; // Keep the start time from the started entry
        $pausedNiti->date = Carbon::now()->setTimezone('Asia/Kolkata')->toDateString();
        $pausedNiti->pause_time = Carbon::now()->setTimezone('Asia/Kolkata')->format('H:i:s');

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
        $resumedNiti->start_time = $pausedNiti->start_time; // Keep the start time from the paused entry
        $resumedNiti->pause_time = $pausedNiti->pause_time; // Keep the pause time from the paused entry
        $resumedNiti->date = Carbon::now()->setTimezone('Asia/Kolkata')->toDateString();
        $resumedNiti->resume_time = Carbon::now()->setTimezone('Asia/Kolkata')->format('H:i:s');
        $resumedNiti->niti_status = 'Started';
        $resumedNiti->save();

        // ✅ Update master table
        NitiMaster::where('niti_id', $request->niti_id)->update([
            'niti_status' => 'Started'
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

        // Get the latest active Niti
        $activeNiti = NitiManagement::where('niti_id', $request->niti_id)
            ->where('sebak_id', $user->sebak_id)
            ->whereIn('niti_status', ['Started', 'Resumed'])
            ->whereDate('date', Carbon::today('Asia/Kolkata'))
            ->latest()
            ->first();

        if (!$activeNiti || (!$activeNiti->start_time && !$activeNiti->resume_time)) {
            return response()->json([
                'status' => false,
                'message' => 'No active Niti found to stop.'
            ], 400);
        }

        // Set timezone and timestamps
        $tz = 'Asia/Kolkata';
        $startTime = $activeNiti->resume_time ?? $activeNiti->start_time;
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $activeNiti->date . ' ' . $startTime, $tz);
        $endDateTime = Carbon::now($tz);

        // Calculate total difference in seconds
        $diffInSeconds = $startDateTime->diffInSeconds($endDateTime);

        // Calculate running_time in "HH:MM:SS" format manually
        $hours = floor($diffInSeconds / 3600);
        $minutes = floor(($diffInSeconds % 3600) / 60);
        $seconds = $diffInSeconds % 60;
        $runningTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        // Human-readable duration like "2 hr 5 min"
        $durationText = '';
        if ($hours > 0) {
            $durationText .= $hours . ' hr ';
        }
        if ($minutes > 0 || $hours > 0) {
            $durationText .= $minutes . ' min';
        } else {
            $durationText .= $seconds . ' sec';
        }

        // Save completed Niti entry
        $completedNiti = new NitiManagement();
        $completedNiti->niti_id = $request->niti_id;
        $completedNiti->sebak_id = $user->sebak_id;
        $completedNiti->start_time = $activeNiti->start_time;
        $completedNiti->pause_time = $activeNiti->pause_time;
        $completedNiti->resume_time = $activeNiti->resume_time;
        $completedNiti->date = $endDateTime->toDateString();
        $completedNiti->end_time = $endDateTime->format('H:i:s');
        $completedNiti->running_time = $runningTime;
        $completedNiti->duration = $durationText;
        $completedNiti->niti_status = 'Completed';
        $completedNiti->save();

        // Update master table
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

public function completedNiti()
{
    try {
        $today = now()->toDateString();

        // Fetch completed Niti entries for today along with related Niti name
        $completed = NitiManagement::with('master:niti_id,niti_name')
            ->where('niti_status', 'Completed')
            ->whereDate('date', $today)
            ->get()
            ->map(function ($item) {
                return [
                    'niti_id'       => $item->niti_id,
                    'niti_name'     => optional($item->master)->niti_name,
                    'sebak_id'      => $item->sebak_id,
                    'date'          => $item->date,
                    'start_time'    => $item->start_time,
                    'end_time'      => $item->end_time,
                    'duration'      => $item->duration,
                    'niti_status'   => $item->niti_status,
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Completed Niti list for today fetched successfully.',
            'data' => $completed,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch completed Niti data.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getSpecialNiti()
{
    try {
        $specialNitis = NitiMaster::where('niti_type', 'special')
            ->orderBy('date_time', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Special Niti list fetched successfully.',
            'data' => $specialNitis,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch special Niti data.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function storeSpecialNiti(Request $request)
{
    try {
        // Validate input
        $request->validate([
            'niti_name' => 'required|string|max:255',
            'niti_id'   => 'nullable|string',
        ]);

        // Get current IST time
        $now = Carbon::now()->setTimezone('Asia/Kolkata');

        // Get current sebak (assuming logged in as 'niti_admin' guard)
        $user = Auth::guard('niti_admin')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please login as Sebak.',
            ], 401);
        }

        // If niti_id exists, update status and log management
        if ($request->filled('niti_id')) {
            $niti = NitiMaster::where('niti_id', $request->niti_id)->first();

            if ($niti) {
                $niti->update([
                    'niti_status' => 'Started',
                ]);

                // Insert transaction into NitiManagement
                NitiManagement::create([
                    'niti_id'     => $niti->niti_id,
                    'sebak_id'    => $user->sebak_id,
                    'niti_status' => 'Started',
                    'date'        => $now->toDateString(),
                    'start_time'  => $now->format('H:i:s'),
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Special Niti updated and started.',
                    'data'    => $niti,
                ], 200);
            }
        }

        // Check if the Niti name already exists
        $existingNiti = NitiMaster::where('niti_name', $request->niti_name)
            ->where('niti_type', 'special')
            ->first();

        if ($existingNiti) {
            return response()->json([
                'status'  => false,
                'message' => 'Niti name already exists. Please update instead.',
            ], 409);
        }

        // Create new NitiMaster record
        $niti = NitiMaster::create([
            'niti_id'     => 'NITI' . rand(10000, 99999),
            'niti_name'   => $request->niti_name,
            'niti_type'   => 'special',
            'niti_status' => 'Started',
            'date_time'   => $now->format('Y-m-d H:i:s'),
        ]);

        // Insert into NitiManagement
        NitiManagement::create([
            'niti_id'     => $niti->niti_id,
            'sebak_id'    => $user->sebak_id,
            'niti_status' => 'Started',
            'date'        => $now->toDateString(),
            'start_time'  => $now->format('H:i:s'),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Special Niti created and started.',
            'data'    => $niti,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to create/update special Niti.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}



}
