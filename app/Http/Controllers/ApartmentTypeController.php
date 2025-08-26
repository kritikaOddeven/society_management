<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApartmentType;

class ApartmentTypeController extends Controller
{
     public function index()
    {
        $types = ApartmentType::latest()->get();
        return view('settings.apartment_type.index', compact('types'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'apartment_type' => 'required',
        ]);

        ApartmentType::create($request->all());

        return redirect()->route('types.index')->with('success', 'Apartment Type created successfully.');
    }

      public function update(Request $request, $id)
    {
        $request->validate([
            'apartment_type' => 'required',
        ]);

        $type = ApartmentType::find($id);
        $type->apartment_type = $request->apartment_type;
        $type->save();

        return redirect()->route('types.index')->with('success', 'Tower updated successfully.');
    }

    public function destroy( $id)
    {
        $type = ApartmentType::find($id);
        $type->delete();
        return redirect()->route('types.index')->with('success', 'Apartment type deleted successfully.');
    }
}
