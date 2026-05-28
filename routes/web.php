<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'throttle:15,1'])->group(function () {
    Route::get('/dashboard', [CountryController::class, 'index'])->name('dashboard');
    Route::post('/favourites', [CountryController::class, 'store'])->name('favourites.store');
    Route::put('/favourites/{id}', [CountryController::class, 'update'])->name('favourites.update');
    Route::delete('/favourites/{id}', [CountryController::class, 'destroy'])->name('favourites.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
