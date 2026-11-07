<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HistoryBookingController;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/paket', [PageController::class, 'packages'])->name('packages');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::get('/history-booking', [HistoryBookingController::class, 'index'])
    ->name('history.index');

Route::post('/history-booking/{booking}/rating', [HistoryBookingController::class, 'storeRating'])
    ->name('history.rating.store');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

    // Booking routes
Route::middleware('auth')->group(function () {

    Route::get('/booking/{package}', [BookingController::class, 'create'])
        ->name('booking.create');

    Route::post('/booking/{package}', [BookingController::class, 'store'])
        ->name('booking.store');

});
