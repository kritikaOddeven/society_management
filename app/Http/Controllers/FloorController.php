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
        $request->validate([
            'tower_id'   => 'required|exists:towers,id',
            'floor_name' => 'required',
        ]);

        Floor::create($request->all());

        return redirect()->route('floors.index')->with('success', 'Floor created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'floor_name' => 'required',
            'tower_id' => 'required',
        ]);

        $floor = Floor::find($id);
        $floor->floor_name = $request->floor_name;
        $floor->tower_id = $request->tower_id;
        $floor->save();

        return redirect()->route('floors.index')->with('success', 'Tower updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        $floor->delete();
        return redirect()->route('floors.index')->with('success', 'Floor deleted successfully.');
    }
}
