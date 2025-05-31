<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDarshan;
use App\Models\DarshanDetails;
use App\Models\DarshanManagement;
use App\Models\NitiMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class TempleDarshanController extends Controller
{

public function apiSaveTempleDarshan(Request $request)
{
    
    $templeId = Auth::guard('api')->user()->temple_id;

    if (!$templeId) {
        return response()->json([
            'status' => 400,
            'message' => 'Invalid temple ID. Please authenticate again.',
        ], 400);
    }
    try {
        // Loop through each darshan entry from the JSON request
        foreach ($request->input('darshans') as $darshanData) {

            $startTime = $this->convert24ToCarbonInstance($darshanData['darshan_start_time'], $darshanData['darshan_start_period']);
            $endTime = $this->convert24ToCarbonInstance($darshanData['darshan_end_time'], $darshanData['darshan_end_period']);

            // Calculate darshan duration
            $durationInMinutes = $startTime->diffInMinutes($endTime);
            $hours = intdiv($durationInMinutes, 60);
            $minutes = $durationInMinutes % 60;
            $darshanDuration = sprintf('%02d:%02d', $hours, $minutes);  // Format as HH:MM

            // Create a new Darshan record
            $darshan = new TempleDarshan();

            // Store darshan data
            $darshan->temple_id = $templeId;
            $darshan->darshan_day = $darshanData['day_name'];
            $darshan->darshan_name = $darshanData['darshan_name'];
            $darshan->darshan_start_time = $darshanData['darshan_start_time'];
            $darshan->darshan_start_period = $darshanData['darshan_start_period'];
            $darshan->darshan_end_time = $darshanData['darshan_end_time'];
            $darshan->darshan_end_period = $darshanData['darshan_end_period'];
            $darshan->darshan_duration = $darshanDuration;

            // Handle image upload if base64 encoded image is sent
            if (isset($darshanData['darshan_image'])) {
                $imageName = time() . '_darshan_image.png'; // You can customize the image name and extension
                $imagePath = 'assets/temple/darshan_images/' . $imageName;
                file_put_contents(public_path($imagePath), base64_decode($darshanData['darshan_image']));
                $darshan->darshan_image = $imagePath;
            }

            // Save description
            $darshan->description = $darshanData['description'] ?? null;

            // Save the darshan record
            $darshan->save();
        }

        // Return 200 success response
        return response()->json([
            'status' => 200,
            'success' => 'Darshans saved successfully.'
        ], 200);

    } catch (\Exception $e) {
        // Log the exception for debugging
        \Log::error('Error saving darshans: ' . $e->getMessage());

        // Return 500 server error
        return response()->json([
            'status' => 500,
            'error' => 'An error occurred while saving darshans.'
        ], 500);
    }
}
    
private function convert24ToCarbonInstance($time, $period)
{
    return Carbon::createFromFormat('H:i A', Carbon::createFromFormat('H:i', $time)->format('h:i') . ' ' . $period);
}

public function ManageTempleDarshan()
{
    try {
        $templeId = Auth::guard('api')->user()->temple_id;
        
        if (!$templeId) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid temple ID. Please authenticate again.',
            ], 400);
        }

        // Fetch active darshans for the temple
        $darshans = TempleDarshan::where('status', 'active')
            ->where('temple_id', $templeId)
            ->get();

        // Group darshans by darshan_day
        $groupedDarshans = $darshans->groupBy('darshan_day');

        // Prepare the list of weekdays
        $weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Return a successful JSON response
        return response()->json([
            'status' => 200,
            'message' => 'Darshans fetched successfully.',
            'groupedDarshans' => $groupedDarshans,
            'weekDays' => $weekDays
        ], 200);
    } catch (\Exception $e) {
        // Return a server error message
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred while fetching the darshans. Please try again later.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function updateTempleDarshan(Request $request)
{
   
    try {
        // Loop through each darshan entry
        foreach ($request->darshan_id as $key => $id) {
            // Convert start and end time to Carbon instances
            $startTime = $this->convert24ToCarbonInstance($request->darshan_start_time[$key], $request->darshan_start_period[$key]);
            $endTime = $this->convert24ToCarbonInstance($request->darshan_end_time[$key], $request->darshan_end_period[$key]);

            // Check if start time is greater than end time (overnight case)
            if ($startTime->greaterThan($endTime)) {
                // Add one day to the end time
                $endTime->addDay();
            }

            // Calculate darshan duration
            $durationInMinutes = $startTime->diffInMinutes($endTime);
            $hours = intdiv($durationInMinutes, 60);
            $minutes = $durationInMinutes % 60;
            $darshanDuration = sprintf('%02d:%02d', $hours, $minutes);  // Format as HH:MM

            // Find the darshan entry by ID
            $darshan = TempleDarshan::find($id);

            if ($darshan) {
                // Update the darshan details
                $darshan->darshan_name = $request->darshan_name[$key];
                $darshan->darshan_start_time = $request->darshan_start_time[$key];
                $darshan->darshan_start_period = $request->darshan_start_period[$key];
                $darshan->darshan_end_time = $request->darshan_end_time[$key];
                $darshan->darshan_end_period = $request->darshan_end_period[$key];
                $darshan->darshan_duration = $darshanDuration;  // Save the calculated darshan duration
                $darshan->description = $request->description[$key] ?? null;

                // Handle image upload if a new image is uploaded
                if ($request->hasFile('darshan_image.' . $key)) {
                    $image = $request->file('darshan_image.' . $key);
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = 'assets/temple/darshan_images';
                    $image->move(public_path($imagePath), $imageName);
                    $darshan->darshan_image = $imagePath . '/' . $imageName;
                }

                // Save the darshan details
                $darshan->save();
            }
        }

        return response()->json([
            'success' => 200, 
            'message' => 'Darshans updated successfully.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => 500,
             'message' => 'An error occurred while updating darshans: ' . $e->getMessage()
        ], 500);
    }
}

public function deleteTempleDarshan($id)
{
    try {
        // Find the darshan by ID
        $darshan = TempleDarshan::find($id);

        if ($darshan) {
            // Update the status to 'deleted'
            $darshan->status = 'deleted';
            $darshan->save();

            return response()->json([
                'success' => 200,
                 'message' => 'Darshan deleted successfully.'
            ], 200);
        } else {
            return response()->json([
                'success' => 200,
                 'message' => 'Darshan not found.'
                ], 200);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => 500,
             'message' => 'An error occurred while deleting the darshan: ' . $e->getMessage()
            ], 500);
    }
}

public function getDarshanListApi()
{
    try {
        // Step 1: Fetch latest day_id from active Niti
        $nitiMaster = NitiMaster::where('status', 'active')->latest()->first();

        if (!$nitiMaster || !$nitiMaster->day_id) {
            return response()->json([
                'status' => false,
                'message' => 'Niti not found or day_id missing.'
            ], 404);
        }

        $dayId = $nitiMaster->day_id;

        // Step 2: Fetch all active Darshans
        $darshans = DarshanDetails::where('status', 'active')->get();

        // Step 3: Append related DarshanManagement data using day_id
        $darshanList = $darshans->map(function ($darshan) use ($dayId) {
            $todayLog = DarshanManagement::where('darshan_id', $darshan->id)
                ->where('day_id', $dayId)
                ->latest()
                ->first();

            return [
                'darshan_id'     => $darshan->id,
                'darshan_name'   => $darshan->darshan_name,
                'darshan_type'   => $darshan->darshan_type,
                'description'    => $darshan->description,
                'darshan_status' => $todayLog->darshan_status ?? null,
                'start_time'     => $todayLog->start_time ?? null,
                'end_time'       => $todayLog->end_time ?? null,
                'duration'       => $todayLog->duration ?? null,
                'date'           => $todayLog->date ?? null,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Darshan list fetched successfully.',
            'data' => $darshanList
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch darshan list.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function startDarshan(Request $request)
{
    try {
        $request->validate([
            'darshan_id' => 'required|string',
        ]);

        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        $now = Carbon::now()->setTimezone('Asia/Kolkata');

        // Step 1: Insert into DarshanManagement (activity log)
        $darshanLog = DarshanManagement::create([
            'darshan_id'     => $request->darshan_id,
            'sebak_id'       => $user->sebak_id,
            'date'           => $now->toDateString(),
            'start_time'     => $now->format('H:i:s'),
            'darshan_status' => 'Started',
        ]);

        // Step 2: Update TempleDarshanManagement (master table)
        DarshanDetails::where('id', $request->darshan_id)->update([
            'darshan_status' => 'Started',
            'date'           => $now->toDateString(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Darshan started successfully.',
            'data' => $darshanLog,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to start darshan.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function endDarshan(Request $request)
{
    try {
        $request->validate([
            'darshan_id' => 'required|string',
        ]);

        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        $now = Carbon::now()->setTimezone('Asia/Kolkata');

        // Find the last start time from earlier entry
        $latestStart = DarshanManagement::where('darshan_id', $request->darshan_id)
            ->where('sebak_id', $user->sebak_id)
            ->where('darshan_status', 'Started')
            ->whereDate('date', $now->toDateString())
            ->latest()
            ->first();

        if (!$latestStart) {
            return response()->json([
                'status' => false,
                'message' => 'No active started darshan found for today by this sebak.',
            ], 404);
        }

        // Calculate duration
        $start = Carbon::parse($latestStart->date . ' ' . $latestStart->start_time);
        $duration = $start->diff($now);
        $formattedDuration = $duration->format('%H:%I:%S');

        // ✅ Insert new row as end entry
        $endEntry = DarshanManagement::create([
            'darshan_id'     => $request->darshan_id,
            'sebak_id'       => $user->sebak_id,
            'temple_id'      => $latestStart->temple_id ?? null,
            'date'           => $now->toDateString(),
            'start_time'     => $latestStart->start_time,
            'end_time'       => $now->format('H:i:s'),
            'duration'       => $formattedDuration,
            'darshan_status' => 'Completed',
        ]);

        // ✅ Update main darshan table
        DarshanDetails::where('id', $request->darshan_id)->update([
            'darshan_status' => 'Completed',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Darshan ended and recorded successfully.',
            'data' => $endEntry,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to end darshan.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getTodayCompletedDarshans()
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

        $completedDarshans = DarshanManagement::where('darshan_status', 'Completed')
            ->where('day_id', $dayId)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Completed Darshan list for today fetched successfully.',
            'data' => $completedDarshans,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch completed Darshan data.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getSpecialDarshans()
{
    try {
        $darshans = DarshanDetails::where('darshan_type', 'special')
            ->where('status', 'active')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Special Darshan list fetched successfully.',
            'data' => $darshans,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch special darshan list.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function editDarshan(Request $request)
{
    try {
        $request->validate([
            'darshan_id' => 'nullable|string', // nullable because closed may not have darshan_id
            'action'     => 'required|string|in:start,closed',
        ]);

        $user = Auth::guard('niti_admin')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        $now = Carbon::now()->setTimezone('Asia/Kolkata');

        // If action is start, darshan_id must be present
        if ($request->action === 'start' && empty($request->darshan_id)) {
            return response()->json([
                'status' => false,
                'message' => 'Darshan ID is required to start darshan.',
            ], 400);
        }

        // Fetch the darshan details (needed for day_id)
        $darshan = null;
        if ($request->darshan_id) {
            $darshan = DarshanDetails::find($request->darshan_id);
            if (!$darshan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Darshan not found.',
                ], 404);
            }
        }

        // Get all active started darshans by this sebak for the same day
        $activeDarshans = DarshanManagement::wherewhere('darshan_status', 'Started')
            ->whereHas('darshanDetails', function($query) use ($darshan) {
                if ($darshan) {
                    $query->where('day_id', $darshan->day_id);
                }
            })
            ->whereDate('date', $now->toDateString())
            ->get();

        if ($request->action === 'start') {
            // Complete any other active darshans for the same day first
            foreach ($activeDarshans as $activeDarshan) {
                if ($activeDarshan->darshan_id !== $request->darshan_id) {
                    $start = Carbon::parse($activeDarshan->date . ' ' . $activeDarshan->start_time);
                    $duration = $start->diff($now);
                    $formattedDuration = $duration->format('%H:%I:%S');

                    DarshanManagement::create([
                        'darshan_id'     => $activeDarshan->darshan_id,
                        'sebak_id'       => $user->sebak_id,
                        'temple_id'      => $activeDarshan->temple_id ?? null,
                        'date'           => $now->toDateString(),
                        'start_time'     => $activeDarshan->start_time,
                        'end_time'       => $now->format('H:i:s'),
                        'duration'       => $formattedDuration,
                        'darshan_status' => 'Completed',
                    ]);

                    DarshanDetails::where('id', $activeDarshan->darshan_id)->update([
                        'darshan_status' => 'Completed',
                    ]);
                }
            }

            // Check if the darshan we want to start is already active, if yes, return message
            $alreadyActive = $activeDarshans->firstWhere('darshan_id', $request->darshan_id);
            if ($alreadyActive) {
                return response()->json([
                    'status' => true,
                    'message' => 'Darshan is already started.',
                    'data' => $alreadyActive,
                ], 200);
            }

            // Start the new darshan
            $darshanLog = DarshanManagement::create([
                'darshan_id'     => $request->darshan_id,
                'sebak_id'       => $user->sebak_id,
                'date'           => $now->toDateString(),
                'start_time'     => $now->format('H:i:s'),
                'darshan_status' => 'Started',
            ]);

            DarshanDetails::where('id', $request->darshan_id)->update([
                'darshan_status' => 'Started',
                'date'           => $now->toDateString(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Darshan started successfully.',
                'data' => $darshanLog,
            ], 200);

        } elseif ($request->action === 'closed') {
            // Complete all active darshans for today for this sebak and day

            foreach ($activeDarshans as $activeDarshan) {
                $start = Carbon::parse($activeDarshan->date . ' ' . $activeDarshan->start_time);
                $duration = $start->diff($now);
                $formattedDuration = $duration->format('%H:%I:%S');

                DarshanManagement::create([
                    'darshan_id'     => $activeDarshan->darshan_id,
                    'sebak_id'       => $user->sebak_id,
                    'temple_id'      => $activeDarshan->temple_id ?? null,
                    'date'           => $now->toDateString(),
                    'start_time'     => $activeDarshan->start_time,
                    'end_time'       => $now->format('H:i:s'),
                    'duration'       => $formattedDuration,
                    'darshan_status' => 'Completed',
                ]);

                DarshanDetails::where('id', $activeDarshan->darshan_id)->update([
                    'darshan_status' => 'Completed',
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'All darshans closed successfully.',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid action.',
        ], 400);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to edit darshan.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
