<?php

namespace App\Http\Controllers\TempleUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePrasad;
use App\Models\TemplePrasadItem;
use Illuminate\Support\Facades\Auth;
class TemplePrasadController extends Controller
{
    //
    public function addPrasad(){
        return view('templeuser.add-temple-prasad');
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'darshan_start_time' => 'required|',
            'darshan_end_time' => 'required|',
            'online_order' => 'nullable',
            'pre_order' => 'nullable',
            'offline_order' => 'nullable',
            'prasad_name' => 'required|',
            'prasad_price' => 'required|',
        ]);
        $prasadId = 'PRASAD' . mt_rand(1000000, 9999999);
        // Save the main temple prasad details in 'temple_prasads' table
        $templePrasad = TemplePrasad::create([
            'temple_id' => Auth::guard('temples')->user()->temple_id,
            'temple_prasad_id' => $prasadId, // Assuming you have authenticated user with temple_id
            'darshan_start_time' => json_encode($request->darshan_start_time),
            'darshan_end_time' => json_encode($request->darshan_end_time),
            'online_order' => $request->has('online_order') ? 1 : 0,
            'pre_order' => $request->has('pre_order') ? 1 : 0,
            'offline_order' => $request->has('offline_order') ? 1 : 0,
        ]);
    
        // Save the additional prasad details in 'temple_prasad_details' table
        foreach ($request->prasad_name as $key => $prasadName) {
            TemplePrasadItem::create([
                'temple_id' =>Auth::guard('temples')->user()->temple_id,
                'temple_prasad_id' => $templePrasad->temple_prasad_id,
                'prasad_name' => $prasadName,
                'prasad_price' => $request->prasad_price[$key],
            ]);
        }
    
        return redirect()->back()->with('success', 'Prasad details have been saved successfully!');
    }
    
}
