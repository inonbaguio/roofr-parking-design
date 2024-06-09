<?php

namespace Roofr\Booking\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Roofr\Booking\Http\Resources\BookingResource;
use Roofr\Booking\Models\Booking;

class BookingController extends Controller
{
    public function getBookings(): JsonResource
    {
        return BookingResource::collection(Booking::all());
    }

    public function getBookingById(Booking $booking) : JsonResource
    {
        return new BookingResource($booking);
    }
}
