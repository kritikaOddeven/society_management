<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType;
use App\Models\Tower;

class ServiceController extends Controller
{
    public function index()
    {
        $types = ServiceType::get();
        return view('services.index', compact('types'));
    }

    
    public function create()
    {
        $types = ServiceType::get();
         $towers = Tower::with(['floors.apartments'])->get();
        return view('services.create', compact('types', 'towers'));
    }

    
    public function store(Request $request)
    {
        //
    }

   
    public function show(string $id)
    {
        //
    }

   
    public function edit(string $id)
    {
        //
    }

   
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}