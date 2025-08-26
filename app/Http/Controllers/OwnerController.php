<?php
namespace App\Http\Controllers;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = null;
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }
}
