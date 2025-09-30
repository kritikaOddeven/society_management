<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType;

class ServiceController extends Controller
{
     public function index()
    {
        $types = ServiceType::latest()->get();
        return view('settings.services_type.index', compact('types'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required,unique:service_types,service_type,',
        ]);

        $serviceType = new ServiceType();
        $serviceType->service_type     = $request->service_type;
        $serviceType->service_icon     = $request->service_icon;
        $serviceType->status     = $request->status;
        $serviceType->save();

        return redirect()->route('settings.service_types.index')->with('success', 'Service Type created successfully.');
    }

      public function update(Request $request, $id)
    {
        $request->validate([
            'service_type' => 'required',
        ]);

        $type = ApartmentType::find($id);
        $type->service_type = $request->service_type;
        $type->save();

        return redirect()->route('settings.service_types.index')->with('success', 'Tower updated successfully.');
    }

    public function destroy( $id)
    {
        $type = ServiceType::find($id);
        $type->delete();
        return redirect()->route('settings.service_types.index')->with('success', 'Service type deleted successfully.');
    }
}