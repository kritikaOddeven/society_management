<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TowerController extends Controller
{
     public function index()
    {
        $towers = null;
        return view('apartments.tower.index', compact('towers'));
    }
}
