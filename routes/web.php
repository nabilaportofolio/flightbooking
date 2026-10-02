<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Flight search
Route::get('/search', [FlightController::class, 'search'])->name('flights.search');
Route::get('/destinations', [FlightController::class, 'destinations'])->name('destinations');

// Halaman sidebar butuh login
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [FlightController::class, 'myBookings'])->name('bookings');

    Route::get('/profile', function () {
        return view('pages.profile');
    })->name('profile');

    Route::get('/flight-status', [FlightController::class, 'flightStatus'])
    ->name('flight.status');

    Route::get('/check-in', function () {
        return view('pages.checkin');
    })->name('checkin');

    Route::post('/check-in', function () {
        return redirect()->route('checkin')->with('success', 'Check-in berhasil diproses.');
    })->name('checkin.process');

    Route::get('/contact', function () {
        return view('pages.contact');
    })->name('contact');

    Route::get('/booking', [FlightController::class, 'booking'])->name('flights.booking');
    Route::get('/payment', [FlightController::class, 'payment'])->name('flights.payment');
    Route::post('/payment/process', [FlightController::class, 'processPayment'])->name('flights.payment.process');
    Route::get('/ticket/{booking_code}', [FlightController::class, 'showTicket'])->name('flights.ticket');
    Route::get('/booking-detail/{booking_code}', [FlightController::class, 'bookingDetail'])->name('booking.detail');
    Route::get('/flight/{code}', [FlightController::class, 'show'])->name('flight.show');
});