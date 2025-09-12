<?php

namespace App\Http\Controllers;
use App\Models\Apartment;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(){
       $tenants = Tenant::with(['apartment'])->latest()->get();
        return view('tenants.index', compact('tenants'));
    }

    public function create(){
        $apartments = Apartment::where('status', 'Rent')->get();
        return view ('tenants.create', compact('apartments'));
    }

    public function store(Request $request)
{
    $request->validate([
        'full_name'        => 'required',
        'phone_number'     => 'required',
        'country_code'     => 'required',
        'email'            => 'nullable|email',
        'tower_id'         => 'nullable',
        'floor_id'         => 'nullable',
        'apartment_id'     => 'nullable',
        'rent_billing_cycle' => 'required',
        'rent_amount'      => 'required|numeric',
        'contract_start_date' => 'required|date',
        'contract_end_date'   => 'required|date|after:contract_start_date',
    ]);

    // Create new Tenant
    $tenant                     = new Tenant();
    $tenant->tower_id           = $request->tower_id;
    $tenant->floor_id           = $request->floor_id;
    $tenant->apartment_id       = $request->apartment_id;
    $tenant->full_name          = $request->full_name;
    $tenant->email              = $request->email;
    $tenant->phone_number       = $request->phone_number;
    $tenant->country_code       = $request->country_code;
    $tenant->bill_cycle = $request->bill_cycle;
    $tenant->rent_amount        = $request->rent_amount;
    $tenant->contract_start_date = $request->contract_start_date;
    $tenant->contract_end_date   = $request->contract_end_date;

    // Handle profile image upload (save in public/profile_images)
    if ($request->hasFile('profile_image')) {
        $file     = $request->file('profile_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile_images'), $filename);

        $tenant->profile_image = 'profile_images/' . $filename;
    }

    $tenant->save();

    // Update apartment status
    if ($request->apartment_id) {
        $apartment = Apartment::find($request->apartment_id);
        if ($apartment) {
            $apartment->status     = 'Occupied';
            $apartment->tenant_id  = $tenant->id; // 🔥 store tenant id
            $apartment->save();
        }
    }

    return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
}

}