<?php
namespace App\Http\Controllers;
use App\Models\Floor;
use App\Models\Tower;
use App\Models\ApartmentType;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = null;
        return view('apartments.index', compact('apartments'));
    }

    public function create()
{
    $towers = Tower::with('floors')->orderBy('tower_name')->get();
    $types = ApartmentType::orderBy('apartment_type')->get();
    return view('apartments.create', compact('towers', 'types'));
}


   
}
