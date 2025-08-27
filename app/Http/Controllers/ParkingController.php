<?php
namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Floor;
use App\Models\Parking;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function index()
    {
        $parkings   = Parking::with(['apartment', 'floor'])->latest()->paginate(10);
        $apartments = Apartment::orderBy('apartment_number')->get();
        $floors     = Floor::orderBy('floor_name')->get();
        return view('apartments.parking.index', compact('parkings', 'apartments', 'floors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'apartment_id' => 'nullable',
            'parking_code' => 'required',
            'floor_id'     => 'required',
            'status'       => 'nullable',
        ]);
        // dd($request->all());
        $parking               = new Parking();
        $parking->apartment_id = $request->apartment_id;
        $parking->parking_code = $request->parking_code;
        $parking->floor_id     = $request->floor_id;
        $parking->status       = $request->status ?? 'Available';
        $parking->save();
        // dd($parking);

        return redirect()->route('parkings.index')->with('success', 'Parking created successfully.');
    }

     public function update(Request $request, $id)
    {
        $request->validate([
            'apartment_id' => 'nullable',
            'parking_code' => 'required',
            'floor_id'     => 'required',
            'status'       => 'nullable',
        ]);
        $parking               = Parking::find($id);
        $parking->apartment_id = $request->apartment_id;
        $parking->parking_code = $request->parking_code;
        $parking->floor_id     = $request->floor_id;
        $parking->status       = $request->status ?? 'Available';
        // dd($parking);
        $parking->save();

        return redirect()->route('parkings.index')->with('success', 'Parking created successfully.');
    }

    public function destroy(Parking $parking)
    {
        $parking->delete();
        return redirect()->route('parkings.index')->with('success', 'Parking deleted successfully.');
    }
}
