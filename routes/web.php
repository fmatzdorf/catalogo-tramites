<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Procedures (available to all authenticated users)
    Route::resource('procedures', ProcedureController::class);

    // Users (available to all authenticated users, but filtered by role)
    Route::resource('users', UserController::class);

    // Institutions (admin can manage all, institutional users can view their own)
    Route::resource('institutions', InstitutionController::class);

    // Categories (admin only)
    // Route::middleware(['can:admin'])->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('activity-logs', ActivityLogController::class)->only(['index', 'show']);
    });
});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-test', function () {
        return 'Admin access granted!';
    });
});

Route::middleware(['auth', 'institutional'])->group(function () {
    Route::get('/institutional-test', function () {
        return 'Institutional access granted!';
    });
});
*/
require __DIR__.'/auth.php';
