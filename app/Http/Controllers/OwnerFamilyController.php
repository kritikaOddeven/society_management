<?php

namespace App\Http\Controllers;
use App\Models\OwnerFamily;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerFamilyController extends Controller
{
   
    public function create()
    {
        $owners = Owner::all();
        return view('owner_families.create', compact('owners'));
    }

   public function store(Request $request, $owner_id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'relation' => 'required|string|max:255',
    ]);

    OwnerFamily::create([
        'owner_id' => $owner_id,
        'name' => $request->name,
        'relation' => $request->relation,
    ]);

    return back()->with('success', 'Family member added successfully.');
}


    public function edit($id)
    {
        $family = OwnerFamily::findOrFail($id);
        $owners = Owner::all();
        return view('owner_families.edit', compact('family', 'owners'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'owner_id' => 'nullable|exists:owners,id',
            'name' => 'required|string|max:255',
            'relation' => 'required|string|max:255',
        ]);

        $family = OwnerFamily::findOrFail($id);
        $family->update($request->all());

        return redirect()->route('owner_families.index')->with('success', 'Family member updated successfully');
    }

    public function destroy($id)
    {
        OwnerFamily::findOrFail($id)->delete();
        return back()->with('success', 'Family member deleted successfully');
    }
}