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
        $validator = \Validator::make($request->all(), [
            'amenity_name' => 'required|string|max:255',
            'tower_id'     => 'nullable|exists:towers,id',
            'open_time'    => 'nullable|date_format:H:i',
            'close_time'   => 'nullable|date_format:H:i',
            'status'       => 'nullable|in:active,inactive',
        ], [
            'amenity_name.required' => 'Amenity name is required',
            'amenity_name.max' => 'Amenity name must not exceed 255 characters',
            'tower_id.exists' => 'Selected tower is invalid',
            'open_time.date_format' => 'Invalid time format for open time',
            'close_time.date_format' => 'Invalid time format for close time',
            'status.in' => 'Status must be active or inactive',
        ]);

        // Custom validation for close time after open time
        if ($request->open_time && $request->close_time) {
            if ($request->close_time <= $request->open_time) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('close_time', 'Close time must be after open time');
                });
            }
        }

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $amenity                   = new Amenity();
        $amenity->tower_id         = $request->tower_id;
        $amenity->amenity_name     = $request->amenity_name;
        $amenity->open_time        = $request->open_time;
        $amenity->close_time      = $request->close_time;
        $amenity->status           = $request->status ?: 'active';
        $amenity->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Amenity created successfully.',
                'amenity' => $amenity->load('tower')
            ]);
        }

        return redirect()->route('amenities.index')->with('success', 'Amenity created successfully.');
    }

    public function update(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);
        
        $validator = \Validator::make($request->all(), [
            'amenity_name' => 'required|string|max:255',
            'tower_id'     => 'nullable|exists:towers,id',
            'open_time'    => 'nullable|date_format:H:i',
            'close_time'   => 'nullable|date_format:H:i',
            'status'       => 'nullable|in:active,inactive',
        ], [
            'amenity_name.required' => 'Amenity name is required',
            'amenity_name.max' => 'Amenity name must not exceed 255 characters',
            'tower_id.exists' => 'Selected tower is invalid',
            'open_time.date_format' => 'Invalid time format for open time',
            'close_time.date_format' => 'Invalid time format for close time',
            'status.in' => 'Status must be active or inactive',
        ]);

        // Custom validation for close time after open time
        if ($request->open_time && $request->close_time) {
            if ($request->close_time <= $request->open_time) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('close_time', 'Close time must be after open time');
                });
            }
        }

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $amenity->tower_id         = $request->tower_id;
        $amenity->amenity_name     = $request->amenity_name;
        $amenity->open_time        = $request->open_time;
        $amenity->close_time      = $request->close_time;
        $amenity->status           = $request->status ?: 'active';
        $amenity->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Amenity updated successfully.',
                'amenity' => $amenity->load('tower')
            ]);
        }

        return redirect()->route('amenities.index')->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();
        return redirect()->route('amenities.index')->with('success', 'Amenity deleted successfully.');
    }
}