<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HundiCollection;
use App\Models\Hundi;
use Illuminate\Support\Facades\Auth;

class TempleHundiCollectionReport extends Controller
{
    public function reportHundiCollection()
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
        $hundi_names = Hundi::where('temple_id', $templeId)->where('status', 'active')->get();
    
        // Initialize default values
        $collections = collect();
        $grandTotal = 0;
        $hundiName = 'All';
        $fromDate = null;
        $toDate = null;
    
        return view('reports/reports-hundi-collection', compact('hundi_names', 'collections', 'grandTotal', 'hundiName', 'fromDate', 'toDate'));
    }
    
    public function searchHundiCollection(Request $request)
    {
        $templeId = Auth::guard('temples')->user()->temple_id;
        $hundi_names = Hundi::where('temple_id', $templeId)->where('status', 'active')->get();
    
        $hundiName = $request->input('hundi_name');
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
        ->groupBy('id', 'hundi_name', 'hundi_open_date', 'opened_by', 'present_member') // Group by all required fields, including id
        ->get();
    
    
        // Group collections by hundi name for the view
        $groupedCollections = collect(); // Initialize as an empty collection

        if ($collections->isNotEmpty()) {
            $groupedCollections = $collections->groupBy('hundi_name');
        }   
        $grandTotal = $collections->sum('total_collection');
    
        return view('reports.reports-hundi-collection', [
            'hundi_names' => $hundi_names,
            'groupedCollections' => $groupedCollections, // Ensure this is the exact variable name
            'grandTotal' => $grandTotal,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'hundiName' => $hundiName,
        ]);
        
    }

    public function showCashTray($id)
    {
        // Fetch the collection details
        $collection = HundiCollection::with('transactions')->findOrFail($id);
        
        // Calculate the total amount (if needed)
        $totalCollection = $collection->transactions->sum('total_amount');
        
        return view('templeuser.cash-tray-report', compact('collection', 'totalCollection'));
    }
    
    

}
