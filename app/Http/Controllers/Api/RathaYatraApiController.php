<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RathaYatraNiti;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use Carbon\CarbonInterval;


class RathaYatraApiController extends Controller
{

 public function getFirstPendingDayNitis()
{
    try {
        // ✅ Get all day_ids in logical order (DAY_01, DAY_02...)
        $dayIds = RathaYatraNiti::where('status', 'active')
            ->select('day_id')
            ->distinct()
            ->orderByRaw("CAST(SUBSTRING(day_id, 5) AS UNSIGNED)")
            ->pluck('day_id');

        foreach ($dayIds as $dayId) {
            // ✅ Fetch all Nitis under this day
            $nitis = RathaYatraNiti::where('day_id', $dayId)
                ->where('status', 'active')
                ->get();

            // ✅ Check: if all Nitis are either 'Completed' or 'NotStarted', then skip
            $allDoneOrNotStarted = $nitis->every(function ($niti) {
                return in_array($niti->niti_status, ['Completed', 'NotStarted']);
            });

            if (!$allDoneOrNotStarted) {
                // ✅ This is the first day with active/incomplete Nitis
                $nitiList = $nitis->map(function ($niti) {
                    return [
                        'niti_id'     => $niti->niti_id,
                        'niti_name'   => $niti->niti_name ?? null,
                        'niti_type'   => $niti->niti_type,
                        'niti_status' => $niti->niti_status,
                        'start_time'  => $niti->start_time,
                        'end_time'    => $niti->end_time,
                        'date'        => $niti->date,
                    ];
                });

                return response()->json([
                    'status'  => true,
                    'message' => "Showing Nitis for $dayId (first day with active or running tasks).",
                    'day_id'  => $dayId,
                    'data'    => $nitiList,
                ], 200);
            }
        }

        // ✅ If all days have only Completed or NotStarted Nitis
        return response()->json([
            'status' => true,
            'message' => 'No running or active Nitis found. All days are either Completed or NotStarted.',
            'data' => [],
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error in getFirstPendingDayNitis: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch Niti data.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function startNiti(Request $request)
{
    try {
      
        // ✅ Get authenticated user
        $user = Auth::guard('niti_admin')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        $now = Carbon::now('Asia/Kolkata');

        // ✅ Fetch NitiMaster and validate existence
        $nitiMaster = RathaYatraNiti::where('niti_id', $request->niti_id)->first();
        if (!$nitiMaster) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found.'
            ], 404);
        }

        // ✅ Validate day_id
        if (!$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'No day_id found for the Niti. Please check setup or update day_id first.'
            ], 422);
        }

        // ✅ Update the Niti record
        $nitiMaster->update([
            'start_user_id' => $user->sebak_id,
            'date'          => $now->toDateString(),
            'start_time'    => $now->format('H:i:s'),
            'niti_status'   => 'Started',
        ]);

        // ✅ Final response
        return response()->json([
            'status' => true,
            'message' => 'Niti started successfully.',
            'data' => [
                'niti' => $nitiMaster,
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

public function stopNiti(Request $request)
{
    try {
        // ✅ Get authenticated user
        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        $tz = 'Asia/Kolkata';
        $now = Carbon::now($tz);

        // ✅ Fetch the active Niti by niti_id and its current day_id
        $activeNiti = RathaYatraNiti::where('niti_id', $request->niti_id)
        ->first();

        if (!$activeNiti) {
            return response()->json([
                'status' => false,
                'message' => 'Active Niti not found for today with the given Niti ID.',
            ], 404);
        }

        // ✅ Update the Niti record
        $activeNiti->update([
            'end_user_id'  => $user->sebak_id,
            'end_time'     => $now->format('H:i:s'),
            'niti_status'  => 'Completed',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Niti stopped successfully.',
            'data' => [
                'niti' => $activeNiti,
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
        // ✅ Fetch today's active day_id from any one active entry
        $nitiMaster = RathaYatraNiti::where('status', 'active')->first();

        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // ✅ Step 1: Fetch "Started" Nitis
        $startedEntries = RathaYatraNiti::where('day_id', $dayId)
            ->where('niti_status', 'Started')
            ->orderByDesc('id')
            ->get()
            ->map(function ($entry) {
                return [
                    'id'                       => $entry->id,
                    'niti_id'                  => $entry->niti_id,
                    'odia_niti_name'           => optional($entry->master)->niti_name,
                    'date'                     => $entry->date,
                    'start_time'               => $entry->start_time,
                    'end_time'                 => null,
                    'niti_status'              => 'Started',
                    'start_user_id'            => $entry->start_user_id,
                    'end_user_id'              => $entry->end_user_id,
                    'start_time_edit_user_id'  => $entry->start_time_edit_user_id,
                    'end_time_edit_user_id'    => $entry->end_time_edit_user_id,
                    'not_done_user_id'         => null,
                ];
            });

        // ✅ Step 2: Fetch "Completed" or "NotStarted" Nitis
        $completedEntries = RathaYatraNiti::with('master')
            ->where('day_id', $dayId)
            ->whereIn('niti_status', ['Completed', 'NotStarted'])
            ->get()
            ->map(function ($entry) {
                return [
                    'id'                       => $entry->id,
                    'niti_id'                  => $entry->niti_id,
                    'odia_niti_name'           => optional($entry->master)->niti_name,
                    'date'                     => $entry->date,
                    'start_time'               => $entry->start_time,
                    'end_time'                 => $entry->end_time,
                    'niti_status'              => $entry->niti_status,
                    'start_user_id'            => $entry->start_user_id,
                    'end_user_id'              => $entry->end_user_id,
                    'start_time_edit_user_id'  => $entry->start_time_edit_user_id,
                    'end_time_edit_user_id'    => $entry->end_time_edit_user_id,
                    'not_done_user_id'         => $entry->not_done_user_id,
                ];
            });

        // ✅ Merge "Started" entries after "Completed"/"NotStarted"
        $merged = $completedEntries->merge($startedEntries)->values();

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

public function editStartTime(Request $request)
{
    $request->validate([
        'niti_management_id' => 'required|integer|exists:ratha__yatra_niti_details,id',
        'start_time' => 'required|date_format:H:i:s',
    ]);

    $user = Auth::guard('niti_admin')->user();
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    $niti = RathaYatraNiti::find($request->niti_management_id);
    if (!$niti) {
        return response()->json([
            'status' => false,
            'message' => 'Niti record not found.'
        ], 404);
    }

    $niti->start_time = $request->start_time;
    $niti->start_time_edit_user_id = $user->sebak_id;
    $niti->save();

    return response()->json([
        'status' => true,
        'message' => 'Start time updated successfully.',
        'data' => $niti
    ], 200);
}

public function editEndTime(Request $request)
{
    $request->validate([
        'niti_management_id' => 'required|integer|exists:ratha__yatra_niti_details,id',
        'end_time' => 'required|date_format:H:i:s',
    ]);

    $user = Auth::guard('niti_admin')->user();
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    $niti = RathaYatraNiti::find($request->niti_management_id);
    if (!$niti) {
        return response()->json([
            'status' => false,
            'message' => 'Niti record not found.'
        ], 404);
    }

    $niti->end_time = $request->end_time;
    $niti->end_time_edit_user_id = $user->sebak_id;
    $niti->save();

    return response()->json([
        'status' => true,
        'message' => 'End time updated successfully.',
        'data' => $niti
    ], 200);
}

}