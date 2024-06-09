<?php

namespace Roofr\Booking\Http\Controllers;

use Illuminate\Routing\Controller;
use Roofr\Booking\Http\Resources\BookingResource;
use Roofr\Booking\Models\Booking;
use Roofr\Parking\Http\Resources\ParkingLotResource;
use Roofr\Parking\Models\ParkingLot;

class BookingController extends Controller
{
    public function getBookings()
    {
        return BookingResource::collection(Booking::all());
    }

    public function getBookingById(Booking $booking)
    {
        return new BookingResource($booking);
    }
}
