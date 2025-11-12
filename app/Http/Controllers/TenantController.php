<?php
namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Owner;
use App\Models\Tenant;
use App\Models\TenantHistory;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with(['apartment'])->latest()->get();
        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        // $apartments = Apartment::where('status', 'Rent')->get();
        $apartments = Apartment::whereIn('status', ['Rent', 'Unsold'])->get();
        $owners = Owner::orderBy('name')->get();
        return view('tenants.create', compact('apartments', 'owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                => 'required',
            'phone_number'        => 'required',
            'country_code'        => 'required',
            'email'               => 'nullable|email',
            'apartment_id'        => 'required',
            'bill_cycle'          => 'required',
            'rent_amount'         => 'required|numeric',
            'contract_start_date' => 'required|date',
            'contract_end_date'   => 'required|date|after:contract_start_date',
        ]);

        // Create new Tenant
        $tenant                      = new Tenant();
        $tenant->apartment_id        = $request->apartment_id;
        $tenant->name                = $request->name;
        $tenant->email               = $request->email;
        $tenant->phone_number        = $request->phone_number;
        $tenant->country_code        = $request->country_code;
        $tenant->bill_cycle          = $request->bill_cycle;
        $tenant->rent_amount         = $request->rent_amount;
        $tenant->contract_start_date = $request->contract_start_date;
        $tenant->contract_end_date   = $request->contract_end_date;
        $tenant->owner_id            = $request->owner_id;
        // Handle profile image upload (save in public/profile_images)
        if ($request->hasFile('profile_image')) {
            $file     = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profile_images'), $filename);

            $tenant->profile_image = 'profile_images/' . $filename;
        }

        $tenant->save();

        // Log the creation in history
        TenantHistory::logChange($tenant, 'created');

        // Update apartment status
        if ($request->apartment_id) {
            $apartment = Apartment::find($request->apartment_id);
            if ($apartment) {
                $apartment->status    = 'Rented';
                $apartment->save();
            }
        }

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }

    public function edit($id)
    {
        $tenant = Tenant::with('apartment')->findOrFail($id);
        $apartments = Apartment::where('status', 'Rent')
            ->orWhere('id', $tenant->apartment_id)
            ->get();
        $owners = Owner::orderBy('name')->get();
        return view('tenants.edit', compact('tenant', 'apartments', 'owners'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'                => 'required',
            'phone_number'        => 'required',
            'country_code'        => 'required',
            'email'               => 'nullable|email',
        ]);

        $tenant = Tenant::findOrFail($id);
        
        // Store original data for comparison
        $originalData = $tenant->toArray();
        
        // Store old apartment id
        $oldApartmentId = $tenant->apartment_id;
        
        // Update tenant details
        $tenant->apartment_id        = $request->apartment_id ?? $tenant->apartment_id;
        $tenant->name                = $request->name;
        $tenant->email               = $request->email;
        $tenant->phone_number        = $request->phone_number;
        $tenant->owner_id            = $request->owner_id;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($tenant->profile_image && file_exists(public_path($tenant->profile_image))) {
                unlink(public_path($tenant->profile_image));
            }
            
            $file     = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profile_images'), $filename);
            
            $tenant->profile_image = 'profile_images/' . $filename;
        }

        $tenant->save();


        // Update apartment statuses if apartment changed
        // if ($oldApartmentId != $request->apartment_id) {
        //     // Free up old apartment
        //     if ($oldApartmentId) {
        //         $oldApartment = Apartment::find($oldApartmentId);
        //         if ($oldApartment) {
        //             $oldApartment->status = 'Rented';
        //             $oldApartment->save();
        //         }
        //     }
            
        //     // Occupy new apartment
        //     if ($request->apartment_id) {
        //         $newApartment = Apartment::find($request->apartment_id);
        //         if ($newApartment) {
        //             $newApartment->status = 'Occupied';
        //             $newApartment->save();
        //         }
        //     }
        // }

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    public function destroy($id){
        $tenant = Tenant::findOrFail($id);
        
        // Log the deletion in history before deleting
        TenantHistory::logChange($tenant, 'deleted');
        
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');


    }

    public function history($id)
    {
        $tenant = Tenant::findOrFail($id);
        $histories = TenantHistory::where('tenant_id', $id)
            ->with(['apartment', 'changedByUser'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('tenants.history', compact('tenant', 'histories'));
    }

    public function allHistory()
    {
        $histories = TenantHistory::with(['tenant', 'apartment', 'changedByUser'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('tenants.all-history', compact('histories'));
    }

}