<?php
namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Owner;
use App\Models\Tower;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::with(['tower', 'floor', 'apartment'])->latest()->get();
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        $towers = Tower::with(['floors.apartments' => function ($q) {
            $q->where('status', 'Unsold'); // only unsold apartments
        }])->get();

        return view('owners.create', compact('towers'));
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

        return redirect()->route('owners.index')->with('success', 'Owner created successfully.');
    }

    public function edit($id)
    {
        $owner = Owner::findOrFail($id);

        // Load towers with floors and apartments (only unsold apartments)
        $towers = Tower::with(['floors.apartments' => function ($q) {
            $q->where('status', 'Unsold');
        }])->get();

        return view('owners.edit', compact('owner', 'towers'));
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
        ]);

        $owner = Owner::findOrFail($id);

        // Save previous apartment_id to revert its status if changed
        $oldApartmentId = $owner->apartment_id;

        $owner->tower_id     = $request->tower_id;
        $owner->floor_id     = $request->floor_id;
        $owner->apartment_id = $request->apartment_id;
        $owner->name         = $request->name;
        $owner->email        = $request->email;
        $owner->phone_number = $request->phone_number;
        $owner->country_code = $request->country_code;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file     = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Move file to public/profile_images folder
            $file->move(public_path('profile_images'), $filename);

            // Delete old image if exists
            if ($owner->profile_image && file_exists(public_path($owner->profile_image))) {
                unlink(public_path($owner->profile_image));
            }

            $owner->profile_image = 'profile_images/' . $filename;

            $owner->save();

            // Revert old apartment to 'Unsold' if changed
            if ($oldApartmentId && $oldApartmentId != $request->apartment_id) {
                $oldApartment = Apartment::find($oldApartmentId);
                if ($oldApartment) {
                    $oldApartment->status = 'Unsold';
                    $oldApartment->owner_id = $owner->id;
                    $oldApartment->save();
                }
            }

            // Update new apartment to 'Occupied'
            if ($request->apartment_id) {
                $apartment = Apartment::find($request->apartment_id);
                if ($apartment) {
                    $apartment->status = 'Occupied';
                    $apartment->owner_id = $owner->id;
                    $apartment->save();
                }
            }
            return redirect()->route('owners.index')->with('success', 'Owner updated successfully.');
        }
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
