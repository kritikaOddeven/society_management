<?php

namespace App\Http\Controllers;
use App\Models\BillType;

use Illuminate\Http\Request;

class BillTypeController extends Controller
{
     public function index()
    {
        $types = BillType::latest()->get();
        return view('settings.bill_types.index', compact('types'));
    }

       public function store(Request $request)
    {
        $request->validate([
            'bill_type' => 'required',
            'type_category' => 'required',
        ]);

        $billType = new BillType();
        $billType->bill_type     = $request->bill_type;
        $billType->type_category     = $request->type_category;
        $billType->status     = $request->status;
        $billType->save();

        return redirect()->route('settings.bill_types.index')->with('success', 'Bill Type created successfully.');
    }  

      public function update(Request $request, $id)
    {
        $request->validate([
            'bill_type' => 'required',
            'type_category' => 'required',
        ]);

        $type = BillType::find($id);
        $type->bill_type     = $request->bill_type;
        $type->type_category     = $request->type_category;
        $type->status     = $request->status;
        $type->save();

        return redirect()->route('settings.bill_types.index')->with('success', 'Bill Type updated successfully.');
    }

    public function destroy( $id)
    {
        $type = BillType::find($id);
        $type->delete();
        return redirect()->route('settings.bill_types.index')->with('success', 'Bill type deleted successfully.');
    }
}