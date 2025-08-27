<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\Parking;

class ParkingController extends Controller
{
    public function index()
    {
        $parkings = Parking::with('floor')->latest()->get();
        return view('apartments.parking.index', compact('parkings'));
    }
}
