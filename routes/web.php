<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TowerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApartmentTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    Route::resource('owners', OwnerController::class);

    Route::resource('towers', TowerController::class);
    Route::resource('floors', FloorController::class);
    Route::resource('apartments', ApartmentController::class);

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::resource('types', ApartmentTypeController::class);
    });
});
