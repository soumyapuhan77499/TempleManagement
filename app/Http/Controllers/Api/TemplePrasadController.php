<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplePrasad;
use App\Models\TemplePrasadItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TemplePrasadController extends Controller
{
    //

    public function store(Request $request)
{
    $temple_id = Auth::guard('api')->user()->temple_id;

    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    $validatedData = $request->validate([
        'prasad_start_time' => 'required',
        'prasad_start_period' => 'required',
        'prasad_end_time' => 'required',
        'prasad_end_period' => 'required',
        'online_order' => 'nullable',
        'pre_order' => 'nullable',
        'offline_order' => 'nullable',
        'prasad_name' => 'required|array',
        'prasad_price' => 'required|array',
    ]);

    $prasadId = 'PRASAD' . mt_rand(1000000, 9999999);

    try {
        $templePrasad = TemplePrasad::create([
            'temple_id' => $temple_id,
            'temple_prasad_id' => $prasadId,
            'prasad_start_time' => $request->prasad_start_time,
            'prasad_start_period' => $request->prasad_start_period,
            'prasad_end_time' => $request->prasad_end_time,
            'prasad_end_period' => $request->prasad_end_period,
            'full_prasad_price' => $request->full_prasad_price,
            'online_order' => $request->has('online_order') ? 1 : 0,
            'pre_order' => $request->has('pre_order') ? 1 : 0,
            'offline_order' => $request->has('offline_order') ? 1 : 0,
        ]);

        foreach ($request->prasad_name as $key => $prasadName) {
            TemplePrasadItem::create([
                'temple_id' => $temple_id,
                'temple_prasad_id' => $templePrasad->temple_prasad_id,
                'prasad_name' => $prasadName,
                'prasad_price' => $request->prasad_price[$key],
            ]);
        }

        return response()->json([
            'message' => 'Prasad details have been saved successfully!',
            'data' => $templePrasad,
            'status' => 200,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to save prasad details. Please try again.',
            'data' => null,
            'status' => 500,
        ], 500);
    }
}

public function manageprasad()
{
    $temple_id = Auth::guard('api')->user()->temple_id;

    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    $templePrasads = TemplePrasad::with('prasadItems')
        ->where('temple_id', $temple_id)
        ->get();

    return response()->json([
        'message' => 'Temple Prasad details fetched successfully',
        'data' => $templePrasads,
        'status' => 200,
    ]);
}

public function update(Request $request, $id)
{
    $temple_id = Auth::guard('api')->user()->temple_id;

    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    $validatedData = $request->validate([
        'prasad_start_time' => 'required',
        'prasad_end_time' => 'required',
        'full_prasad_price' => 'required|numeric',
        'prasad_name.*' => 'required',
        'prasad_price.*' => 'required|numeric',
    ]);

    $templePrasad = TemplePrasad::findOrFail($id);
    $templePrasad->update([
        'prasad_start_time' => $request->prasad_start_time,
        'prasad_end_time' => $request->prasad_end_time,
        'full_prasad_price' => $request->full_prasad_price,
        'pre_order' => $request->has('pre_order'),
        'offline_order' => $request->has('offline_order'),
    ]);

    $templePrasad->prasadItems()->delete();

    foreach ($request->prasad_name as $key => $name) {
        TemplePrasadItem::create([
            'temple_id' => $temple_id,
            'temple_prasad_id' => $templePrasad->temple_prasad_id,
            'prasad_name' => $name,
            'prasad_price' => $request->prasad_price[$key],
        ]);
    }

    return response()->json([
        'message' => 'Temple Prasad updated successfully',
        'data' => $templePrasad,
        'status' => 200,
    ]);
}

public function destroy($id)
{
    $temple_id = Auth::guard('api')->user()->temple_id;

    if (!$temple_id) {
        return response()->json([
            'message' => 'User not authenticated.',
            'data' => null,
            'status' => 401,
        ], 401);
    }

    $templePrasad = TemplePrasad::findOrFail($id);
    $templePrasad->prasadItems()->delete();
    $templePrasad->delete();

    return response()->json([
        'message' => 'Temple Prasad deleted successfully',
        'data' => null,
        'status' => 200,
    ]);
}

}
