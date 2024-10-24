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
        // Validate incoming request
       
        $prasadId = 'PRASAD' . mt_rand(1000000, 9999999);
        // Store general data in temple_prasads table
        $templePrasad = new TemplePrasad();
        $temple_id = Auth::guard('temples')->user()->temple_id;
        $temple_prasad_id =$prasadId;
        $templePrasad->darshan_start_time = $request->darshan_start_time;
        $templePrasad->darshan_start_period = $request->darshan_start_period;
        $templePrasad->darshan_end_time = $request->darshan_end_time;
        $templePrasad->darshan_end_period = $request->darshan_end_period;
        $templePrasad->online_order = $request->has('online_order');
        $templePrasad->pre_order = $request->has('pre_order');
        $templePrasad->offline_order = $request->has('offline_order');
        $templePrasad->save();

        // Store each prasad in temple_prasad_items table
        foreach ($request->prasad_name as $index => $prasadName) {
            TemplePrasadItem::create([
                'temple_prasad_id' => $templePrasad->id,
                'prasad_name' => $prasadName,
                'prasad_price' => $request->prasad_price[$index],
            ]);
        }

        return redirect()->route('templeprasad.prasad')->with('success', 'Prasad information saved successfully!');
    }
}
