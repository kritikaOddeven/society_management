<?php
namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Tower;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::with('tower')->latest()->get();
        $towers = Tower::orderBy('tower_name')->get();
        return view('apartments.floor.index', compact('floors', 'towers'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'tower_id'   => 'required|exists:towers,id',
            'floor_name' => 'required|string|min:1|max:50',
        ], [
            'tower_id.required' => 'Tower selection is required',
            'tower_id.exists' => 'Selected tower is invalid',
            'floor_name.required' => 'Floor name is required',
            'floor_name.min' => 'Floor name must be at least 1 character',
            'floor_name.max' => 'Floor name must not exceed 50 characters',
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

        $floor = Floor::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Floor created successfully.',
                'floor' => $floor->load('tower')
            ]);
        }

        return redirect()->route('floors.index')->with('success', 'Floor created successfully.');
    }

    public function update(Request $request, $id)
    {
        $floor = Floor::findOrFail($id);
        
        $validator = \Validator::make($request->all(), [
            'tower_id'   => 'required|exists:towers,id',
            'floor_name' => 'required|string|min:1|max:50',
        ], [
            'tower_id.required' => 'Tower selection is required',
            'tower_id.exists' => 'Selected tower is invalid',
            'floor_name.required' => 'Floor name is required',
            'floor_name.min' => 'Floor name must be at least 1 character',
            'floor_name.max' => 'Floor name must not exceed 50 characters',
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

        $floor->floor_name = $request->floor_name;
        $floor->tower_id = $request->tower_id;
        $floor->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Floor updated successfully.',
                'floor' => $floor->load('tower')
            ]);
        }

        return redirect()->route('floors.index')->with('success', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        $floor->delete();
        return redirect()->route('floors.index')->with('success', 'Floor deleted successfully.');
    }
}
