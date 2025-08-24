<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});