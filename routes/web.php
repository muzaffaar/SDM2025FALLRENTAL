<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/admin/dashboard', fn() => view('dashboards.admin'))->name('dashboard.admin');
});

Route::middleware(['auth', 'role:landlord'])->group(function () {
    Route::get('/landlord/dashboard', fn() => view('dashboards.landlord'))->name('dashboard.landlord');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', fn() => view('dashboards.student'))->name('dashboard.student');
});
