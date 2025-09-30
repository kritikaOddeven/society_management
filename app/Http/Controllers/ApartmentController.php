<?php
namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\ApartmentType;
use App\Models\Floor;
use App\Models\Owner;
use App\Models\Parking;
use App\Models\Tower;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{

    public function __construct(Apartment $apartment)
    {
        $this->apartment = $apartment;
    }

    public function index()
    {
        $apartments = $this->apartment
            ->with(['tower', 'floor', 'type'])
            ->latest()
            ->get();
        return view('apartments.index', compact('apartments'));
    }

    public function create()
    {
        $towers     = Tower::with('floors')->orderBy('tower_name')->get();
        $types      = ApartmentType::orderBy('apartment_type')->get();
        $parkings   = Parking::orderBy('parking_code')->get();
        $owners     = Owner::orderBy('name')->get();
        $apartments = $this->apartment
            ->with(['tower', 'floor', 'type'])
            ->latest()
            ->get();
        $floors = Floor::with('tower')->latest()->get();

        return view('apartments.create', compact('towers', 'types', 'parkings', 'owners', 'apartments', 'floors'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'tower_id'         => 'required|exists:towers,id',
            'floor_id'         => 'required|exists:floors,id',
            'apartment_number' => 'required|string|max:50|unique:apartments,apartment_number',
            'apartment_area'   => 'required|numeric|min:1|max:10000',
            'apartment_type'   => 'required|exists:apartment_types,id',
            'owner_id'         => 'nullable|exists:owners,id',
            'parking_id'       => 'nullable|array',
            'parking_id.*'     => 'exists:parkings,id',
            'status'           => 'nullable|in:Available,Occupied,Maintenance,Unsold',
        ], [
            'tower_id.required' => 'Tower selection is required',
            'tower_id.exists' => 'Selected tower is invalid',
            'floor_id.required' => 'Floor selection is required',
            'floor_id.exists' => 'Selected floor is invalid',
            'apartment_number.required' => 'Apartment number is required',
            'apartment_number.unique' => 'This apartment number already exists',
            'apartment_area.required' => 'Apartment area is required',
            'apartment_area.numeric' => 'Apartment area must be a number',
            'apartment_area.min' => 'Apartment area must be at least 1 sq ft',
            'apartment_area.max' => 'Apartment area must not exceed 10,000 sq ft',
            'apartment_type.required' => 'Apartment type selection is required',
            'apartment_type.exists' => 'Selected apartment type is invalid',
            'owner_id.exists' => 'Selected owner is invalid',
            'parking_id.*.exists' => 'One or more selected parking spaces are invalid',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $apartment                   = new Apartment();
        $apartment->tower_id         = $request->tower_id;
        $apartment->floor_id         = $request->floor_id;
        $apartment->apartment_number = $request->apartment_number;
        $apartment->apartment_area   = $request->apartment_area;
        $apartment->apartment_type   = $request->apartment_type;
        $apartment->status           = $request->status ?: 'Available';
        $apartment->parking_id       = $request->parking_id ? json_encode($request->parking_id) : '';
        $apartment->owner_id         = $request->owner_id;
        $apartment->save();

        // Loop through parking IDs and update their status
        if($request->has('parking_id') && $request->parking_id){
            foreach ($request->parking_id as $parkingId) {
                Parking::where('id', $parkingId)->update(['status' => 'Occupied', 'apartment_id' => $apartment->id]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Apartment created successfully.',
                'apartment' => $apartment->load(['tower', 'floor', 'type']),
                'redirect' => route('apartments.index')
            ]);
        }

        return redirect()->route('apartments.index')->with('success', 'Apartment created successfully.');
    }

    public function edit(Apartment $apartment)
    {
        $towers   = Tower::with('floors')->orderBy('tower_name')->get();
        $types    = ApartmentType::orderBy('apartment_type')->get();
        $parkings = Parking::where('status', 'Available')->get();
        $owners   = Owner::orderBy('name')->get();
        return view('apartments.edit', compact('apartment', 'towers', 'types', 'parkings', 'owners'));
    }

    public function update(Request $request, $id)
    {
        $apartment = Apartment::findOrFail($id);
        
        $validator = \Validator::make($request->all(), [
            'tower_id'         => 'required|exists:towers,id',
            'floor_id'         => 'required|exists:floors,id',
            'apartment_number' => 'required|string|max:50|unique:apartments,apartment_number,' . $id,
            'apartment_area'   => 'required|numeric|min:1|max:10000',
            'apartment_type'   => 'required|exists:apartment_types,id',
            'owner_id'         => 'nullable|exists:owners,id',
            'parking_id'       => 'nullable|array',
            'parking_id.*'     => 'exists:parkings,id',
            'status'           => 'nullable|in:Available,Occupied,Maintenance,Unsold',
        ], [
            'tower_id.required' => 'Tower selection is required',
            'tower_id.exists' => 'Selected tower is invalid',
            'floor_id.required' => 'Floor selection is required',
            'floor_id.exists' => 'Selected floor is invalid',
            'apartment_number.required' => 'Apartment number is required',
            'apartment_number.unique' => 'This apartment number already exists',
            'apartment_area.required' => 'Apartment area is required',
            'apartment_area.numeric' => 'Apartment area must be a number',
            'apartment_area.min' => 'Apartment area must be at least 1 sq ft',
            'apartment_area.max' => 'Apartment area must not exceed 10,000 sq ft',
            'apartment_type.required' => 'Apartment type selection is required',
            'apartment_type.exists' => 'Selected apartment type is invalid',
            'owner_id.exists' => 'Selected owner is invalid',
            'parking_id.*.exists' => 'One or more selected parking spaces are invalid',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $apartment->tower_id         = $request->tower_id;
        $apartment->floor_id         = $request->floor_id;
        $apartment->apartment_number = $request->apartment_number;
        $apartment->apartment_area   = $request->apartment_area;
        $apartment->apartment_type   = $request->apartment_type;
        $apartment->status           = $request->status ?: 'Available';
        $apartment->parking_id       = $request->parking_id ? json_encode($request->parking_id) : '';
        $apartment->owner_id         = $request->owner_id;
        $apartment->save();
        
        //  Update Owner table also
        if ($request->owner_id) {
            $owner = Owner::find($request->owner_id);
            if ($owner) {
                $owner->tower_id     = $apartment->tower_id;
                $owner->floor_id     = $apartment->floor_id;
                $owner->apartment_id = $apartment->id;
                $owner->save();
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Apartment updated successfully.',
                'apartment' => $apartment->load(['tower', 'floor', 'type']),
                'redirect' => route('apartments.index')
            ]);
        }

        return redirect()->route('apartments.index')->with('success', 'Apartment updated successfully.');
    }

    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('apartments.index')->with('success', 'Apartment deleted successfully.');
    }

}