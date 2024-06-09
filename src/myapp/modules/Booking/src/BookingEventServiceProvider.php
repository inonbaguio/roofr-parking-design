<?php

namespace Roofr\Booking;

use App\Providers\EventServiceProvider;
use Roofr\Booking\Events\ParkingSlotHasBeenReserved;
use Roofr\Booking\Listeners\CreateBookingForParking;
use Roofr\Booking\Listeners\OccupyParkingSlot;

class BookingEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        ParkingSlotHasBeenReserved::class=> [
            OccupyParkingSlot::class,
            CreateBookingForParking::class
        ],
    ];
}
