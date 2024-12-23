<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempleDressColor;
use App\Models\TempleBesha;
use App\Models\BeshaBooking;
use App\Models\DeityDressItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

// use Illuminate\Support\Facades\Log;
class TempleBeshaController extends Controller
{
    //
    public function templemanagebesha(){
        $temple_beshas = TempleBesha::all(); // Fetch all records from the TempleBesha model

        // Return the view with the data
        return view('templeuser.templebesha.temple-manage-besha', compact('temple_beshas'));
    }

    public function addbesha(){

        $dressColors = TempleDressColor::all();
        $items = DeityDressItem::where('status', 'active')
       ->get();

        return view('templeuser.templebesha.temple-add-besha',compact('dressColors','items'));
        
    }
    // Method to save the Besha data (form submission)
    public function savebesha(Request $request)
    {
        // Validate the request
        $request->validate([
            'besha_name' => 'required|string|max:255',
            'items' => 'required|array',
            'description' => 'nullable|string',
            'estimated_time' => 'required|date_format:H:i',
            'weekly_day' => 'nullable|string',
            'dress_color' => 'nullable|string',
            'special_day' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        // Save the Besha data
        $besha = new TempleBesha;
        $besha->besha_name = $request->besha_name;
        $besha->items = implode(',', $request->items); // Store items as comma-separated string
        $besha->description = $request->description;
        $besha->estimated_time = $request->estimated_time;
        $besha->total_time = $request->total_time;
        $besha->date = $request->date;
    
        $besha->weekly_day = $request->weekly_day;
        $besha->dress_color = $request->dress_color;
    
        // Check if 'special_day' is checked and save "yes" or "no"
        $besha->special_day = $request->has('special_day') ? 'yes' : 'no';
    
        // Handle photo uploads
        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('besha_photos', 'public');
                $photos[] = $path;
            }
            $besha->photos = implode(',', $photos);
        }
    
        // Save the Besha record to the database
        $besha->save();
    
        // Redirect to a success page
        return redirect()->route('templeuser.managebesha')->with('success', 'Besha added successfully');
    }
    
    public function edit($id)
{
    $besha = TempleBesha::findOrFail($id);
    $items = DeityDressItem::where('status', 'active')
       ->get();
    $dressColors = TempleDressColor::all();
    
    return view('templeuser.templebesha.temple-edit-besha', compact('besha', 'items', 'dressColors'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'besha_name' => 'required|string|max:255',
        'items' => 'nullable|array',
        'description' => 'nullable|string',
        'estimated_time' => 'nullable|string',
        'total_time' => 'nullable|string',
        'date' => 'nullable|date',
        'weekly_day' => 'nullable|string',
        'dress_color' => 'nullable|string',
        'special_day' => 'nullable|string',
        'photos.*' => 'nullable|image|mimes:jpeg,png|max:2048',
    ]);

    $besha = TempleBesha::findOrFail($id);

    $besha->besha_name = $request->besha_name;
    // $besha->items = json_encode($request->items); // Save as JSON if multiple
    $besha->items = implode(',', $request->items);
    $besha->description = $request->description;
    $besha->estimated_time = $request->estimated_time;
    $besha->total_time = $request->total_time;
    $besha->date = $request->date;
    $besha->weekly_day = $request->weekly_day;
    $besha->dress_color = $request->dress_color;
    $besha->special_day = $request->has('special_day') ? 'yes' : 'no';

   // Handle Removed Photos
   $removedPhotos = $request->input('removed_photos') ? explode(',', $request->input('removed_photos')) : [];
   $existingPhotos = explode(',', $besha->photos);
   $remainingPhotos = array_diff($existingPhotos, $removedPhotos);

   // Delete Removed Photos from Storage
   foreach ($removedPhotos as $photo) {
       if (file_exists(public_path($photo))) {
           unlink(public_path($photo));
       }
   }

   // Handle New Photos
//    $newPhotos = [];
//    if ($request->hasFile('photos')) {
//        foreach ($request->file('photos') as $file) {
//            $path = $file->store('besha_photos', 'public');
//            $newPhotos[] = 'besha_photos/' . basename($path);
//        }
//    }

//    // Merge Remaining Photos with New Photos
//    $updatedPhotos = array_merge($remainingPhotos, $newPhotos);

//    // Update the Besha Record
//    $besha->photos = implode(',', $updatedPhotos);

   // Handle New Photos
$newPhotos = [];
if ($request->hasFile('photos')) {
    foreach ($request->file('photos') as $file) {
        $path = $file->store('besha_photos', 'public');
        if ($path) {
            $newPhotos[] = 'besha_photos/' . basename($path);
        } else {
            logger('File upload failed for: ' . $file->getClientOriginalName());
        }
    }
}

// Merge Remaining Photos with New Photos
$updatedPhotos = array_merge($remainingPhotos, $newPhotos);

// Debug Final Photos Array
// Log::info('Final photos to save: ' . implode(',', $updatedPhotos));

// Update the Besha Record
$besha->photos = implode(',', $updatedPhotos);
// $besha->save();


   $besha->save();

   return redirect()->route('templeuser.managebesha')->with('success', 'Besha updated successfully!');
}
public function delete($id)
    {
        // Find the Besha record by ID
        $besha = TempleBesha::findOrFail($id);

        // Delete associated photos from storage
        if ($besha->photos) {
            $photos = explode(',', $besha->photos);
            foreach ($photos as $photo) {
                $photoPath = public_path($photo);
                if (file_exists($photoPath)) {
                    // Log the photo deletion
                    Log::info('Deleting photo: ' . $photo);
                    File::delete($photoPath);
                }
            }
        }

        // Delete the Besha record
        $besha->delete();

        // Redirect back with success message
        return redirect()->route('templeuser.managebesha')->with('success', 'Besha deleted successfully!');
    }

    public function showBesha()
    {
        // Fetch all one-time Besha events
        $events = TempleBesha::whereNull('weekly_day')
            ->where(function ($query) {
                $query->where('special_day', 'no')
                      ->orWhereNull('special_day');
            })
            ->get()
            ->map(function ($besha) {
                return [
                    'id' => $besha->id,
                    'title' => $besha->besha_name,
                    'start' => $besha->date,
                    'end' => $besha->date,
                    'description' => $besha->description,
                ];
            });
    
        // Add special Besha events (special_day = yes)
        $specialBeshaEvents = TempleBesha::where('special_day', 'yes')
            ->whereNotNull('date') // Ensure the date is provided
            ->get()
            ->map(function ($besha) {
                return [
                    'id' => $besha->id,
                    'title' => $besha->besha_name,
                    'start' => $besha->date,
                    'end' => $besha->date,
                    'description' => $besha->description,
                ];
            });
    
        // Generate weekly recurring events
        $weeklyEvents = TempleBesha::whereNotNull('weekly_day')
            ->where(function ($query) {
                $query->where('special_day', 'no')
                      ->orWhereNull('special_day');
            })
            ->get()
            ->flatMap(function ($besha) {
                $currentYear = Carbon::now()->year;
                $currentDate = Carbon::create($currentYear, 1, 1)->startOfWeek();
                $endOfYear = Carbon::create($currentYear, 12, 31);
                $events = [];
    
                while ($currentDate->lte($endOfYear)) {
                    if ($currentDate->format('l') === ucfirst($besha->weekly_day)) {
                        $events[] = [
                            'id' => $besha->id,
                            'title' => $besha->besha_name,
                            'start' => $currentDate->toDateString(),
                            'end' => $currentDate->toDateString(),
                            'description' => $besha->description,
                        ];
                    }
                    $currentDate->addDay();
                }
    
                return $events;
            });
    
        // Merge all event types
        $allEvents = collect($events)
            ->merge($specialBeshaEvents)
            ->merge($weeklyEvents);
    
        // Fetch Besha list for today based on day name
        $todayDayName = now()->format('l'); // E.g., "Monday"
        $todayBeshaList = TempleBesha::where(function ($query) use ($todayDayName) {
                $query->where('weekly_day', strtolower($todayDayName))
                      ->orWhere('weekly_day', ucfirst($todayDayName));
            })
            ->orWhere(function ($query) {
                $query->where('special_day', 'yes')
                      ->where('date', now()->toDateString());
            })
            ->get(['besha_name', 'estimated_time', 'total_time']);
    
        // Pass all events and today's Besha list to the view
        return view('templeuser.templebesha.temple-show-besha', [
            'events' => $allEvents,
            'todayBeshaList' => $todayBeshaList,
        ]);
    }


    public function showBeshaDetails($date)
    {
        // Convert the date to a Carbon instance and get the day name
        $dayName = Carbon::parse($date)->format('l');
    
        // Fetch Special Beshas for the selected date
        $specialBeshas = TempleBesha::where('date', $date)
            ->where('special_day', 'yes')
            ->get();
    
        // Fetch Normal Beshas for the selected day name where the `date` field is null
        $normalBeshas = TempleBesha::whereNull('date')
            ->where(function ($query) use ($dayName) {
                $query->where('weekly_day', strtolower($dayName))
                    ->orWhere('weekly_day', ucfirst($dayName));
            })
            ->where('special_day', 'no')
            ->get();
    
        // Combine the two collections
        $beshas = $specialBeshas->merge($normalBeshas);
    
        // Check if no records are found
        if ($beshas->isEmpty()) {
            return redirect()->route('templeuser.templebesha.temple-show-besha')
                ->with('error', 'No Besha found for the selected date.');
        }
    
        // Pass records to the view
        return view('templeuser.templebesha.temple-show-besha-details', compact('beshas', 'date'));
    }


    public function bookBesha(Request $request, $beshaId)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'gotra' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits:10',
            'payment_type' => 'required|string|max:255',
            'payment_amount' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Create a new booking record
        $beshaBooking = new BeshaBooking([
            'booking_id' => Str::uuid(), // Generate a unique ID for the booking
            'besha_id' => $beshaId,
            'name' => $request->user_name,
            'gotra' => $request->gotra,
            'phone_no' => $request->mobile,
            'date' => Carbon::now()->format('Y-m-d'), // You can set the booking date or make it dynamic
            'day_name' => Carbon::parse($request->date)->format('l'),
        ]);

        // Save the booking details
        $beshaBooking->save();

        // Return a response, redirecting with a success message
        return redirect()->back()->with('success', 'Besha booked successfully!');
    }
    
    

}
