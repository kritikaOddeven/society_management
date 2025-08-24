<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

// Public routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Password reset routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request')->middleware('guest');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset')->middleware('guest');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/update/', [ProfileController::class, 'updateProfile'])->name('update.profile');
    Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('update.password');
    
    // User management routes
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});