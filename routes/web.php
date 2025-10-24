<?php

use App\Http\Controllers\Landlord\RentalController as LandlordRentalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalRequestController;
use App\Http\Controllers\Student\RentalController as StudentRentalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Landlord\DashboardController as LandlordDashboard;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:landlord'])->group(function () {
    Route::get('/landlord/dashboard', [LandlordDashboard::class, 'index'])->name('landlord.dashboard');
    Route::get('/landlord/rentals/create', [LandlordRentalController::class, 'create'])->name('landlord.rentals.create');
    Route::post('/landlord/rentals', [LandlordRentalController::class, 'store'])->name('landlord.rentals.store');
    Route::get('/landlord/rentals', [LandlordRentalController::class, 'index'])->name('landlord.rentals.index');
    Route::get('/landlord/rentals/{id}/edit', [LandlordRentalController::class, 'edit'])->name('landlord.rentals.edit');
    Route::put('/landlord/rentals/{id}', [LandlordRentalController::class, 'update'])->name('landlord.rentals.update');
    Route::delete('/landlord/rentals/{id}', [LandlordRentalController::class, 'destroy'])->name('landlord.rentals.destroy');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboard::class, 'index'])->name('student.dashboard');
    Route::get('/rentals', [StudentRentalController::class, 'index'])->name('student.rentals.index');
    Route::post('/rentals/{id}/request', [RentalRequestController::class, 'store'])->name('student.rentals.request');
    Route::get('/my-requests', [RentalRequestController::class, 'index'])->name('student.requests.index');
});
