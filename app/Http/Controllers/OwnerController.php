<?php
namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Owner;
use App\Models\Tower;
use App\Models\Parking;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::with(['tower', 'floor', 'apartment', 'parking'])->latest()->get();
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        $towers = Tower::with(['floors.apartments' => function ($q) {
            $q->where('status', 'Unsold'); // only unsold apartments
        }])->get();
        $parkings = Parking::where('status', 'Available')->orderBy('parking_code')->get();

        return view('owners.create', compact('towers', 'parkings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'phone_number' => 'required',
            'country_code' => 'required',
            'email'        => 'nullable',
            'tower_id'     => 'nullable',
            'floor_id'     => 'nullable',
            'apartment_id' => 'nullable',
            'parking_id'   => 'nullable|exists:parkings,id',
        ]);
        // dd($request->all());

        $owner               = new Owner();
        $owner->tower_id     = $request->tower_id;
        $owner->floor_id     = $request->floor_id;
        $owner->apartment_id = $request->apartment_id;
        $owner->name         = $request->name;
        $owner->email        = $request->email;
        $owner->phone_number = $request->phone_number;
        $owner->country_code = $request->country_code;
        $owner->parking_id   = $request->parking_id;
        // dd($owner);

        // Handle profile image upload directly to public folder
        if ($request->hasFile('profile_image')) {
            $file     = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profile_images'), $filename);

            $owner->profile_image = 'profile_images/' . $filename;
        }
        $owner->save();

        // Update apartment status using model
        if ($request->apartment_id) {
            $apartment = Apartment::find($request->apartment_id);
            if ($apartment) {
                $apartment->status = 'Occupied';
                $apartment->owner_id = $owner->id;
                $apartment->save();
            }
        }

        if ($request->parking_id) {
            $parking = Parking::find($request->parking_id);
            if ($parking) {
                $parking->status       = 'Occupied';
                $parking->apartment_id = $owner->apartment_id;
                $parking->save();
            }
        }

        return redirect()->route('owners.index')->with('success', 'Owner created successfully.');
    }

    public function show($id)
    {
        $owner = Owner::with('apartments')->findOrFail($id);
        // Load towers with floors and apartments (only unsold apartments)
        $towers = Tower::with(['floors.apartments' => function ($q) {
            $q->where('status', 'Unsold');
        }])->get();
        // $parking_codes = Parking::whereIn('id', json_decode($owner->apartments->parking_id))->pluck('parking_code')->toArray();
        return view('owners.view', compact('owner', 'towers'));
    }

    public function edit($id)
    {
        $owner = Owner::findOrFail($id);

        // Load towers with floors and apartments (only unsold apartments)
        $towers = Tower::with(['floors.apartments' => function ($q) {
            $q->where('status', 'Unsold');
        }])->get();
        $parkings = Parking::where('status', 'Available')
            ->when($owner->parking_id, function ($query) use ($owner) {
                return $query->orWhere('id', $owner->parking_id);
            })
            ->orderBy('parking_code')
            ->get();

        return view('owners.edit', compact('owner', 'towers', 'parkings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required',
            'phone_number' => 'required',
            'country_code' => 'required',
            'email'        => 'nullable',
            'tower_id'     => 'nullable',
            'floor_id'     => 'nullable',
            'apartment_id' => 'nullable',
            'parking_id'   => 'nullable|exists:parkings,id',
        ]);

        $owner = Owner::findOrFail($id);

        // Save previous apartment_id to revert its status if changed
        $oldApartmentId = $owner->apartment_id;
        $oldParkingId   = $owner->parking_id;
        $previousImage  = $owner->profile_image;

        $owner->tower_id     = $request->tower_id;
        $owner->floor_id     = $request->floor_id;
        $owner->apartment_id = $request->apartment_id;
        $owner->name         = $request->name;
        $owner->email        = $request->email;
        $owner->phone_number = $request->phone_number;
        $owner->country_code = $request->country_code;
        $owner->parking_id   = $request->parking_id;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file     = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Move file to public/profile_images folder
            $file->move(public_path('profile_images'), $filename);

            // Delete old image if exists
            if ($previousImage && file_exists(public_path($previousImage))) {
                unlink(public_path($previousImage));
            }

            $owner->profile_image = 'profile_images/' . $filename;
        }

        $owner->save();

        // Revert old apartment to 'Unsold' if changed
        if ($oldApartmentId && $oldApartmentId != $owner->apartment_id) {
            $oldApartment = Apartment::find($oldApartmentId);
            if ($oldApartment) {
                $oldApartment->status   = 'Unsold';
                $oldApartment->owner_id = null;
                $oldApartment->save();
            }
        }

        // Update new apartment to 'Occupied'
        if ($owner->apartment_id) {
            $apartment = Apartment::find($owner->apartment_id);
            if ($apartment) {
                $apartment->status   = 'Occupied';
                $apartment->owner_id = $owner->id;
                $apartment->save();
            }
        }

        // Revert previous parking slot if changed
        if ($oldParkingId && $oldParkingId != $owner->parking_id) {
            $oldParking = Parking::find($oldParkingId);
            if ($oldParking) {
                $oldParking->status       = 'Available';
                $oldParking->apartment_id = null;
                $oldParking->save();
            }
        }

        // Mark the selected parking slot as occupied
        if ($owner->parking_id) {
            $parking = Parking::find($owner->parking_id);
            if ($parking) {
                $parking->status       = 'Occupied';
                $parking->apartment_id = $owner->apartment_id;
                $parking->save();
            }
        }

        return redirect()->route('owners.index')->with('success', 'Owner updated successfully.');
    }

    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);

        // Delete profile image if exists
        if ($owner->profile_image && file_exists(public_path($owner->profile_image))) {
            unlink(public_path($owner->profile_image));
        }

        $owner->delete();

        return redirect()->route('owners.index')->with('success', 'Owner deleted successfully.');
    }

}