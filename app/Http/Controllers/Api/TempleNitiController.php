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
        // Get latest active day_id from any active Niti (or generate logic separately)
        $latestDayId = NitiMaster::where('status', 'active')->latest('id')->value('day_id');

        if (!$latestDayId) {
            return response()->json([
                'status' => false,
                'message' => 'No active Niti found to determine day_id.'
            ], 404);
        }

        // ✅ Fetch Running Sub Nitis by day_id
        $runningSubNitis = TempleSubNitiManagement::where('status', '!=', 'Deleted')
            ->where('day_id', $latestDayId)
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
                'todayStartTime' => function ($query) use ($latestDayId) {
                    $query->where('niti_status', 'Started')
                        ->where('day_id', $latestDayId)
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
                'todayStartTime' => function ($query) use ($latestDayId) {
                    $query->where('niti_status', 'Upcoming')
                        ->where('day_id', $latestDayId)
                        ->select('niti_id', 'start_time');
                },
                'subNitis'
            ])
            // ->whereHas('todayStartTime', function ($query) use ($latestDayId) {
            //     $query->where('day_id', $latestDayId);
            // })
            ->get()
            ->groupBy('after_special_niti');

        // ✅ Other Nitis (based on management table status)
        $otherNitis = NitiMaster::where('status', 'active')
            ->where('niti_type', 'other')
            ->where('niti_status', 'Started')
            ->with(['subNitis'])
            ->whereHas('todayStartTime', function ($query) use ($latestDayId) {
                $query->where('day_id', $latestDayId);
            })
            ->get();

        $finalNitiList = [];

        // ✅ Add "Other" Nitis
        foreach ($otherNitis as $otherNiti) {
            $finalNitiList[] = [
                'niti_id'     => $otherNiti->niti_id,
                'niti_name'   => $otherNiti->niti_name,
                'niti_type'   => $otherNiti->niti_type,
                'niti_status' => 'Started',
                'start_time'  => optional($otherNiti->todayStartTime)->start_time,
            ];
        }

        // ✅ Daily Nitis + Special after each
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

            // ✅ Add matching special Nitis
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
            'message' => 'Niti list compiled using day_id.',
            'data' => $finalNitiList
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error in manageNiti: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Error retrieving Niti list.',
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

        // ✅ Get authenticated user
        $user = Auth::guard('niti_admin')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        $now = Carbon::now('Asia/Kolkata');

        // ✅ Fetch NitiMaster and its day_id
        $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();
        if (!$nitiMaster) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id ?? null;

        if (!$dayId) {
            return response()->json([
                'status' => false,
                'message' => 'No day_id found for the Niti. Please check setup or update day_id first.'
            ], 422);
        }

        // ✅ Step 1: Start Niti
        $nitiManagement = NitiManagement::create([
            'niti_id'     => $request->niti_id,
            'day_id'      => $dayId,
            'sebak_id'    => $user->sebak_id,
            'date'        => $now->toDateString(),
            'start_time'  => $now->format('H:i:s'),
            'niti_status' => 'Started'
        ]);

        // ✅ Update NitiMaster status
        $nitiMaster->update(['niti_status' => 'Started']);

        // ✅ Step 2: Start Darshan if linked
        $darshanLog = null;
        if ($nitiMaster->connected_darshan_id) {
            $darshanLog = DarshanManagement::create([
                'darshan_id'     => $nitiMaster->connected_darshan_id,
                'sebak_id'       => $user->sebak_id,
                'day_id'         => $dayId,
                'date'           => $now->toDateString(),
                'start_time'     => $now->format('H:i:s'),
                'darshan_status' => 'Started',
                'temple_id'      => $nitiMaster->temple_id ?? null,
            ]);

            DarshanDetails::where('id', $nitiMaster->connected_darshan_id)
                ->update(['darshan_status' => 'Started']);
        }

        // ✅ Step 3: Start Mahaprasad if linked
        $prasadLog = null;
        if ($nitiMaster->connected_mahaprasad_id) {

            $existingPrasad = PrasadManagement::where('day_id', $dayId)
                ->where('prasad_status', 'Started')
                ->latest()
                ->first();

            if ($existingPrasad) {
                $existingPrasad->update(['prasad_status' => 'Completed']);
                TemplePrasad::where('id', $existingPrasad->prasad_id)->update(['prasad_status' => 'Completed']);
            }

            // Create new PrasadManagement entry
            $prasadLog = PrasadManagement::create([
                'prasad_id'     => $nitiMaster->connected_mahaprasad_id,
                'sebak_id'      => $user->sebak_id,
                'day_id'        => $dayId,
                'date'          => $now->toDateString(),
                'start_time'    => $now->format('H:i:s'),
                'prasad_status' => 'Started',
                'temple_id'     => $nitiMaster->temple_id ?? null,
            ]);

            TemplePrasad::where('id', $nitiMaster->connected_mahaprasad_id)
                ->update(['prasad_status' => 'Started']);
        }

        // ✅ Final response
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
        // ✅ Validate input
        $request->validate([
            'niti_id' => 'required|string|exists:temple__niti_details,niti_id',
        ]);

        // ✅ Get authenticated Niti Admin
        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

           // ✅ Fetch NitiMaster and its day_id
           $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();

           if (!$nitiMaster) {
               return response()->json([
                   'status' => false,
                   'message' => 'Niti not found.'
               ], 404);
           }
   
           $dayId = $nitiMaster->day_id ?? null;

        // ✅ Get today's date in IST
        $today = Carbon::now('Asia/Kolkata')->toDateString();

        // ✅ Find the "Started" entry for today
        $startedNiti = NitiManagement::where('niti_id', $request->niti_id)
        ->where('niti_status', 'Started')
        ->where('day_id', $dayId)
        ->latest()
        ->first();

        if (!$startedNiti) {
            return response()->json([
                'status' => false,
                'message' => 'This Niti is not in Started state by any Sebak.'
            ], 400);
        }

        // ✅ Try to get the day_id from the started entry or from NitiMaster
        $dayId = $startedNiti->day_id;

        if (!$dayId) {
            $dayId = optional(NitiMaster::where('niti_id', $request->niti_id)->first())->day_id;
        }

        if (!$dayId) {
            return response()->json([
                'status' => false,
                'message' => 'Missing day_id. Please ensure this Niti was started properly before pausing.'
            ], 422);
        }

        // ✅ Create new paused log entry
        $pausedNiti = new NitiManagement();
        $pausedNiti->niti_id     = $request->niti_id;
        $pausedNiti->sebak_id    = $user->sebak_id;
        $pausedNiti->day_id      = $dayId;
        $pausedNiti->start_time  = $startedNiti->start_time; // Preserve the original start time
        $pausedNiti->date        = $today;
        $pausedNiti->pause_time  = Carbon::now('Asia/Kolkata')->format('H:i:s');
        $pausedNiti->niti_status = 'Paused';
        $pausedNiti->save();

        // ✅ Update status in main NitiMaster table
        NitiMaster::where('niti_id', $request->niti_id)->update([
            'niti_status' => 'Paused'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Niti paused successfully and logged.',
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
        // ✅ Validate request
        $request->validate([
            'niti_id' => 'required|string|exists:temple__niti_details,niti_id',
        ]);

        // ✅ Get authenticated Niti Admin
        $user = Auth::guard('niti_admin')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        // ✅ Get day_id from master
        $dayId = NitiMaster::where('niti_id', $request->niti_id)->value('day_id');
        if (!$dayId) {
            return response()->json([
                'status' => false,
                'message' => 'Missing day_id for this Niti. Cannot resume.'
            ], 422);
        }

        // ✅ Find the most recent paused entry for this day
        $pausedNiti = NitiManagement::where('niti_id', $request->niti_id)
            ->where('niti_status', 'Paused')
            ->where('day_id', $dayId)
            ->latest()
            ->first();

        if (!$pausedNiti) {
            return response()->json([
                'status' => false,
                'message' => 'No paused Niti found for current day_id.'
            ], 400);
        }

        $now = Carbon::now('Asia/Kolkata');

        // ✅ Insert resumed record
        $resumedNiti = new NitiManagement();
        $resumedNiti->niti_id     = $request->niti_id;
        $resumedNiti->sebak_id    = $user->sebak_id;
        $resumedNiti->day_id      = $dayId;
        $resumedNiti->start_time  = $pausedNiti->start_time;
        $resumedNiti->pause_time  = $pausedNiti->pause_time;
        $resumedNiti->resume_time = $now->format('H:i:s');
        $resumedNiti->date        = $now->toDateString();
        $resumedNiti->niti_status = 'Started';
        $resumedNiti->save();

        // ✅ Update master
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

        // ✅ Get day_id from NitiMaster
        $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();
        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // ✅ Get the latest active Niti by day_id
        $activeNiti = NitiManagement::where('niti_id', $request->niti_id)
            ->where('sebak_id', $user->sebak_id)
            ->where('niti_status', 'Started')
            ->where('day_id', $dayId)
            ->latest()
            ->first();

        if (!$activeNiti || !$activeNiti->start_time) {
            return response()->json([
                'status' => false,
                'message' => 'No active Niti found to stop.'
            ], 400);
        }

        // ✅ Calculate duration
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $activeNiti->date . ' ' . $activeNiti->start_time, $tz);
        $durationInSeconds = $startDateTime->diffInSeconds($now);

        $hours = floor($durationInSeconds / 3600);
        $minutes = floor(($durationInSeconds % 3600) / 60);
        $seconds = $durationInSeconds % 60;

        $runningTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        $durationText = $hours > 0 ? "{$hours} hr {$minutes} min" : ($minutes > 0 ? "{$minutes} min" : "{$seconds} sec");

        // ✅ Save completed Niti entry
        $completedNiti = new NitiManagement();
        $completedNiti->niti_id       = $request->niti_id;
        $completedNiti->sebak_id      = $user->sebak_id;
        $completedNiti->day_id        = $dayId;
        $completedNiti->start_time    = $activeNiti->start_time;
        $completedNiti->pause_time    = $activeNiti->pause_time;
        $completedNiti->resume_time   = $activeNiti->resume_time;
        $completedNiti->date          = $now->toDateString();
        $completedNiti->end_time      = $now->format('H:i:s');
        $completedNiti->running_time  = $runningTime;
        $completedNiti->duration      = trim($durationText);
        $completedNiti->niti_status   = 'Completed';
        $completedNiti->save();

        // ✅ Update NitiMaster
        $nitiMaster->update([
            'niti_status' => 'Completed'
        ]);

        // ✅ Stop interconnected Darshan (if any)
        $darshanCompleted = null;
        if ($nitiMaster->connected_darshan_id) {
            $activeDarshan = DarshanManagement::where('darshan_id', $nitiMaster->connected_darshan_id)
                ->where('sebak_id', $user->sebak_id)
                ->where('darshan_status', 'Started')
                ->where('day_id', $dayId)
                ->latest()
                ->first();

            if ($activeDarshan) {
                $darshanStart = Carbon::parse($activeDarshan->date . ' ' . $activeDarshan->start_time);
                $darshanDuration = $darshanStart->diff($now)->format('%H:%I:%S');

                $darshanCompleted = DarshanManagement::create([
                    'darshan_id'     => $nitiMaster->connected_darshan_id,
                    'sebak_id'       => $user->sebak_id,
                    'temple_id'      => $activeDarshan->temple_id ?? null,
                    'day_id'         => $dayId,
                    'date'           => $now->toDateString(),
                    'start_time'     => $activeDarshan->start_time,
                    'end_time'       => $now->format('H:i:s'),
                    'duration'       => $darshanDuration,
                    'darshan_status' => 'Completed',
                ]);

                // ✅ Update DarshanDetails
                DarshanDetails::where('id', $nitiMaster->connected_darshan_id)
                    ->update(['darshan_status' => 'Completed']);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Niti (and linked Darshan if any) stopped successfully.',
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
        $nitiMaster = NitiMaster::where('status', 'active')->first();

        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // Fetch completed Niti entries for today along with related Niti name
        $completed = NitiManagement::with('master:niti_id,niti_name')
            ->where('niti_status', 'Completed')
            ->where('day_id', $dayId)
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
        $request->validate([
            'niti_name' => 'required|string|max:255',
            'niti_id'   => 'nullable|string',
        ]);

        $now = Carbon::now()->setTimezone('Asia/Kolkata');
        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please login as Sebak.',
            ], 401);
        }

        // Generate today's day_id if not already stored
        $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();

        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // If existing Niti, update it
        if ($request->filled('niti_id')) {
            $niti = NitiMaster::where('niti_id', $request->niti_id)->first();

            if ($niti) {
                $niti->update([
                    'niti_status' => 'Started',
                    'day_id'      => $dayId,
                ]);

                NitiManagement::create([
                    'niti_id'     => $niti->niti_id,
                    'sebak_id'    => $user->sebak_id,
                    'day_id'      => $dayId,
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

        // Prevent duplicate names for "other" type
        $existingNiti = NitiMaster::where('niti_name', $request->niti_name)
            ->where('niti_type', 'other')
            ->first();

        if ($existingNiti) {
            return response()->json([
                'status'  => false,
                'message' => 'Niti name already exists. Please update instead.',
            ], 409);
        }

        // Create new Niti
        $niti = NitiMaster::create([
            'niti_id'        => 'NITI' . rand(10000, 99999),
            'niti_name'      => $request->niti_name,
            'niti_type'      => 'other',
            'language'       => 'Odia',
            'niti_privacy'   => 'public',
            'niti_status'    => 'Started',
            'date_time'      => $now->format('Y-m-d H:i:s'),
            'day_id'         => $dayId,
        ]);

        // Log to management
        NitiManagement::create([
            'niti_id'     => $niti->niti_id,
            'sebak_id'    => $user->sebak_id,
            'day_id'      => $dayId,
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
        $tomorrow = Carbon::now('Asia/Kolkata')->addDay();
        $datePrefix = $tomorrow->format('Ymd');  // e.g., 20250424
        
        // Generate 4 random letters
        $randomSuffix = '';
        for ($i = 0; $i < 4; $i++) {
            $randomSuffix .= chr(rand(65, 90)); // A-Z
        }
        
        $dayId = $datePrefix . '-' . $randomSuffix; // e.g., 20250424-ZQPL

        // Step 2: Update NitiMaster
        $nitiUpdatedCount = NitiMaster::where('status', 'active')
            ->update([
                'niti_status' => 'Upcoming',
                'day_id' => $dayId
            ]);

        // Step 3: Update DarshanDetails
        $darshanUpdatedCount = DarshanDetails::where('status', 'active')
            ->update([
                'darshan_status' => 'Upcoming',
                'day_id' => $dayId
            ]);

        // Step 4: Update TemplePrasad
        $prasadUpdatedCount = TemplePrasad::where('prasad_status', 'active')
            ->update([
                'prasad_status' => 'Upcoming',
                'day_id' => $dayId
            ]);

        // ✅ Return success response
        return response()->json([
            'status' => true,
            'message' => 'All active statuses updated to Upcoming with new day_id.',
            'day_id' => $dayId,
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

        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Sebak not logged in.'
            ], 401);
        }

        $now = Carbon::now('Asia/Kolkata');
        $today = $now->toDateString();

        // ✅ Fetch Sub Niti
        $subNiti = TempleSubNiti::find($request->sub_niti_id);

        if (!$subNiti) {
            return response()->json([
                'status' => false,
                'message' => 'Sub Niti not found.'
            ], 404);
        }

        // ✅ Get day_id from parent Niti
        $nitiMaster = NitiMaster::where('niti_id', $subNiti->niti_id)->first();

        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Parent Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // ✅ Check for already running Sub Niti
        $existingRunning = TempleSubNitiManagement::where('niti_id', $subNiti->niti_id)
            ->where('status', 'Running')
            ->where('day_id', $dayId)
            ->latest()
            ->first();

        if ($existingRunning) {
            $existingRunning->update([
                'status' => 'Completed',
            ]);
        }

        // ✅ Log new Running Sub Niti
        $record = TempleSubNitiManagement::create([
            'temple_id'      => $nitiMaster->temple_id,
            'sebak_id'       => $user->sebak_id,
            'day_id'         => $dayId,
            'niti_id'        => $subNiti->niti_id,
            'sub_niti_id'    => $subNiti->id,
            'sub_niti_name'  => $subNiti->sub_niti_name,
            'date'           => $today,
            'start_time'     => $now->format('H:i:s'),
            'status'         => 'Running',
        ]);

        // ✅ Update Sub Niti status in Master table
        TempleSubNiti::where('niti_id', $subNiti->niti_id)
            ->where('id', '!=', $subNiti->id)
            ->where('status', 'Running')
            ->update(['status' => 'Completed']);

        TempleSubNiti::where('id', $subNiti->id)->update([
            'status' => 'Running'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Sub Niti started successfully.',
            'data' => $record
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to start Sub Niti.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function addAndStartSubNiti(Request $request)
{
    try {
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

        // ✅ Get Niti and day_id
        $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();

        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Parent Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // ✅ Step 1: Complete any other Running Sub Niti under the same Niti + day_id
        $existingRunning = TempleSubNitiManagement::where('niti_id', $request->niti_id)
            ->where('day_id', $dayId)
            ->where('status', 'Running')
            ->latest()
            ->first();

        if ($existingRunning) {
            $existingRunning->update([
                'status' => 'Completed',
            ]);
        }

        // ✅ Step 2: Add new Sub Niti to temple__sub_niti
        $subNiti = TempleSubNiti::create([
            'niti_id'       => $request->niti_id,
            'sub_niti_name' => $request->sub_niti_name,
        ]);

        // ✅ Step 3: Start Sub Niti under management table
        $management = TempleSubNitiManagement::create([
            'sebak_id'       => $user->sebak_id,
            'day_id'         => $dayId,
            'niti_id'        => $request->niti_id,
            'sub_niti_id'    => $subNiti->id,
            'sub_niti_name'  => $subNiti->sub_niti_name,
            'date'           => $today,
            'start_time'     => $now->format('H:i:s'),
            'status'         => 'Running',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Sub Niti added and started successfully.',
            'data' => [
                'sub_niti'   => $subNiti,
                'management' => $management,
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to add and start Sub Niti.',
            'error'   => $e->getMessage(),
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
