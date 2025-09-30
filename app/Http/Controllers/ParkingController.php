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
        $validator = \Validator::make($request->all(), [
            'apartment_id' => 'nullable|exists:apartments,id',
            'parking_code' => 'required|string|min:1|max:20|unique:parkings,parking_code',
            'floor_id'     => 'required|exists:floors,id',
        ], [
            'apartment_id.exists' => 'Selected apartment is invalid',
            'parking_code.required' => 'Parking code is required',
            'parking_code.min' => 'Parking code must be at least 1 character',
            'parking_code.max' => 'Parking code must not exceed 20 characters',
            'parking_code.unique' => 'This parking code already exists',
            'floor_id.required' => 'Floor selection is required',
            'floor_id.exists' => 'Selected floor is invalid',
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

        $parking               = new Parking();
        $parking->apartment_id = $request->apartment_id;
        $parking->parking_code = $request->parking_code;
        $parking->floor_id     = $request->floor_id;
        $parking->status       = $request->apartment_id ? 'Occupied' : 'Available';
        $parking->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Parking created successfully.',
                'parking' => $parking->load(['apartment', 'floor'])
            ]);
        }

        return redirect()->back()->with('success', 'Parking created successfully.');
    }

     public function update(Request $request, $id)
    {
        $parking = Parking::findOrFail($id);
        
        $validator = \Validator::make($request->all(), [
            'apartment_id' => 'nullable|exists:apartments,id',
            'parking_code' => 'required|string|min:1|max:20|unique:parkings,parking_code,' . $id,
            'floor_id'     => 'required|exists:floors,id',
        ], [
            'apartment_id.exists' => 'Selected apartment is invalid',
            'parking_code.required' => 'Parking code is required',
            'parking_code.min' => 'Parking code must be at least 1 character',
            'parking_code.max' => 'Parking code must not exceed 20 characters',
            'parking_code.unique' => 'This parking code already exists',
            'floor_id.required' => 'Floor selection is required',
            'floor_id.exists' => 'Selected floor is invalid',
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

        $parking->apartment_id = $request->apartment_id;
        $parking->parking_code = $request->parking_code;
        $parking->floor_id     = $request->floor_id;
        $parking->status       = $request->apartment_id ? 'Occupied' : 'Available';
        $parking->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Parking updated successfully.',
                'parking' => $parking->load(['apartment', 'floor'])
            ]);
        }

        return redirect()->route('parkings.index')->with('success', 'Parking updated successfully.');
    }

    public function destroy(Parking $parking)
    {
        $parking->delete();
        return redirect()->route('parkings.index')->with('success', 'Parking deleted successfully.');
    }
}
