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
use App\Models\Apk;
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
            ->where('niti_status', '!=', 'NotStarted')
            ->where('niti_type', 'daily')
            ->orderBy('niti_order', 'asc') // <-- will now correctly sort even decimal orders
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
            ->where('niti_status', '!=', 'NotStarted')
            ->whereDate('date_time', $today) // ✅ Filter by today's date here
            ->with([
                'todayStartTime' => function ($query) use ($latestDayId) {
                    $query->where('niti_status', 'Upcoming')
                        ->where('day_id', $latestDayId)
                        ->select('niti_id', 'start_time');
                },
                'subNitis'
            ])
            ->get()
            ->groupBy('after_special_niti');

        // ✅ Other Nitis (based on management table status)
        $otherNitis = NitiMaster::where('niti_type', 'other')
        ->where('niti_status', 'Started')
        ->where('status','!=','deleted')
        ->with(['subNitis'])
        ->whereHas('todayStartTime', function ($query) use ($latestDayId) {
            $query->where('day_id', $latestDayId);
        })
        ->get();

         $nitiInfo = TempleNews::where('type', 'information')
            ->where('niti_notice_status','Started')
            ->where('status','active')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'niti_notice','niti_notice_english','created_at'])
            ->first();

        $finalNitiList = [];

        // ✅ Add "Other" Nitis
        foreach ($otherNitis as $otherNiti) {
            $finalNitiList[] = [
                'niti_id'     => $otherNiti->niti_id,
                'niti_name'   => $otherNiti->niti_name,
                'niti_type'   => $otherNiti->niti_type,
                'niti_status' => 'Started',
                'start_time'  => optional($otherNiti->todayStartTime)->start_time,
                'status'      => $otherNiti->status
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

        $uniqueNitiList = collect($finalNitiList)->unique('niti_name')->values();

        return response()->json([
            'status' => true,
            'message' => 'Niti list compiled using day_id.',
            'data' => $finalNitiList,
            'niti_info' => $nitiInfo,
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

    //    $latestNews = TempleNews::where('type', 'information')
    //     ->where('niti_notice_status', 'Started')
    //     ->orderBy('created_at', 'desc')
    //     ->first();

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
                
        $latestEntry = NitiManagement::where('niti_id', $request->niti_id)
            ->where('day_id', $dayId)
            ->latest('created_at')
            ->first();

        $nitiType = $nitiMaster->niti_type;

        // For "other" Niti, allow multiple but only if latest is Completed
        if (
            $nitiType === 'other' &&
            $latestEntry &&
            $latestEntry->niti_status === 'Started'
        ) {
            return response()->json([
                'status' => false,
                'message' => 'This Niti (other type) is already started and not completed yet.'
            ], 409);
        }

        // For other types, block if already started
        if (
            $nitiType !== 'other' &&
            $latestEntry &&
            $latestEntry->niti_status === 'Started'
        ) {
            return response()->json([
                'status' => false,
                'message' => 'This Niti has already been started by another user.'
            ], 409);
        }

        // ✅ Step 1: Start Niti
        $nitiManagement = NitiManagement::create([
            'niti_id'     => $request->niti_id,
            'day_id'      => $dayId,
            'start_user_id'    => $user->sebak_id,
            'date'        => $now->toDateString(),
            'start_time'  => $now->format('H:i:s'),
            'niti_status' => 'Started'
        ]);

        $nitiMaster->update(['niti_status' => 'Started']);

        // if ($latestNews) {
        //     $latestNews->update(['niti_notice_status' => 'Completed']);
        // }

        $darshanLog = null;

        if ($nitiMaster->connected_darshan_id) {
            if ($nitiMaster->connected_darshan_id == 5) {
                // If darshan id is 5, set all darshans to 'Upcoming'
                DarshanDetails::query()->update(['darshan_status' => 'Upcoming']);
            } else {
                // Check if an active darshan already exists for this darshan_id, sebak_id, day_id
                $activeDarshan = DarshanDetails::where('darshan_status', 'Started')
                    ->where('day_id', $dayId)
                    ->latest('id')
                    ->first();

                // If active darshan exists, mark it as completed with end_time
                if ($activeDarshan) {
                    $activeDarshan->update([
                        'darshan_status' => 'Completed',
                        'end_time' => $now->format('H:i:s'),
                    ]);

                    // Also update the related DarshanDetails status to 'Completed'
                    DarshanDetails::where('id', $activeDarshan->darshan_id)
                        ->update(['darshan_status' => 'Completed']);
                }

                // Now create new darshan management entry with status Started
                $darshanLog = DarshanManagement::create([
                    'darshan_id'     => $nitiMaster->connected_darshan_id,
                    'sebak_id'       => $user->sebak_id,
                    'day_id'         => $dayId,
                    'date'           => $now->toDateString(),
                    'start_time'     => $now->format('H:i:s'),
                    'darshan_status' => 'Started',
                    'temple_id'      => $nitiMaster->temple_id ?? null,
                ]);

                // Update DarshanDetails status to Started for this darshan
                DarshanDetails::where('id', $nitiMaster->connected_darshan_id)
                    ->update(['darshan_status' => 'Started']);
            }
        }

        // ✅ Final response
        return response()->json([
            'status' => true,
            'message' => 'Niti and related Darshan/Mahaprasad started successfully.',
            'data' => [
                'niti_management'    => $nitiManagement,
                'darshan_management' => $darshanLog,
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

        // ✅ Get the latest management entry for this Niti and Day
        $latestEntry = NitiManagement::where('niti_id', $request->niti_id)
            ->where('day_id', $dayId)
            ->latest('created_at')
            ->first();

        $nitiType = $nitiMaster->niti_type;

        // 🔒 Block pause if no latest entry found or it's not in 'Started' status
        if (
            !$latestEntry ||
            $latestEntry->niti_status !== 'Started'
        ) {
            return response()->json([
                'status' => false,
                'message' => 'No active (Started) Niti found to pause.'
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

        // ✅ Check if the Niti is already paused   
        $alreadyPaused = NitiManagement::where('niti_id', $request->niti_id)
            ->where('niti_status', 'Paused')
            ->where('day_id', $dayId)
            ->exists();

        if ($alreadyPaused) {
            return response()->json([
                'status' => false,
                'message' => 'This Niti is already paused.'
            ], 409); // 409 Conflict
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
        $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();

        $dayId = $nitiMaster->day_id;

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

        // ✅ Get latest NitiManagement entry
        $latestEntry = NitiManagement::where('niti_id', $request->niti_id)
            ->where('day_id', $dayId)
            ->latest('created_at')
            ->first();

        if (!$latestEntry || $latestEntry->niti_status !== 'Paused') {
            return response()->json([
                'status' => false,
                'message' => 'No paused Niti available to resume or it has already been resumed.'
            ], 409); // 409 Conflict
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

        // ✅ Get latest TempleNews to complete
        $latestNews = TempleNews::where('type', 'information')
            ->where('niti_notice_status', 'Started')
            ->orderBy('created_at', 'desc')
            ->first();

        // ✅ Fetch NitiMaster and check day_id
        $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();

        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // ✅ Get the active Started Niti row
        $activeNiti = NitiManagement::where('niti_id', $request->niti_id)
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

        // ✅ Validate based on latest entry
        $latestEntry = NitiManagement::where('niti_id', $request->niti_id)
            ->where('day_id', $dayId)
            ->latest('created_at')
            ->first();

        $nitiType = $nitiMaster->niti_type;

        if (
            $latestEntry &&
            $latestEntry->niti_status === 'Completed' &&
            (
                ($nitiType === 'other') ||
                ($nitiType !== 'other')
            )
        ) {
            return response()->json([
                'status' => false,
                'message' => 'This Niti is already marked as completed for today.'
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

            // Get the latest order_id for the current day_id and niti_id
        $orderIds = NitiManagement::where('day_id', $dayId)
        ->whereNotNull('order_id')
        ->pluck('order_id')
        ->map(fn($id) => floatval($id))
        ->toArray();

        $maxOrderFloat = !empty($orderIds) ? max($orderIds) : 0;

        // Calculate new order id integer part by ceiling maxOrderFloat
        $newOrderIdInt = (int) ceil($maxOrderFloat) + 1;

        // Format as zero-padded 2-digit string
        $newOrderId = str_pad($newOrderIdInt, 2, '0', STR_PAD_LEFT);


        // Update the activeNiti row with new order_id
        $activeNiti->update([
            'end_user_id'    => $user->sebak_id,
            'end_time'      => $now->format('H:i:s'),
            'running_time'  => $runningTime,
            'duration'      => $durationText,
            'niti_status'   => 'Completed',
            'order_id'      => $newOrderId,
        ]);


        // ✅ Update NitiMaster
        $nitiMaster->update([
            'niti_status' => 'Completed'
        ]);

        // ✅ Update TempleNews
        if ($latestNews) {
            $latestNews->update(['niti_notice_status' => 'Completed']);
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

        return response()->json([
            'status' => true,
            'message' => 'Niti (and linked Darshan if any) stopped successfully.',
            'data' => [
                'niti'    => $activeNiti,
                'darshan'=> $darshanCompleted,
                'prasad_management'  => $prasadLog
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

        // ✅ Step 1: Get all Started entries
        $startedEntries = NitiManagement::with('master')
            ->where('niti_status', 'Started')
            ->where('day_id', $dayId)
            ->orderByDesc('id') // optional: latest first
            ->get()
            ->map(function ($entry) {
                return [
                    'id'                       => $entry->id,
                    'niti_id'                  => $entry->niti_id,
                    'niti_name'                => optional($entry->master)->niti_name,
                    'sebak_id'                 => $entry->sebak_id,
                    'date'                     => $entry->date,
                    'start_time'               => $entry->start_time,
                    'end_time'                 => null,
                    'duration'                 => null,
                    'niti_status'              => 'Started',
                    'start_user_id'            => $entry->start_user_id,
                    'end_user_id'              => $entry->end_user_id,
                    'start_time_edit_user_id'  => $entry->start_time_edit_user_id,
                    'end_time_edit_user_id'    => $entry->end_time_edit_user_id,
                ];
            });

        // ✅ Step 2: Get all Completed or NotStarted entries
        $completedManagement = NitiManagement::with('master')
            ->whereIn('niti_status', ['Completed', 'NotStarted'])
            ->where('day_id', $dayId)
            ->orderByRaw("CASE WHEN niti_status = 'Started' THEN id ELSE NULL END ASC")
            ->orderByRaw("CASE WHEN niti_status = 'Completed' THEN order_id ELSE NULL END ASC")
            ->get()
            ->map(function ($item) {
                return [
                    'id'                       => $item->id,
                    'niti_id'                  => $item->niti_id,
                    'niti_name'                => optional($item->master)->niti_name,
                    'sebak_id'                 => $item->sebak_id,
                    'date'                     => $item->date,
                    'start_time'               => $item->start_time,
                    'end_time'                 => $item->end_time,
                    'duration'                 => $item->duration,
                    'niti_status'              => $item->niti_status,
                    'start_user_id'            => $item->start_user_id,
                    'end_user_id'              => $item->end_user_id,
                    'start_time_edit_user_id'  => $item->start_time_edit_user_id,
                    'end_time_edit_user_id'    => $item->end_time_edit_user_id,
                ];
            });

        // ✅ Merge with Started first, then Completed/NotStarted
       $merged = $completedManagement->merge($startedEntries)->values();

        return response()->json([
            'status' => true,
            'message' => 'Niti data fetched successfully.',
            'data' => $merged,
        ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch Niti data.',
                'error' => $e->getMessage(),
            ], 500);
        }
}

public function getMahasnanaNiti()
{
    try {
        $otherNitis = NitiMaster::where('niti_type', 'other')
            ->orderBy('date_time', 'desc')
            ->where('status', 'other')
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

public function getOtherNiti()
{
    try {
        $otherNitis = NitiMaster::where('niti_type', 'other')
            ->where('status', 'active')
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

        // Get active NitiMaster with day_id
        $nitiMaster = NitiMaster::where('status','active')->first();

        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // Prevent duplicate names for "other" type before create/update
        $existingNiti = NitiMaster::where('niti_name', $request->niti_name)
            ->where('niti_type', 'other')
            ->whereIn('status', ['active', 'other'])
            ->first();

        // If updating existing Niti (niti_id provided)
        if ($request->filled('niti_id')) {
            $niti = NitiMaster::where('niti_id', $request->niti_id)->first();

            if ($niti) {
                $niti->update([
                    'niti_status' => 'Started',
                    'day_id'      => $dayId,
                    'date'        => $now->toDateString(),
                    'start_time'  => $now->format('H:i:s'),
                ]);

                NitiManagement::create([
                    'niti_id'     => $niti->niti_id,
                    'sebak_id'    => $user->sebak_id,
                    'day_id'      => $dayId,
                    'niti_status' => 'Started',
                    'date'        => $now->toDateString(),
                    'start_time'  => $now->format('H:i:s'),

                ]);

                // If connected_darshan_id is 5, update all DarshanDetails to Upcoming
                if ($existingNiti && $existingNiti->connected_darshan_id == 5) {
                    DarshanDetails::query()->update(['darshan_status' => 'Upcoming']);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Special Niti updated and started.',
                    'data'    => $niti,
                ], 200);
            }
        }

        // Create new Niti if no update
        $niti = NitiMaster::create([
            'niti_id'        => 'NITI' . rand(10000, 99999),
            'niti_name'      => $request->niti_name,
            'english_niti_name'=> $request->english_niti_name ?? $request->niti_name,
            'niti_type'      => 'other',
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

        // If connected_darshan_id is 5, update all DarshanDetails to Upcoming
        if ($existingNiti && $existingNiti->connected_darshan_id == 5) {
            DarshanDetails::query()->update(['darshan_status' => 'Upcoming']);
        }

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
        $nitiUpdatedCount = NitiMaster::where('status', 'active')->orwhere('status', 'other')
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
        $prasadUpdatedCount = TemplePrasad::where('status', 'active')
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
        $nitiMaster = NitiMaster::where('status', 'active')->first();

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
        $nitiMaster = NitiMaster::where('status','active')->first();

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

public function saveHundi(Request $request)
{
    try {

        $user = Auth::guard('niti_admin')->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

        $hundi = TempleHundi::create([
            'date'      => $request->date,
            'rupees'    => $request->rupees,
            'gold'      => $request->gold,
            'silver'    => $request->silver,
            'mix_gold'    => $request->mix_gold,
            'mix_silver'    => $request->mix_silver,
            'hundi_insert_user_id' => $user->sebak_id,
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

public function getHundi()
{
    try {
        $hundiRecords = TempleHundi::orderBy('date', 'desc')->where('status','active')->get();

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

public function deleteHundi($id)
{
    try {
        $hundi = TempleHundi::find($id);

        if (!$hundi) {
            return response()->json(['message' => 'Hundi not found'], 404);
        }

        // Update status to deleted
        $hundi->status = 'deleted';
        $hundi->save();

            return response()->json([
        'status' => true,
        'message' => 'Hundi deleted successfully.',
    ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch hundi records.',
            'error' => $e->getMessage()
        ], 500);
    }
        
}

public function storeByNoticeName(Request $request)
{

    $user = Auth::guard('niti_admin')->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    try {
        $news = TempleNews::create([
            'type' => 'notice',
            'notice_name' => $request->notice_name,
            'notice_name_english' => $request->notice_name_english,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notice_insert_user_id' => $user->sebak_id,
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

        $latestNotice = TempleNews::orderBy('created_at', 'desc')->where('type','notice')->where('status','active')->get();

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

public function updateNoticeName(Request $request)
{
    $request->validate([
        'id' => 'required|exists:temple__news,id',
        'notice_name' => 'required|string|max:255',
    ]);

     $user = Auth::guard('niti_admin')->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    try {
        $news = TempleNews::findOrFail($request->id);
        $news->notice_name = $request->notice_name;
        $news->notice_name_english = $request->notice_name_english;
        $news->start_date = $request->start_date;
        $news->end_date = $request->end_date;
        $news->notice_update_user_id = $user->sebak_id;

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

    $user = Auth::guard('niti_admin')->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    try {
        $hundi = TempleHundi::findOrFail($request->id);

        $hundi->update([
            'date'   => $request->date,
            'rupees' => $request->rupees,
            'gold'   => $request->gold,
            'silver' => $request->silver,
            'mix_gold' => $request->mix_gold,
            'mix_silver' => $request->mix_silver,
            'hundi_update_user_id' => $user->sebak_id,
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

public function deleteNotice($id)
{
    try {
        $notice = TempleNews::find($id);

        if (!$notice) {
            return response()->json([
                'message' => 'Notice not found.'
            ], 404);
        }

        $notice->status = 'deleted'; // Or whatever value you use for "deleted" status
        $notice->save();

        return response()->json([
            'status' => true,
            'message' => 'Notice deleted successfully.',
            'data' => $notice
        ], 200);


    } catch (\Exception $e) {
        Log::error('Error deleting notice: ' . $e->getMessage());

        return response()->json([
            'message' => 'An error occurred while deleting the notice.'
        ], 500);
    }
}

public function deleteOtherNiti($id)
{
    $niti = NitiMaster::where('niti_id', $id)
        ->where('niti_type', 'other')
        ->first();

    if (!$niti) {
        return response()->json([
            'message' => 'Niti not found or not of type "other".',
        ], 404);
    }

    $niti->status = 'deleted';
    $niti->save();

    return response()->json([
        'status' => true,
        'message' => 'Niti status updated to Deleted.',
        'data' => $niti
    ], 200);
}

public function latestApk()
{
    try {
        $apk = Apk::where('status', 'active')
                  ->orderByDesc('id')
                  ->first();

        if (!$apk) {
            return response()->json([
                'status' => false,
                'message' => 'No active APK found.',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Latest APK fetched successfully.',
            'data' => [
                'id' => $apk->id,
                'version' => $apk->version,
                'apk_file' => url($apk->apk_file), // full URL
                'status' => $apk->status,
                'created_at' => $apk->created_at,
                'updated_at' => $apk->updated_at,
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Server error.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function storeTextOtherNiti(Request $request)
{
    $request->validate([
        'niti_name' => 'required|string|max:255',
    ]);
       // ✅ Retrieve the NitiMaster
       $nitiMaster = NitiMaster::where('niti_status', 'Upcoming')->first();

       $dayId = $nitiMaster->day_id ?? null;

       $now = Carbon::now();

        $niti = NitiMaster::create([
            'niti_id'             => 'NITI' . rand(10000, 99999),
            'niti_name'           => $request->niti_name,
            'english_niti_name'   => $request->niti_name,
            'niti_type'           => 'other',
            'niti_privacy'        => 'public',
            'niti_status'         => 'Upcoming',
            'date_time'           => $now->format('Y-m-d H:i:s'),
            'day_id'              => $dayId,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Other Niti stored successfully.',
            'data' => $niti
        ]);

}

public function addNitiInformation(Request $request)
{
    $validated = $request->validate([
        'niti_notice' => 'required|string|max:1000',
        'niti_notice_english' => 'nullable|string|max:1000',
    ]);

    $user = Auth::guard('niti_admin')->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    $news = TempleNews::create([
        'type' => 'information',
        'niti_notice' => $validated['niti_notice'],
        'niti_notice_english' => $validated['niti_notice_english'] ?? $validated['niti_notice'],
        'niti_notice_insert_user_id' => $user->sebak_id,
    ]);

    return response()->json([
        'message' => 'Niti Information added successfully.',
        'data' => $news,
        'status' => true
    ], 201);
}

public function deleteNitiInformation($id)
{
    $news = TempleNews::find($id);

    if (!$news || $news->type !== 'information') {
        return response()->json([
            'message' => 'Niti Information not found.',
            'status' => false
        ], 404);
    }

    $news->status = 'deleted'; // or use 0 or 'inactive' based on your logic
    $news->save();

    return response()->json([
        'message' => 'Niti Information marked as deleted.',
        'data' => $news,
        'status' => true
    ]);
}

public function editStartTime(Request $request)
{
    $request->validate([
        'niti_management_id' => 'required|integer|exists:temple__niti_management,id',
        'start_time'         => 'required|date_format:H:i:s',
    ]);

    $user = Auth::guard('niti_admin')->user();
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    $niti = NitiManagement::find($request->niti_management_id);

    // ✅ Update start_time
    $niti->start_time = $request->start_time;
    $niti->start_time_edit_user_id = $user->sebak_id;

    $niti->save();

    return response()->json([
        'status' => true,
        'message' => 'Start time updated successfully.',
        'data' => $niti
    ]);
}

public function editEndTime(Request $request)
{
    $request->validate([
        'niti_management_id' => 'required|integer|exists:temple__niti_management,id',
        'end_time'           => 'required|date_format:H:i:s',
    ]);

    $user = Auth::guard('niti_admin')->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    $niti = NitiManagement::find($request->niti_management_id);
    $tz = 'Asia/Kolkata';

    // Create Carbon objects for start datetime and new end datetime
    $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $niti->date . ' ' . $niti->start_time, $tz);
    $newEndDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $niti->date . ' ' . $request->end_time, $tz);

    // If new end time is earlier than start time, add 1 day (cross midnight)
    if ($newEndDateTime->lt($startDateTime)) {
        $newEndDateTime->addDay();
    }

    // Calculate duration and running time
    $durationInSeconds = $startDateTime->diffInSeconds($newEndDateTime);
    $hours   = floor($durationInSeconds / 3600);
    $minutes = floor(($durationInSeconds % 3600) / 60);
    $seconds = $durationInSeconds % 60;

    $runningTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    $durationText = $hours > 0 ? "{$hours} hr {$minutes} min" : ($minutes > 0 ? "{$minutes} min" : "{$seconds} sec");

    // Prepare dates to search previous and next Nitis, considering day before and day after
    $searchDates = [
        $newEndDateTime->copy()->subDay()->format('Y-m-d'),
        $newEndDateTime->copy()->format('Y-m-d'),
        $newEndDateTime->copy()->addDay()->format('Y-m-d'),
    ];

    // Get all Nitis in the date range excluding current one
    $allNitis = NitiManagement::whereIn('date', $searchDates)
        ->where('id', '!=', $niti->id)
        ->whereNotNull('end_time')
        ->get()
        ->map(function ($item) use ($tz) {
            $itemStartDT = Carbon::createFromFormat('Y-m-d H:i:s', $item->date . ' ' . $item->start_time, $tz);
            $itemEndDT = Carbon::createFromFormat('Y-m-d H:i:s', $item->date . ' ' . $item->end_time, $tz);
            if ($itemEndDT->lt($itemStartDT)) {
                $itemEndDT->addDay();
            }
            $item->endDateTime = $itemEndDT;
            return $item;
        });

    // Find previous Niti by closest endDateTime less than newEndDateTime
    $previousNiti = $allNitis->filter(function ($item) use ($newEndDateTime) {
        return $item->endDateTime->lt($newEndDateTime);
    })->sortByDesc('endDateTime')->first();

    // Find next Niti by closest endDateTime greater than newEndDateTime
    $nextNiti = $allNitis->filter(function ($item) use ($newEndDateTime) {
        return $item->endDateTime->gt($newEndDateTime);
    })->sortBy('endDateTime')->first();

    $currentOrder = $niti->order_id;
    $newOrderId = null;

    if ($previousNiti && $nextNiti) {
        $prevOrder = $previousNiti->order_id;
        $nextOrder = $nextNiti->order_id;

        if (strpos($prevOrder, '.') !== false && floor(floatval($nextOrder)) == floatval($nextOrder)) {
            // Increment decimal part of previous order by 0.1
            $prevFloat = floatval($prevOrder);
            $newOrderFloat = round($prevFloat + 0.1, 1);

            $prevIntPart = explode('.', $prevOrder)[0];
            $decimalPart = substr(strrchr($newOrderFloat, "."), 1);
            $newOrderId = $prevIntPart . '.' . $decimalPart;

        } else {
            // Average between previous and next
            $avgFloat = (floatval($prevOrder) + floatval($nextOrder)) / 2;
            $prevIntPart = explode('.', $prevOrder)[0];
            $intVal = intval($avgFloat);

            $formattedIntPart = str_pad($intVal, strlen($prevIntPart), '0', STR_PAD_LEFT);

            $fraction = $avgFloat - $intVal;
            $fractionStr = $fraction > 0 ? '.' . substr(number_format($fraction, 1), 2) : '';

            $newOrderId = $formattedIntPart . $fractionStr;
        }

    } elseif ($nextNiti) {
        $nextOrderStr = strval($nextNiti->order_id);
        $nextIntPart = explode('.', $nextOrderStr)[0];
        $nextIntVal = intval($nextIntPart);

        $newIntVal = max($nextIntVal - 1, 0);
        $newIntPart = str_pad($newIntVal, strlen($nextIntPart), '0', STR_PAD_LEFT);
        $newOrderId = $newIntPart . '.5';

    } else {
        $newOrderId = $currentOrder ?? '01';
    }

    // Update the Niti
    $niti->update([
        'end_time' => $request->end_time,
        'running_time' => $runningTime,
        'duration' => trim($durationText),
        'end_time_edit_user_id' => $user->sebak_id,
        'order_id' => $newOrderId,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'End time updated successfully.',
        'data' => $niti,
    ]);
}


public function resetNiti(Request $request)
{
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

    $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();

    if (!$nitiMaster || !$nitiMaster->day_id) {
        return response()->json([
            'status' => false,
            'message' => 'Niti not found or day_id missing.'
        ], 404);
    }

    $dayId = $nitiMaster->day_id;

    // ✅ Find the latest Started NitiManagement entry
    $startedEntry = NitiManagement::where('niti_id', $request->niti_id)
        ->where('day_id', $dayId)
        ->where('niti_status', 'Started')
        ->latest('created_at')
        ->first();

    if ($startedEntry) {
        $startedEntry->delete(); // remove accidental start
    }

    $otherNiti = NitiMaster::where('niti_id', $request->niti_id)
        ->where('day_id', $dayId)
        ->where('niti_status', 'Started')
        ->where('niti_type', 'other')
        ->first();

    if ($otherNiti) {
        $otherNiti->delete(); // remove accidental start
    }

    // ✅ Reset NitiMaster status
    $nitiMaster->update([
        'niti_status' => 'Upcoming'
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Niti has been reset successfully.',
        'data' => [
            'niti_id' => $request->niti_id,
            'day_id'  => $dayId
        ]
    ]);
}

public function markNitiAsNotStarted(Request $request)
{
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

    $nitiMaster = NitiMaster::where('niti_id', $request->niti_id)->first();

    if (!$nitiMaster || !$nitiMaster->day_id) {
        return response()->json([
            'status' => false,
            'message' => 'Niti not found or day_id missing.'
        ], 404);
    }

    if ($nitiMaster->niti_status !== 'Upcoming') {
        return response()->json([
            'status' => false,
            'message' => 'Only Upcoming Nitis can be marked as Not Started.'
        ], 400);
    }

    $dayId = $nitiMaster->day_id;
    $now = Carbon::now('Asia/Kolkata');

    // ✅ Update NitiMaster status to NotStarted
    $nitiMaster->update([
        'niti_status' => 'NotStarted'
    ]);

    // ✅ Always create a new NitiManagement entry
    $management = NitiManagement::create([
        'niti_id'               => $request->niti_id,
        'not_done_user_id'      => $user->sebak_id,
        'day_id'                => $dayId,
        'start_time'             => Carbon::now('Asia/Kolkata')->format('H:i:s'),
        'end_time'               => Carbon::now('Asia/Kolkata')->format('H:i:s'),
        'date'                  => $now->toDateString(),
        'niti_status'           => 'NotStarted',
        'niti_not_done_reason'  => $request->niti_not_done_reason,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Niti marked as Not Started.',
        'data' => [
            'niti_id' => $request->niti_id,
            'day_id'  => $dayId,
            'reason'  => $request->niti_not_done_reason,
            'entry_id' => $management->id
        ]
    ]);
}

public function getStartedDarshanData()
{
    try {
        // Get the first started darshan (object) or null if none
        $startedDarshan = DarshanDetails::where('status', 'active')->get();

        return response()->json([
            'status' => true,
            'message' => 'Started darshan detail fetched successfully.',
            'data' => $startedDarshan,  // object or null
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch started darshan detail.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}