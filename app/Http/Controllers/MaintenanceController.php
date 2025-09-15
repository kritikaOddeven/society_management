<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
  

     public function index()
    {
        // $types = ApartmentType::latest()->get();
        return view('settings.maintenance.index');
    }
}