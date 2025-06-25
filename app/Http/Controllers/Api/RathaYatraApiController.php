<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RathaYatraNiti;
use App\Models\TemplePrasad;
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
            // ✅ Fetch all Nitis under this day, ordered by order_id
            $nitis = RathaYatraNiti::where('day_id', $dayId)
                ->orderBy('order_id')
                ->get();

            // ✅ Skip if all are Completed or NotStarted
            $allDoneOrNotStarted = $nitis->every(function ($niti) {
                return in_array($niti->niti_status, ['Completed', 'NotStarted']);
            });

            if (!$allDoneOrNotStarted) {
                $nitiList = $nitis->map(function ($niti) {
                    return [
                        'niti_id'            => $niti->niti_id,
                        'niti_name'     => $niti->niti_name ?? null,
                        'english_niti_name'  => $niti->english_niti_name ?? null,
                        'niti_type'          => $niti->niti_type,
                        'niti_status'        => $niti->niti_status,
                        'start_time'         => $niti->start_time,
                        'end_time'           => $niti->end_time,
                        'date'               => $niti->date,
                        'order_id'           => $niti->order_id,
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
        // ✅ Validate input
        $request->validate([
            'niti_id' => 'required|string|exists:ratha__yatra_niti_details,niti_id',
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

        // ✅ Fetch the active Niti
        $activeNiti = RathaYatraNiti::where('niti_id', $request->niti_id)->first();
        if (!$activeNiti) {
            return response()->json([
                'status' => false,
                'message' => 'Active Niti not found with the given Niti ID.',
            ], 404);
        }

        // ✅ Update Niti as Completed
        $activeNiti->update([
            'end_user_id' => $user->sebak_id,
            'end_time'    => $now->format('H:i:s'),
            'niti_status' => 'Completed',
        ]);

        // ✅ Handle Mahaprasad if linked
        if ($activeNiti->connected_mahaprasad_id) {

            // ✅ Mark other active prasad entries as completed
            TemplePrasad::where('prasad_status', 'Started')->update([
                'prasad_status' => 'Completed'
            ]);

            // ✅ Start the connected Mahaprasad
            TemplePrasad::where('id', $activeNiti->connected_mahaprasad_id)
                ->update(['prasad_status' => 'Started']);

            // ✅ Log the Mahaprasad entry into PrasadManagement
            PrasadManagement::create([
                'prasad_id'     => $activeNiti->connected_mahaprasad_id,
                'sebak_id'      => $user->sebak_id,
                'day_id'        => $activeNiti->day_id,
                'date'          => $now->toDateString(),
                'start_time'    => $now->format('H:i:s'),
                'prasad_status' => 'Started',
            ]);
        }

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
}public function completedNiti()
{
    try {
        $finalData = collect();
        $runningDayId = null;

        // ✅ Get all active day_ids in correct order
        $dayIds = RathaYatraNiti::where('status', 'active')
            ->select('day_id')
            ->distinct()
            ->orderByRaw("CAST(SUBSTRING(day_id, 5) AS UNSIGNED)")
            ->pluck('day_id');

        // ✅ Find first day with any Niti (Started or Completed/NotStarted)
        foreach ($dayIds as $dayId) {
            $hasNiti = RathaYatraNiti::where('day_id', $dayId)
            ->whereDate('date', Carbon::today('Asia/Kolkata'))
            ->whereIn('niti_status', ['Started', 'Completed', 'NotStarted'])
            ->exists();

            if ($hasNiti) {
                $runningDayId = $dayId;
                break;
            }
        }

        if (!$runningDayId) {
            return response()->json([
                'status' => true,
                'message' => 'No relevant Niti records found.',
                'data' => [],
            ], 200);
        }

        // ✅ Fetch Started Nitis
        $startedNitis = RathaYatraNiti::where('day_id', $runningDayId)
            ->where('niti_status', 'Started')
            ->orderBy('order_id', 'asc')
            ->get();

        // ✅ Fetch Completed/NotStarted Nitis
        $otherNitis = RathaYatraNiti::where('day_id', $runningDayId)
            ->whereIn('niti_status', ['Completed', 'NotStarted'])
            ->orderBy('order_id', 'asc')
            ->orderBy('date', 'asc')
            ->orderBy('end_time', 'asc')
            ->get();

        // ✅ Merge and map
        $finalData = $otherNitis->merge($startedNitis)->map(function ($niti) use ($runningDayId) {
            return [
                'day_id'                  => $runningDayId,
                'niti_id'                 => $niti->niti_id,
                'niti_name'               => $niti->niti_name ?? null,
                'english_niti_name'       => $niti->english_niti_name ?? null,
                'niti_type'               => $niti->niti_type,
                'niti_status'             => $niti->niti_status,
                'start_time'              => $niti->start_time,
                'end_time'                => $niti->end_time,
                'date'                    => $niti->date,
                'order_id'                => $niti->order_id,
                'start_user_id'           => $niti->start_user_id,
                'end_user_id'             => $niti->end_user_id,
                'start_time_edit_user_id' => $niti->start_time_edit_user_id,
                'end_time_edit_user_id'   => $niti->end_time_edit_user_id,
                'not_done_user_id'        => $niti->not_done_user_id,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => "Showing Started, Completed and NotStarted Nitis for current day: $runningDayId.",
            'data' => $finalData->values(),
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
        ], 500);
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

    $user = Auth::guard('niti_admin')->user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    // ✅ Find the Niti
    $niti = RathaYatraNiti::find($request->niti_management_id);

    if (!$niti) {
        return response()->json([
            'status' => false,
            'message' => 'Niti record not found.'
        ], 404);
    }

    // ✅ Update end time and editor
    $niti->update([
        'end_time' => $request->end_time,
        'end_time_edit_user_id' => $user->sebak_id,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'End time updated successfully.',
        'data' => $niti
    ], 200);
}

public function markNitiAsNotStarted(Request $request)
{

    $user = Auth::guard('niti_admin')->user();
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access.'
        ], 401);
    }

    $niti = RathaYatraNiti::where('niti_id', $request->niti_id)->latest('id')->first();

    if (!$niti || !$niti->day_id) {
        return response()->json([
            'status' => false,
            'message' => 'Niti not found or day_id missing.'
        ], 404);
    }

    if ($niti->niti_status !== 'Upcoming') {
        return response()->json([
            'status' => false,
            'message' => 'Only Upcoming Nitis can be marked as Not Started.'
        ], 400);
    }

    $now = Carbon::now('Asia/Kolkata');

    // ✅ Update fields directly
    $niti->update([
        'niti_status'           => 'NotStarted',
        'not_done_user_id'      => $user->sebak_id,
        'niti_not_done_reason'  => $request->niti_not_done_reason,
        'start_time'            => $now->format('H:i:s'),
        'end_time'              => $now->format('H:i:s'),
        'date'                  => $now->toDateString(),
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Niti marked as Not Started.',
        'data' => [
            'niti_id' => $niti->niti_id,
            'day_id'  => $niti->day_id,
            'reason'  => $request->niti_not_done_reason,
            'entry_id' => $niti->id,
        ]
    ], 200);
}

public function storeOtherNiti(Request $request)
{
    try {
        $now = Carbon::now('Asia/Kolkata');
        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please login as Sebak.',
            ], 401);
        }

        // ✅ Determine running day_id
        $dayIds = RathaYatraNiti::where('status', 'active')
            ->select('day_id')
            ->distinct()
            ->orderByRaw("CAST(SUBSTRING(day_id, 5) AS UNSIGNED)")
            ->pluck('day_id');

        $runningDayId = null;

        foreach ($dayIds as $dayId) {
            $nitis = RathaYatraNiti::where('day_id', $dayId)
                ->where('status', 'active')
                ->get();

            $hasRunning = $nitis->contains(function ($niti) {
                return !in_array($niti->niti_status, ['Completed', 'NotStarted']);
            });

            if ($hasRunning) {
                $runningDayId = $dayId;
                break;
            }
        }

        if (!$runningDayId) {
            return response()->json([
                'status' => false,
                'message' => 'No active or running Niti day found.',
            ], 404);
        }

        // ✅ Get latest order_id under same day for 'Started', 'Completed', or 'NotStarted'
        $latestOrderId = RathaYatraNiti::where('day_id', $runningDayId)
            ->whereIn('niti_status', ['Started', 'Completed', 'NotStarted'])
            ->max('order_id');

        // ✅ For "other" Niti, increment by 0.1 from the last one
        $newOrderId = $latestOrderId ? round($latestOrderId + 0.1, 1) : 0.1;

        // ✅ Check for update
        if ($request->filled('niti_id')) {
            $niti = RathaYatraNiti::where('niti_id', $request->niti_id)->first();

            if ($niti) {
                $niti->update([
                    'niti_status'    => 'Started',
                    'day_id'         => $runningDayId,
                    'date'           => $now->toDateString(),
                    'start_time'     => $now->format('H:i:s'),
                    'start_user_id'  => $user->sebak_id,
                    'order_id'       => $newOrderId,
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Other Niti updated and started.',
                    'data'    => $niti,
                ], 200);
            }
        }

        // ✅ Create new NITI ID and names with order_id
        $baseNitiId = 'NITIDAY' . rand(10, 99);
        $nitiIdWithOrder = $baseNitiId . '_' . $newOrderId;

        // ✅ Create new other Niti
        $niti = RathaYatraNiti::create([
            'niti_id'            => $nitiIdWithOrder,
            'niti_name'     => $request->niti_name,
            'english_niti_name'  => $request->english_niti_name,
            'niti_type'          => 'other',
            'niti_status'        => 'Started',
            'day_id'             => $runningDayId,
            'date'               => $now->toDateString(),
            'start_user_id'      => $user->sebak_id,
            'start_time'         => $now->format('H:i:s'),
            'order_id'           => $newOrderId,
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

public function getMahasnanaNiti()
{
    try {
        $otherNitis = RathaYatraNiti::where('niti_type', 'other')
            ->where('status', 'other')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Mahasnana Niti list fetched successfully.',
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
        $otherNitis = RathaYatraNiti::where('niti_type', 'other')
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

public function resetNiti(Request $request)
{
    try {
        $request->validate([
            'niti_id' => 'required|string|exists:ratha__yatra_niti_details,niti_id',
        ]);

        $user = Auth::guard('niti_admin')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        $niti = RathaYatraNiti::where('niti_id', $request->niti_id)
            ->first();

        if (!$niti) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found.'
            ], 404);
        }

        if ($niti->niti_status !== 'Started') {
            return response()->json([
                'status' => false,
                'message' => 'Only Nitis in "Started" status can be reset.'
            ], 400);
        }

        $niti->update([
            'niti_status' => 'Upcoming',
            'start_time'  => null,
            'end_time'    => null,
            'start_user_id' => null,
            'end_user_id'   => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Niti has been reset to Upcoming successfully.',
            'data' => $niti
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error in resetNiti: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Failed to reset Niti.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}