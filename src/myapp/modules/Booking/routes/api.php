<?php


use Illuminate\Support\Facades\Route;
use Roofr\Booking\Http\Controllers\BookingController;

Route::prefix('/booking')->group(
    function () {
        Route::get('/', [BookingController::class, 'getBookings']);
        Route::get('/{booking}', [BookingController::class, 'getBookingById']);
        Route::post('/', [BookingController::class, 'storeBooking']);
        Route::put('/{booking}', [BookingController::class, 'updateBooking']);
        Route::delete('/{booking}', [BookingController::class, 'deleteBooking']);
    }
);
