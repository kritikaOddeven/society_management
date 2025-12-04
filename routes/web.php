<?php

use App\Http\Controllers\AmenitieController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ApartmentTypeController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillTypeController;
use App\Http\Controllers\CommonAreaBillController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnerDocumentController;
use App\Http\Controllers\OwnerFamilyController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TowerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilityBillController;
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
    Route::post('owners/{id}/family', [OwnerFamilyController::class, 'store'])->name('owners.family.store');
    Route::delete('owners/family/{id}', [OwnerFamilyController::class, 'destroy'])->name('owners.family.destroy');
    Route::post('owners/{id}/document', [OwnerDocumentController::class, 'store'])->name('owners.document.store');
    Route::delete('owner-document/{id}', [OwnerDocumentController::class, 'destroy'])->name('owner.document.destroy');

    Route::resource('towers', TowerController::class)->except(['show', 'create', 'edit']);
    Route::get('towers/bulk-upload', [TowerController::class, 'bulkUpload'])->name('towers.bulk-upload');
    Route::get('towers/export', [TowerController::class, 'export'])->name('towers.export');
    Route::get('towers/download-template', [TowerController::class, 'downloadTemplate'])->name('towers.download-template');
    Route::get('towers/download-example', [TowerController::class, 'downloadExample'])->name('towers.download-example');
    Route::post('towers/import', [TowerController::class, 'import'])->name('towers.import');
    
    Route::resource('floors', FloorController::class)->except(['show', 'create', 'edit']);
    Route::get('floors/bulk-upload', [FloorController::class, 'bulkUpload'])->name('floors.bulk-upload');
    Route::get('floors/export', [FloorController::class, 'export'])->name('floors.export');
    Route::get('floors/download-template', [FloorController::class, 'downloadTemplate'])->name('floors.download-template');
    Route::get('floors/download-example', [FloorController::class, 'downloadExample'])->name('floors.download-example');
    Route::get('floors/download-towers', [FloorController::class, 'downloadTowers'])->name('floors.download-towers');
    Route::post('floors/import', [FloorController::class, 'import'])->name('floors.import');
    
    // Apartment specific routes (before resource routes)
    Route::get('apartments/bulk-upload', [ApartmentController::class, 'bulkUpload'])->name('apartments.bulk-upload');
    Route::get('apartments/export', [ApartmentController::class, 'export'])->name('apartments.export');
    Route::get('apartments/download-template', [ApartmentController::class, 'downloadTemplate'])->name('apartments.download-template');
    Route::get('apartments/download-example', [ApartmentController::class, 'downloadExample'])->name('apartments.download-example');
    Route::get('apartments/download-towers', [ApartmentController::class, 'downloadTowers'])->name('apartments.download-towers');
    Route::get('apartments/download-floors', [ApartmentController::class, 'downloadFloors'])->name('apartments.download-floors');
    Route::post('apartments/import', [ApartmentController::class, 'import'])->name('apartments.import');
    Route::resource('apartments', ApartmentController::class);
    Route::resource('parkings', ParkingController::class);
    Route::resource('amenities', AmenitieController::class);
    Route::resource('tenants', TenantController::class);
    Route::get('tenants/{tenant}/history', [TenantController::class, 'history'])->name('tenants.history');
    Route::get('tenants-history', [TenantController::class, 'allHistory'])->name('tenants.all-history');
    Route::resource('rents', TenantController::class);
    Route::resource('rents', RentController::class);
    Route::post('rents/payment', [RentController::class, 'payment'])->name('rents.payment');

    Route::get('/reports', function () {
        return view('reports.maintenance');
    });

    Route::resource('services', ServiceController::class);
    Route::get('services/get-floors/{towerId}', [ServiceController::class, 'getFloors']);
    Route::get('services/get-apartments/{floorId}', [ServiceController::class, 'getApartments']);

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::resource('types', ApartmentTypeController::class);
        Route::resource('service_types', ServiceTypeController::class);
        Route::resource('maintenance', MaintenanceController::class);
        Route::resource('bill_types', BillTypeController::class);

    });
    Route::prefix('bills')->as('bills.')->group(function () {
        Route::resource('utility', UtilityBillController::class)->except(['destroy']);
        Route::resource('common_area', CommonAreaBillController::class)->except(['destroy']);
        Route::get('maintenance', [BillController::class, 'maintenanceIndex'])->name('maintenance.index');
    });
});