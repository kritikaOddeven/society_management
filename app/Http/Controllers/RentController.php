<?php

namespace App\Http\Controllers;
use App\Models\Tower;
use Illuminate\Http\Request;


class RentController extends Controller
{
    public function index(){
       
        return view('rents.index');
    }

     public function create(){
         $towers = Tower::with(['floors.apartments' => function ($q) {
            $q->where('status', 'Rented'); // only on rent apartments
        }])->get();
       
        return view('rents.create', compact('towers'));
    }
}