<?php
namespace App\Http\Controllers;

use App\Models\Tower;
use Illuminate\Http\Request;

class TowerController extends Controller
{
    public function index()
    {
        $towers = Tower::latest()->get();
        return view('apartments.tower.index', compact('towers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tower_name' => 'required',
        ]);

        Tower::create($request->all());

        return redirect()->route('towers.index')->with('success', 'Tower created successfully.');
    }

   

    public function update(Request $request, $id)
    {
        $request->validate([
            'tower_name' => 'required',
        ]);

        $tower = Tower::find($id);
        $tower->tower_name = $request->tower_name;
        $tower->save();

        return redirect()->route('towers.index')->with('success', 'Tower updated successfully.');
    }

    public function destroy(Tower $tower)
    {
        $tower->delete();
        return redirect()->route('towers.index')->with('success', 'Tower deleted successfully.');
    }
}
