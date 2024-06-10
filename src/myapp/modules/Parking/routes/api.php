<?php


use Illuminate\Support\Facades\Route;
use Roofr\Parking\Http\Controllers\ParkingController;

Route::prefix('/parking-lot')->group(function () {
    Route::get('/', [ParkingController::class, 'getParkingLots']);
    Route::get('/{parkingLot}', [ParkingController::class, 'getParkingLotById']);
    Route::post('/reserve', [ParkingController::class, 'reserveParkingLot']);
});

