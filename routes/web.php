<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Landlord\RentalController as LandlordRentalController;
use App\Http\Controllers\Landlord\RentalRequestController as LandlordRentalRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\RentalController as StudentRentalController;
use App\Http\Controllers\Student\RentalRequestController as StudentRentalRequestController;
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

    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');

    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::middleware(['auth', 'role:landlord'])->group(function () {
    Route::get('/landlord/dashboard', [LandlordDashboard::class, 'index'])->name('landlord.dashboard');
    Route::get('/landlord/rentals/create', [LandlordRentalController::class, 'create'])->name('landlord.rentals.create');
    Route::post('/landlord/rentals', [LandlordRentalController::class, 'store'])->name('landlord.rentals.store');
    Route::get('/landlord/rentals', [LandlordRentalController::class, 'index'])->name('landlord.rentals.index');
    Route::get('/landlord/rentals/{id}/edit', [LandlordRentalController::class, 'edit'])->name('landlord.rentals.edit');
    Route::put('/landlord/rentals/{id}', [LandlordRentalController::class, 'update'])->name('landlord.rentals.update');
    Route::delete('/landlord/rentals/{id}', [LandlordRentalController::class, 'destroy'])->name('landlord.rentals.destroy');
    Route::get('/landlord/requests', [LandlordRentalRequestController::class, 'landlordRequests'])->name('landlord.requests.index');
    Route::put('/landlord/requests/{id}', [LandlordRentalRequestController::class, 'updateStatus'])->name('landlord.requests.update');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboard::class, 'index'])->name('student.dashboard');
    Route::get('/rentals', [StudentRentalController::class, 'index'])->name('student.rentals.index');
    Route::get('/rentals/{id}', [StudentRentalController::class, 'show'])->name('student.rentals.show');
    Route::post('/rentals/{id}/request', [StudentRentalRequestController::class, 'store'])->name('student.rentals.request');
    Route::get('/my-requests', [StudentRentalRequestController::class, 'index'])->name('student.requests.index');
});
