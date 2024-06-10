<?php

namespace Roofr\Booking\Listeners;


use Roofr\Booking\Events\ParkingSlotHasBeenReserved;

class ReserveParkingSlot
{
    /**
     * Handle the event.
     */
    public function handle(ParkingSlotHasBeenReserved $event): void
    {
        $event->parkingLot->reserve();
    }
}
