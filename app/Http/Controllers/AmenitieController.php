<?php

namespace App\Http\Controllers;
use App\Models\Tower;
use App\Models\Amenity;

use Illuminate\Http\Request;

class AmenitieController extends Controller
{
    public function index()
    {
        $amenities = Amenity::with('tower')->latest()->get();
         $towers = Tower::orderBy('tower_name')->get();
        return view('amenities.index', compact('amenities', 'towers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amenity_name' => 'required',
            'tower_id'         => 'nullable',
            'open_time'   => 'nullable',
            'close_time'   => 'nullable',
            'status'           => 'nullable',
        ]);

        $amenity                   = new Amenity();
        $amenity->tower_id         = $request->tower_id;
        $amenity->amenity_name = $request->amenity_name;
        $amenity->open_time   = $request->open_time;
        $amenity->close_time   = $request->close_time;
        $amenity->status           = $request->status;
        $amenity->save();

        return redirect()->route('amenities.index')->with('success', 'Amenity created successfully.');
    }

    public function update(Request $request, $id)
    {

         $request->validate([
            'amenity_name' => 'required',
            'tower_id'         => 'nullable',
            'open_time'   => 'nullable',
            'close_time'   => 'nullable',
            'status'           => 'nullable',
        ]);

        $amenity                   = Amenity::find($id);
        $amenity->tower_id         = $request->tower_id;
        $amenity->amenity_name = $request->amenity_name;
        $amenity->open_time   = $request->open_time;
        $amenity->close_time   = $request->close_time;
        $amenity->status           = $request->status;
        $amenity->save();

        return redirect()->route('amenities.index')->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();
        return redirect()->route('amenities.index')->with('success', 'Amenity deleted successfully.');
    }
}