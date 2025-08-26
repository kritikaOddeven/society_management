<?php
namespace App\Http\Controllers;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = null;
        return view('apartments.index', compact('apartments'));
    }

    public function create()
    {
        return view('apartments.create');
    }

   
}
