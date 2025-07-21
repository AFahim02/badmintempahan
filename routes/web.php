<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentStatusController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// About route
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Authentication routes
Auth::routes();

// Home route after login (User Dashboard)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Profile routes (User Dashboard)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update']);
});

// Reservation routes
Route::middleware(['auth'])->group(function () {
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('reservations/create/{venue_id}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Reservation history route
    Route::get('/reservations/history', [ReservationController::class, 'showHistory'])->name('reservations.history');

    // Payment routes
    Route::post('/payment/create', [PaymentController::class, 'createBill'])->name('payment.create');
    Route::match(['get', 'post'], '/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
    Route::get('/payment/status', [PaymentStatusController::class, 'index'])->name('payment.status');
});


// Notification routes (User Dashboard)
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/reservations', [AdminController::class, 'reservationsIndex'])->name('admin.reservations.index');
    Route::get('/payment/status', [AdminController::class, 'paymentStatus'])->name('admin.payment.status');
    
    // New route for all user payment history
    Route::get('/payment/history', [AdminController::class, 'paymentHistory'])->name('admin.payment.history');


    // Venue management routes
    Route::get('/venues', [AdminController::class, 'venues'])->name('admin.venues.index');
    Route::get('/venues/create', [AdminController::class, 'createVenue'])->name('admin.venues.create');
    Route::post('/venues', [AdminController::class, 'storeVenue'])->name('admin.venues.store');
    Route::get('/venues/{id}/edit', [AdminController::class, 'editVenue'])->name('admin.venues.edit');
    Route::put('/venues/{id}', [AdminController::class, 'update'])->name('admin.venues.update');
    Route::delete('/venues/{id}', [AdminController::class, 'destroyVenue'])->name('admin.venues.destroy');

    // Notification routes for admin
    Route::get('/notifications', [NotificationController::class, 'create'])->name('admin.notifications.create'); // Admin notification form
    Route::post('/notifications/send', [NotificationController::class, 'sendNotification'])->name('admin.notifications.send'); // Send notification

    // New routes for admin reservation remind and delete
    Route::post('/reservations/{id}/remind', [AdminController::class, 'remindReservation'])->name('admin.reservations.remind');
    Route::delete('/reservations/{id}/delete', [AdminController::class, 'deleteReservation'])->name('admin.reservations.delete');
});