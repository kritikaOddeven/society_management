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
        $validator = \Validator::make($request->all(), [
            'tower_name' => 'required|string|min:2|max:100|unique:towers,tower_name',
        ], [
            'tower_name.required' => 'Tower name is required',
            'tower_name.min' => 'Tower name must be at least 2 characters',
            'tower_name.max' => 'Tower name must not exceed 100 characters',
            'tower_name.unique' => 'This tower name already exists',
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

        $tower = Tower::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tower created successfully.',
                'tower' => $tower
            ]);
        }

        return redirect()->route('towers.index')->with('success', 'Tower created successfully.');
    }

   

    public function update(Request $request, $id)
    {
        $tower = Tower::findOrFail($id);
        
        $validator = \Validator::make($request->all(), [
            'tower_name' => 'required|string|min:2|max:100|unique:towers,tower_name,' . $id,
        ], [
            'tower_name.required' => 'Tower name is required',
            'tower_name.min' => 'Tower name must be at least 2 characters',
            'tower_name.max' => 'Tower name must not exceed 100 characters',
            'tower_name.unique' => 'This tower name already exists',
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

        $tower->tower_name = $request->tower_name;
        $tower->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tower updated successfully.',
                'tower' => $tower
            ]);
        }

        return redirect()->route('towers.index')->with('success', 'Tower updated successfully.');
    }

    public function destroy(Tower $tower)
    {
        $tower->delete();
        return redirect()->route('towers.index')->with('success', 'Tower deleted successfully.');
    }
}
