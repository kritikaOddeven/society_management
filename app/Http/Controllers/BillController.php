<?php
namespace App\Http\Controllers;
use App\Models\Rent;


class BillController extends Controller
{
    public function maintenanceIndex()
    {
        $years  = Rent::getYears();
        $months = Rent::getMonths();
        return view('bills.maintenance.index', compact('years', 'months'));

    }

}