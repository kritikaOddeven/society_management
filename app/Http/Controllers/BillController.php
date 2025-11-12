<?php
namespace App\Http\Controllers;
use App\Models\Rent;
use App\Models\Apartment;


class BillController extends Controller
{
    public function maintenanceIndex()
    {
        $years  = Rent::getYears();
        $months = Rent::getMonths();
        return view('bills.maintenance.index', compact('years', 'months'));

    }

    public function utilityIndex(){
        return view('bills.utility.index');
    }

     public function utilityCreate(){
        $apartments = Apartment::orderBy('apartment_number')->get();
        return view('bills.utility.create', compact('apartments'));
    }

    public function utilityStore(){
       
    }
}