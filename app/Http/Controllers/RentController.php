<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\Tower;
use App\Models\Floor;
use App\Models\Apartment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentController extends Controller
{
    public function index()
    {
        $rents = Rent::with(['tower', 'floor', 'apartment', 'tenant'])
            ->orderBy('rent_year', 'desc')
            ->orderBy('rent_month', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('rents.index', compact('rents'));
    }

    public function create()
    {
        $towers = Tower::with(['floors.apartments' => function ($q) {
            $q->where('status', 'Rented'); // only rented apartments
        }])->get();
        
        $currentYear = date('Y');
        $currentMonth = date('F');
        
        return view('rents.create', compact('towers', 'currentYear', 'currentMonth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tower_id' => 'required|exists:towers,id',
            'floor_id' => 'required|exists:floors,id',
            'apartment_id' => 'required|exists:apartments,id',
            'tenant_name' => 'required|string',
            'rent_amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Unpaid,Partial',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        // Get current year and month for the rent entry
        $currentYear = date('Y');
        $currentMonth = date('F');

        // Get tenant based on apartment
        $apartment = Apartment::find($request->apartment_id);
        $tenant = Tenant::where('apartment_id', $request->apartment_id)->first();

        if (!$tenant) {
            return back()->with('error', 'No tenant found for the selected apartment.');
        }

        // Check if rent already exists for this period
        if (Rent::rentExists($request->apartment_id, $tenant->id, $currentYear, $currentMonth)) {
            return back()->with('error', 'Rent entry already exists for this apartment and period.');
        }

        $rent = Rent::create([
            'tower_id' => $request->tower_id,
            'floor_id' => $request->floor_id,
            'apartment_id' => $request->apartment_id,
            'tenant_id' => $tenant->id,
            'tenant_name' => $request->tenant_name,
            'rent_year' => $currentYear,
            'rent_month' => $currentMonth,
            'rent_amount' => $request->rent_amount,
            'status' => $request->status,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes
        ]);

        return redirect()->route('rents.index')->with('success', 'Rent entry created successfully.');
    }

    public function edit($id)
    {
        $rent = Rent::findOrFail($id);
        $towers = Tower::with(['floors.apartments' => function ($q) {
            $q->where('status', 'Rented');
        }])->get();
        
        $years = Rent::getYears();
        $months = Rent::getMonths();
        
        return view('rents.edit', compact('rent', 'towers', 'years', 'months'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tower_id' => 'required|exists:towers,id',
            'floor_id' => 'required|exists:floors,id',
            'apartment_id' => 'required|exists:apartments,id',
            'tenant_name' => 'required|string',
            'rent_year' => 'required|integer|min:2020|max:2030',
            'rent_month' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'rent_amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Unpaid,Partial',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $rent = Rent::findOrFail($id);

        // Get tenant based on apartment
        $tenant = Tenant::where('apartment_id', $request->apartment_id)->first();
        
        if (!$tenant) {
            return back()->with('error', 'No tenant found for the selected apartment.');
        }

        // Check if updating to a different period that already exists
        if ($rent->apartment_id != $request->apartment_id || 
            $rent->rent_year != $request->rent_year || 
            $rent->rent_month != $request->rent_month) {
            
            if (Rent::rentExists($request->apartment_id, $tenant->id, $request->rent_year, $request->rent_month)) {
                return back()->with('error', 'Rent entry already exists for this apartment and period.');
            }
        }

        $rent->update([
            'tower_id' => $request->tower_id,
            'floor_id' => $request->floor_id,
            'apartment_id' => $request->apartment_id,
            'tenant_id' => $tenant->id,
            'tenant_name' => $request->tenant_name,
            'rent_year' => $request->rent_year,
            'rent_month' => $request->rent_month,
            'rent_amount' => $request->rent_amount,
            'status' => $request->status,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes
        ]);

        return redirect()->route('rents.index')->with('success', 'Rent entry updated successfully.');
    }

    public function destroy($id)
    {
        $rent = Rent::findOrFail($id);
        $rent->delete();
        
        return redirect()->route('rents.index')->with('success', 'Rent entry deleted successfully.');
    }
}