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
}
