<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HundiCollection;
use App\Models\Hundi;
use Illuminate\Http\JsonResponse;


class ReportHundiCollection extends Controller
{
    public function reportHundiCollection(): JsonResponse
{
    try {
        $templeId = Auth::guard('api')->user()->temple_id;

        if (!$templeId) {
            return response()->json([
                'message' => 'Temple ID not found',
                'status' => 400
            ], 400);
        }

        $hundi_names = Hundi::where('temple_id', $templeId)->where('status', 'active')->get();

        // Initialize default values
        $collections = collect();
        $grandTotal = 0;
        $hundiName = 'All';
        $fromDate = null;
        $toDate = null;

        return response()->json([
            'message' => 'Data retrieved successfully',
            'status' => 200,
            'data' => [
                'hundi_names' => $hundi_names,
                'collections' => $collections,
                'grandTotal' => $grandTotal,
                'hundiName' => $hundiName,
                'fromDate' => $fromDate,
                'toDate' => $toDate
            ]
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Server error occurred',
            'status' => 500
        ], 500);
    }
}

public function searchHundiCollection(Request $request): JsonResponse
{
    try {
        $templeId = Auth::guard('api')->user()->temple_id;

        if (!$templeId) {
            return response()->json([
                'message' => 'Temple ID not found',
                'status' => 400
            ], 400);
        }

        $hundi_names = Hundi::where('temple_id', $templeId)->where('status', 'active')->get();
    
        $hundiName = $request->input('hundi_name', 'All');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
    
        $query = HundiCollection::query();
    
        // Filter by hundi name if not 'All'
        if ($hundiName !== 'All') {
            $query->where('hundi_name', $hundiName);
        }
    
        // Apply date filters
        if ($fromDate && $toDate) {
            $query->whereBetween('hundi_open_date', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $query->whereDate('hundi_open_date', '=', $fromDate);
        }

        // Fetch collections and calculate the grand total
        $collections = $query
            ->selectRaw('id, hundi_name, hundi_open_date, opened_by, present_member, SUM(collection_amount) as total_collection')
            ->groupBy('id', 'hundi_name', 'hundi_open_date', 'opened_by', 'present_member')
            ->get();
    
        // Group collections by hundi name
        $groupedCollections = $collections->isNotEmpty() ? $collections->groupBy('hundi_name') : collect();
        $grandTotal = $collections->sum('total_collection');
    
        return response()->json([
            'message' => 'Data retrieved successfully',
            'status' => 200,
            'data' => [
                'hundi_names' => $hundi_names,
                'groupedCollections' => $groupedCollections,
                'grandTotal' => $grandTotal,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'hundiName' => $hundiName,
            ]
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Server error occurred',
            'status' => 500
        ], 500);
    }
}

public function showCashTray($id): JsonResponse
{
    try {
        $templeId = Auth::guard('api')->user()->temple_id;

        // Fetch the collection details along with related transactions
        $collection = HundiCollection::with('transactions')->where('temple_id',$templeId)->find($id);
        
        // Check if the collection exists
        if (!$collection) {
            return response()->json([
                'message' => 'Collection not found',
                'status' => 400
            ], 400);
        }

        // Calculate the total amount
        $totalCollection = $collection->transactions->sum('total_amount');
        
        return response()->json([
            'message' => 'Collection data retrieved successfully',
            'status' => 200,
            'data' => [
                'collection' => $collection,
                'totalCollection' => $totalCollection
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Server error occurred',
            'status' => 500
        ], 500);
    }
}

}
