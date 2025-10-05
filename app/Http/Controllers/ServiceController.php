<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Tower;
use App\Models\Floor;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $types = ServiceType::get();
        
        $query = Service::with(['serviceType', 'tower', 'floor', 'apartment']);
        
        if ($request->has('type') && $request->type) {
            $query->where('service_type_id', $request->type);
        }elseif($types && $types->count() > 0){
            $query->where('service_type_id', $types[0]->id);
        }
        
        $services = $query->latest()->get();
        
        return view('services.index', compact('types', 'services'));
    }

    
    public function create()
    {
        $types = ServiceType::get();
        $towers = Tower::with(['floors.apartments'])->get();
        $countryCodes = [
            '+1' => 'USA/Canada (+1)',
            '+44' => 'UK (+44)',
            '+91' => 'India (+91)',
            '+86' => 'China (+86)',
            '+81' => 'Japan (+81)',
            '+49' => 'Germany (+49)',
            '+33' => 'France (+33)',
            '+39' => 'Italy (+39)',
            '+34' => 'Spain (+34)',
            '+61' => 'Australia (+61)',
        ];
        
        return view('services.create', compact('types', 'towers', 'countryCodes'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'is_daily_help' => 'nullable|in:on,off',
            'tower_id' => 'nullable|exists:towers,id',
            'floor_id' => 'nullable|exists:floors,id',
            'apartment_id' => 'nullable|exists:apartments,id',
            'contact_person_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'country_code' => 'required|string',
            'company_name' => 'nullable|string|max:255',
            'website_link' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $validated;
        $data['is_daily_help'] = $request->has('is_daily_help') ? true : false;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('services.index')
            ->with('success', 'Service added successfully.');
    }

   
    public function show(string $id)
    {
        //
    }

   
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        $types = ServiceType::get();
        $towers = Tower::with(['floors.apartments'])->get();
        $floors = Floor::where('tower_id', $service->tower_id)->get();
        $apartments = Apartment::where('floor_id', $service->floor_id)->get();
        $countryCodes = [
            '+1' => 'USA/Canada (+1)',
            '+44' => 'UK (+44)',
            '+91' => 'India (+91)',
            '+86' => 'China (+86)',
            '+81' => 'Japan (+81)',
            '+49' => 'Germany (+49)',
            '+33' => 'France (+33)',
            '+39' => 'Italy (+39)',
            '+34' => 'Spain (+34)',
            '+61' => 'Australia (+61)',
        ];
        
        return view('services.edit', compact('service', 'types', 'towers', 'floors', 'apartments', 'countryCodes'));
    }

   
    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);
        
        $validated = $request->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'is_daily_help' => 'nullable|in:on,off',
            'tower_id' => 'nullable|exists:towers,id',
            'floor_id' => 'nullable|exists:floors,id',
            'apartment_id' => 'nullable|exists:apartments,id',
            'contact_person_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'country_code' => 'required|string',
            'company_name' => 'nullable|string|max:255',
            'website_link' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $validated;
        $data['is_daily_help'] = $request->has('is_daily_help') ? true : false;

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($service->photo) {
                Storage::disk('public')->delete($service->photo);
            }
            $data['photo'] = $request->file('photo')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        
        // Delete photo if exists
        if ($service->photo) {
            Storage::disk('public')->delete($service->photo);
        }
        
        $service->delete();
        
        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }
    
    public function getFloors($towerId)
    {
        $floors = Floor::where('tower_id', $towerId)->get();
        return response()->json($floors);
    }
    
    public function getApartments($floorId)
    {
        $apartments = Apartment::where('floor_id', $floorId)->get();
        return response()->json($apartments);
    }
}