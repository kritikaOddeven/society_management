<?php
namespace App\Http\Controllers;
use App\Models\Rent;


class BillController extends Controller
{
    public function index()
    {
        $years  = Rent::getYears();
        $months = Rent::getMonths();
        return view('bills.index', compact('years', 'months'));

    }
}
