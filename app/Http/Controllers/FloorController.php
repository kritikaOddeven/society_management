<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FloorController extends Controller
{
     public function index()
    {
        $floors = null;
        return view('apartments.floor.index', compact('floors'));
    }
}
