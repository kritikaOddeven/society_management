<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tower;

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



    public function destroy(Tower $tower)
    {
        $tower->delete();
        return redirect()->route('towers.index')->with('success', 'Tower deleted successfully.');
    }
}
