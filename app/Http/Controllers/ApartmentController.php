<?php
namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\ApartmentType;
use App\Models\Tower;
use App\Models\Parking;
use App\Models\Owner;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with(['tower', 'floor', 'type'])->latest()->get();
        return view('apartments.index', compact('apartments'));
    }

    public function create()
    {
        $towers = Tower::with('floors')->orderBy('tower_name')->get();
        $types  = ApartmentType::orderBy('apartment_type')->get();
        $parkings  = Parking::orderBy('parking_code')->get();
        $owners  = Owner::orderBy('name')->get();
        return view('apartments.create', compact('towers', 'types', 'parkings', 'owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tower_id'         => 'required',
            'floor_id'         => 'required',
            'apartment_number' => 'required',
            'apartment_area'   => 'required',
            'apartment_type'   => 'required',
            'status'           => 'nullable',
        ]);
        // dd($request->all());

        $apartment                   = new Apartment();
        $apartment->tower_id         = $request->tower_id;
        $apartment->floor_id         = $request->floor_id;
        $apartment->apartment_number = $request->apartment_number;
        $apartment->apartment_area   = $request->apartment_area;
        $apartment->apartment_type   = $request->apartment_type;
        $apartment->status           = $request->status;
        $apartment->parking_id           = $request->parking_id;
        $apartment->owner_id           = $request->owner_id;
        $apartment->save();
        // dd($apartment);

        return redirect()->route('apartments.index')->with('success', 'Apartment created successfully.');
    }

    public function edit(Apartment $apartment)
    {
        $towers = Tower::with('floors')->orderBy('tower_name')->get();
        $types  = ApartmentType::orderBy('apartment_type')->get();
        $parkings  = Parking::where('status', 'Available')->get();
        $owners  = Owner::orderBy('name')->get();
        return view('apartments.edit', compact('apartment', 'towers', 'types', 'parkings', 'owners'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tower_id'         => 'required',
            'floor_id'         => 'required',
            'apartment_number' => 'required',
            'apartment_area'   => 'required',
            'apartment_type'   => 'required',
            'status'           => 'nullable',
        ]);
        // dd($request->all());

        $apartment                   = Apartment::find($id);
        $apartment->tower_id         = $request->tower_id;
        $apartment->floor_id         = $request->floor_id;
        $apartment->apartment_number = $request->apartment_number;
        $apartment->apartment_area   = $request->apartment_area;
        $apartment->apartment_type   = $request->apartment_type;
        $apartment->status           = $request->status;
        $apartment->parking_id           = $request->parking_id;
        $apartment->owner_id           = $request->owner_id;
        $apartment->save();
        // dd($apartment);

        return redirect()->route('apartments.index')->with('success', 'Apartment updated successfully.');
    }

     public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('apartments.index')->with('success','Apartment deleted successfully.');
    }

}
