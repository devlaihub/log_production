<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductionLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return redirect()->route('login'); // Redirect ke login jika belum login
});

Route::middleware('auth')->group(function () {
    // Halaman Profil dan production-log hanya bisa diakses oleh pengguna yang sudah login
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Halaman production log
    Route::get('/production-log', [ProductionLogController::class, 'showForm'])->name('production-log.showForm');
    Route::post('/production-log', [ProductionLogController::class, 'store'])->name('production-log.store');
    Route::get('/production-log/data', [ProductionLogController::class, 'getData'])->name('production-log.data');
    Route::put('/production-log/update/{id}', [ProductionLogController::class, 'update'])->name('production-log.update');
});

// Login Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Register Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

require __DIR__.'/auth.php';
