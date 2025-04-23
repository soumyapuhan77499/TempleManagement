<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NitiMaster;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\NitiManagement;
use App\Models\TempleSubNiti;
use App\Models\TempleSubNitiManagement;
use App\Models\DarshanManagement;
use App\Models\PrasadManagement;
use App\Models\TemplePrasad;
use App\Models\DarshanDetails;
use App\Models\TempleHundi;
use App\Models\TempleNews;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

class TempleNitiController extends Controller
{

public function manageNiti(Request $request)
{
    try {
        $today = Carbon::now('Asia/Kolkata')->toDateString();

        // ✅ Fetch Running Sub Nitis
        $runningSubNitis = TempleSubNitiManagement::where('status', '!=', 'Deleted')
        ->whereDate('date', $today)
        ->whereIn('niti_id', function ($query) {
            $query->select('niti_id')
                  ->from('temple__niti_details')
                  ->whereIn('niti_status', ['Started', 'Paused']);
        })
        ->get();

        // ✅ Get all Daily Nitis
        $dailyNitis = NitiMaster::where('status', 'active')
            ->where('language', 'Odia')
            ->where('niti_type', 'daily')
            ->orderBy('date_time', 'asc')
            ->with([
                'todayStartTime' => function ($query) use ($today) {
                    $query->where('niti_status', 'Started')
                        ->whereDate('date', $today)
                        ->select('niti_id', 'start_time');
                },
                'subNitis'
            ])
            ->get();

        // ✅ Get all Special Nitis grouped by after_special_niti
        $specialNitisGrouped = NitiMaster::where('status', 'active')
        ->where('niti_type', 'special')
        ->where('language', 'Odia')
        ->whereDate('date_time', $today) // ✅ Filter by today's date here
        ->with([
            'todayStartTime' => function ($query) use ($today) {
                $query->where('niti_status', 'Upcoming')
                    ->whereDate('date', $today) // ✅ This is correct for related table (if separate date field exists)
                    ->select('niti_id', 'start_time');
            },
            'subNitis'
        ])
        ->get()
        ->groupBy('after_special_niti');
    

          // ✅ Other Nitis (based on management table status)
          $otherNitis = NitiMaster::where('status', 'active')
        //   ->where('language', 'Odia')
          ->where('niti_type', 'other')
          ->where('niti_status', 'Started')
          ->with(['subNitis'])
          ->whereHas('todayStartTime', function ($query) use ($today) {
              $query->whereDate('date', $today);
          })
          ->get();

          $finalNitiList = [];

        // ✅ Add "Other" Nitis with today's started entry
        foreach ($otherNitis as $otherNiti) {

            $finalNitiList[] = [
                'niti_id'     => $otherNiti->niti_id,
                'niti_name'   => $otherNiti->niti_name,
                'niti_type'   => $otherNiti->niti_type,
                'niti_status' => 'Started',
                'start_time'  => optional($otherNiti->todayStartTime)->start_time,
            ];
        }

        // ✅ Loop through daily Nitis and inject related special Nitis after them
        foreach ($dailyNitis as $dailyNiti) {
            $matchingRunningSubNitis = $runningSubNitis->where('niti_id', $dailyNiti->niti_id);

            $finalNitiList[] = [
                'niti_id'     => $dailyNiti->niti_id,
                'niti_name'   => $dailyNiti->niti_name,
                'niti_type'   => $dailyNiti->niti_type,
                'niti_status' => $dailyNiti->niti_status,
                'start_time'  => optional($dailyNiti->todayStartTime)->start_time,
                'after_special_niti_name' => null,
                'running_sub_niti' => $matchingRunningSubNitis->map(function ($sub) {
                    return [
                        'sub_niti_id'   => $sub->sub_niti_id,
                        'sub_niti_name' => $sub->sub_niti_name,
                        'start_time'    => $sub->start_time,
                        'status'        => $sub->status,
                        'date'          => $sub->date,
                    ];
                })->values()
            ];

            // ✅ Inject special Nitis meant to appear after this daily Niti
            $specialNitis = $specialNitisGrouped->get($dailyNiti->niti_id, collect());

            foreach ($specialNitis as $specialNiti) {
                $matchingSpecialRunningSubNitis = $runningSubNitis->where('niti_id', $specialNiti->niti_id);

                $finalNitiList[] = [
                    'niti_id'     => $specialNiti->niti_id,
                    'niti_name'   => $specialNiti->niti_name,
                    'niti_type'   => $specialNiti->niti_type,
                    'niti_status' => $specialNiti->niti_status,
                    'start_time'  => optional($specialNiti->todayStartTime)->start_time,
                    'after_special_niti_name' => $dailyNiti->niti_name,
                    'running_sub_niti' => $matchingSpecialRunningSubNitis->map(function ($sub) {
                        return [
                            'sub_niti_id'   => $sub->sub_niti_id,
                            'sub_niti_name' => $sub->sub_niti_name,
                            'start_time'    => $sub->start_time,
                            'status'        => $sub->status,
                            'date'          => $sub->date,
                        ];
                    })->values()
                ];
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Niti list ordered with special Nitis inserted after respective daily Nitis.',
            'data' => $finalNitiList
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

        $now = Carbon::now('Asia/Kolkata');

        // Step 1: Start Niti
        $nitiManagement = NitiManagement::create([
            'niti_id'     => $request->niti_id,
            'sebak_id'    => $user->sebak_id,
            'date'        => $now->toDateString(),
            'start_time'  => $now->format('H:i:s'),
            'niti_status' => 'Started'
        ]);

        // Update main Niti status
        $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();
        $nitiMaster->update(['niti_status' => 'Started']);

        // Step 2: Start Interconnected Darshan (if exists)
        $darshanLog = null;
        if ($nitiMaster->connected_darshan_id) {
            $darshanLog = DarshanManagement::create([
                'darshan_id'     => $nitiMaster->connected_darshan_id,
                'sebak_id'       => $user->sebak_id,
                'date'           => $now->toDateString(),
                'start_time'     => $now->format('H:i:s'),
                'darshan_status' => 'Started',
                'temple_id'      => $nitiMaster->temple_id ?? null,
            ]);

            DarshanDetails::where('id', $nitiMaster->connected_darshan_id)
                ->update(['darshan_status' => 'Started']);
        }

        // Step 3: Start Interconnected Mahaprasad (if exists)
        $prasadLog = null;
        if ($nitiMaster->connected_mahaprasad_id) {
            // ✅ Check if a Mahaprasad for today is already Started
            $existingPrasad = PrasadManagement::where('date', $now->toDateString())
                ->where('prasad_status', 'Started')
                ->latest()
                ->first();
        
            if ($existingPrasad) {
                // ✅ Mark the previous one as Completed
                $existingPrasad->update([
                    'prasad_status' => 'Completed',
                ]);
        
                // ✅ Also update master table to Completed
                TemplePrasad::where('prasad_status', 'Started')
                    ->update(['prasad_status' => 'Completed']);
            }
        
            // ✅ Start a new Mahaprasad record
            $prasadLog = PrasadManagement::create([
                'prasad_id'     => $nitiMaster->connected_mahaprasad_id,
                'sebak_id'      => $user->sebak_id,
                'date'          => $now->toDateString(),
                'start_time'    => $now->format('H:i:s'),
                'prasad_status' => 'Started',
                'temple_id'     => $nitiMaster->temple_id ?? null,
            ]);
        
            // ✅ Set current Mahaprasad as Started in master table
            TemplePrasad::where('id', $nitiMaster->connected_mahaprasad_id)
                ->update(['prasad_status' => 'Started']);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Niti and related Darshan/Mahaprasad started successfully.',
            'data' => [
                'niti_management'    => $nitiManagement,
                'darshan_management' => $darshanLog,
                'prasad_management'  => $prasadLog,
            ]
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

        $tz = 'Asia/Kolkata';
        $now = Carbon::now($tz);

        // Get the latest active Niti
        $activeNiti = NitiManagement::where('niti_id', $request->niti_id)
            ->where('sebak_id', $user->sebak_id)
            ->where('niti_status', 'Started')
            ->whereDate('date', $now->toDateString())
            ->latest()
            ->first();

        if (!$activeNiti || !$activeNiti->start_time) {
            return response()->json([
                'status' => false,
                'message' => 'No active Niti found to stop.'
            ], 400);
        }

        // Calculate duration
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $activeNiti->date . ' ' . $activeNiti->start_time, $tz);
        $durationInSeconds = $startDateTime->diffInSeconds($now);

        $hours = floor($durationInSeconds / 3600);
        $minutes = floor(($durationInSeconds % 3600) / 60);
        $seconds = $durationInSeconds % 60;

        $runningTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        $durationText = $hours > 0 ? "{$hours} hr {$minutes} min" : ($minutes > 0 ? "{$minutes} min" : "{$seconds} sec");

        // Save completed Niti entry
        $completedNiti = new NitiManagement();
        $completedNiti->niti_id = $request->niti_id;
        $completedNiti->sebak_id = $user->sebak_id;
        $completedNiti->start_time = $activeNiti->start_time;
        $completedNiti->pause_time = $activeNiti->pause_time;
        $completedNiti->resume_time = $activeNiti->resume_time;
        $completedNiti->date = $now->toDateString();
        $completedNiti->end_time = $now->format('H:i:s');
        $completedNiti->running_time = $runningTime;
        $completedNiti->duration = trim($durationText);
        $completedNiti->niti_status = 'Completed';
        $completedNiti->save();

        // Update Niti master status
        $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();
        $nitiMaster->update(['niti_status' => 'Completed']);

        // ✅ If interconnected Darshan exists, stop it
        $darshanCompleted = null;
        if ($nitiMaster->connected_darshan_id) {
            $activeDarshan = DarshanManagement::where('darshan_id', $nitiMaster->connected_darshan_id)
                ->where('sebak_id', $user->sebak_id)
                ->where('darshan_status', 'Started')
                ->whereDate('date', $now->toDateString())
                ->latest()
                ->first();

            if ($activeDarshan) {
                $darshanStart = Carbon::parse($activeDarshan->date . ' ' . $activeDarshan->start_time);
                $darshanDuration = $darshanStart->diff($now)->format('%H:%I:%S');

                $darshanCompleted = DarshanManagement::create([
                    'darshan_id'     => $nitiMaster->connected_darshan_id,
                    'sebak_id'       => $user->sebak_id,
                    'temple_id'      => $activeDarshan->temple_id ?? null,
                    'date'           => $now->toDateString(),
                    'start_time'     => $activeDarshan->start_time,
                    'end_time'       => $now->format('H:i:s'),
                    'duration'       => $darshanDuration,
                    'darshan_status' => 'Completed',
                ]);

                // Update main Darshan status
                DarshanDetails::where('id', $nitiMaster->connected_darshan_id)->update([
                    'darshan_status' => 'Completed'
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Niti (and Darshan if linked) stopped successfully.',
            'data' => [
                'niti'    => $completedNiti,
                'darshan'=> $darshanCompleted
            ]
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

public function getOtherNiti()
{
    try {
        $otherNitis = NitiMaster::where('niti_type', 'other')
            ->orderBy('date_time', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Other Niti list fetched successfully.',
            'data' => $otherNitis,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch special Niti data.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function storeOtherNiti(Request $request)
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
            ->where('niti_type', 'other')
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
            'niti_type'   => 'other',
            'language'   => 'Odia',
            'niti_privacy'   => 'public',
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
            'message' => 'Other Niti created and started.',
            'data'    => $niti,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to create/update other Niti.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

public function updateActiveNitiToUpcoming()
{
    try {
        // Step 1: Update all Niti records with status 'active' to 'Upcoming'
        $nitiUpdatedCount = NitiMaster::where('status', 'active')
            ->update(['niti_status' => 'Upcoming']);

        // Step 2: Update all Darshan records where status is 'active' to darshan_status = 'Upcoming'
        $darshanUpdatedCount = DarshanDetails::where('status', 'active')
            ->update(['darshan_status' => 'Upcoming']);

        // Step 3: Update all Prasad records where prasad_status is 'active' to 'Upcoming'
        $prasadUpdatedCount = TemplePrasad::where('prasad_status', 'active')
            ->update(['prasad_status' => 'Upcoming']);

        return response()->json([
            'status' => true,
            'message' => 'All statuses updated to Upcoming.',
            'updated_records' => [
                'niti' => $nitiUpdatedCount,
                'darshan' => $darshanUpdatedCount,
                'prasad' => $prasadUpdatedCount,
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to update statuses.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function startSubNiti(Request $request)
{
    try {
        $request->validate([
            'sub_niti_id' => 'required|integer|exists:temple__sub_niti,id'
        ]);

        // Get current authenticated sebak
        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Sebak not logged in.'
            ], 401);
        }

        $now = Carbon::now('Asia/Kolkata');

        // Fetch Sub Niti
        $subNiti = TempleSubNiti::where('id', $request->sub_niti_id)->first();

        if (!$subNiti) {
            return response()->json([
                'status' => false,
                'message' => 'Sub Niti not found.'
            ], 404);
        }

        $today = $now->toDateString();

        // ✅ Check if any sub-niti of same niti_id is running today
        $existingRunning = TempleSubNitiManagement::where('niti_id', $subNiti->niti_id)
            ->whereDate('date', $today)
            ->where('status', 'Running')
            ->latest()
            ->first();

        // ✅ Mark it as completed if found
        if ($existingRunning) {
            $existingRunning->update([
                'status'   => 'Completed',
            ]);
        }

        // ✅ Insert the new sub-niti as Running
        $record = TempleSubNitiManagement::create([
            'sebak_id'       => $user->sebak_id,
            'niti_id'        => $subNiti->niti_id,
            'sub_niti_id'    => $subNiti->id,
            'sub_niti_name'  => $subNiti->sub_niti_name,
            'date'           => $today,
            'start_time'     => $now->format('H:i:s'),
            'status'         => 'Running',
        ]);

            // Step 1: Mark all other Sub Nitis under same Niti as Completed (if running)
        TempleSubNiti::where('niti_id', $subNiti->niti_id)
        ->where('status', 'Running')
        ->where('id', '!=', $subNiti->id) // exclude current sub_niti
        ->update(['status' => 'Completed']);

        // Step 2: Set current sub_niti as Running
        TempleSubNiti::where('id', $request->sub_niti_id)->update([
        'status' => 'Running'
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Sub Niti started successfully.',
            'data'    => $record
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to start Sub Niti.',
            'error'   => $e->getMessage()
        ], 500);
    }
}

public function addAndStartSubNiti(Request $request)
{
    try {
        // Validate input
        $request->validate([
            'niti_id'        => 'required|string|exists:temple__niti_details,niti_id',
            'sub_niti_name'  => 'required|string|max:255',
        ]);

        $user = Auth::guard('niti_admin')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        $now = Carbon::now('Asia/Kolkata');

        $today = $now->toDateString();

        // ✅ Step 1: Check if another Sub Niti under same Niti is Running today
        $existingRunning = TempleSubNitiManagement::where('niti_id', $request->niti_id)
            ->whereDate('date', $today)
            ->where('status', 'Running')
            ->latest()
            ->first();

        if ($existingRunning) {
            // ✅ Mark it as Completed with end_time
            $existingRunning->update([
                'status'   => 'Completed',
            ]);
        }

        // ✅ Step 2: Save to temple__sub_niti
        $subNiti = TempleSubNiti::create([
            // 'temple_id'      => $user->temple_id ?? null,
            'niti_id'        => $request->niti_id,
            'sub_niti_name'  => $request->sub_niti_name,
        ]);

        // ✅ Step 3: Save to temple__sub_niti_management
        $management = TempleSubNitiManagement::create([
            // 'temple_id'       => $user->temple_id ?? null,
            'sebak_id'        => $user->sebak_id,
            'niti_id'         => $request->niti_id,
            'sub_niti_id'     => $subNiti->id,
            'sub_niti_name'   => $subNiti->sub_niti_name,
            'date'            => $today,
            'start_time'      => $now->format('H:i:s'),
            'status'          => 'Running'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Sub Niti added and started successfully.',
            'data' => [
                'sub_niti' => $subNiti,
                'management' => $management
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to add and start Sub Niti.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function updateSubNitiName(Request $request, $id)
{
    try {
        // Validate request
        $request->validate([
            'sub_niti_name' => 'required|string|max:255',
        ]);

        // Find the record by ID
        $subNiti = TempleSubNitiManagement::where('sub_niti_id', $id)
            ->where('status', '!=', 'Deleted')
            ->first();

        if (!$subNiti) {
            return response()->json([
                'status' => false,
                'message' => 'Sub Niti record not found.'
            ], 404);
        }

        // Update the sub_niti_name
        $subNiti->sub_niti_name = $request->sub_niti_name;
        $subNiti->save();

        return response()->json([
            'status' => true,
            'message' => 'Sub Niti name updated successfully.',
            'data' => $subNiti
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error updating Sub Niti name.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function softDeleteSubNiti($id)
{
    try {
        
        $subNiti = TempleSubNitiManagement::where('sub_niti_id', $id)
        ->where('status', '!=', 'Deleted')
        ->first();

        if (!$subNiti) {
            return response()->json([
                'status' => false,
                'message' => 'Sub Niti record not found.'
            ], 404);
        }

        // Update the status to "Deleted"
        $subNiti->status = 'Deleted';
        $subNiti->save();

        return response()->json([
            'status' => true,
            'message' => 'Sub Niti soft-deleted successfully.',
            'data' => $subNiti
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error soft deleting Sub Niti.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function storeByNoticeName(Request $request)
{
   
    try {
        $news = TempleNews::create([
            'notice_name' => $request->notice_name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Temple news created successfully.',
            'data' => $news
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function getLatestNotice()
{
    try {
        $latestNotice = TempleNews::orderBy('created_at', 'desc')->get();

        if (!$latestNotice) {
            return response()->json([
                'status' => false,
                'message' => 'No notice found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Latest notice fetched successfully.',
            'data' => $latestNotice
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch latest notice.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function store(Request $request)
{
  
    try {

        $hundi = TempleHundi::create([
            'date'      => $request->date,
            'rupees'    => $request->rupees,
            'gold'      => $request->gold,
            'silver'    => $request->silver,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Hundi collection saved successfully.',
            'data' => $hundi
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function index()
{
    try {
        $hundiRecords = TempleHundi::orderBy('date', 'desc')->get();

        if ($hundiRecords->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No hundi records found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Hundi records fetched successfully.',
            'data' => $hundiRecords
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch hundi records.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function updateNoticeName(Request $request)
{
    $request->validate([
        'id' => 'required|exists:temple__news,id',
        'notice_name' => 'required|string|max:255',
    ]);

    try {
        $news = TempleNews::findOrFail($request->id);
        $news->notice_name = $request->notice_name;
        $news->save();

        return response()->json([
            'status' => true,
            'message' => 'Notice name updated successfully.',
            'data' => $news
        ],200);

        
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to update notice name.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function updateHundiCollection(Request $request)
{
    $request->validate([
        'id'     => 'required|exists:temple__hundi_notice,id',
        'date'   => 'required|date',
        'rupees' => 'nullable|numeric',
        'gold'   => 'nullable|numeric',
        'silver' => 'nullable|numeric',
    ]);

    try {
        $hundi = TempleHundi::findOrFail($request->id);

        $hundi->update([
            'date'   => $request->date,
            'rupees' => $request->rupees,
            'gold'   => $request->gold,
            'silver' => $request->silver,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Hundi collection updated successfully.',
            'data'    => $hundi
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Failed to update hundi collection.',
            'error'   => $e->getMessage()
        ], 500);
    }
}

}
