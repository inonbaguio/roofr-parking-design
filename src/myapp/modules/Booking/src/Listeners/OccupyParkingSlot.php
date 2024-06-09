<?php

namespace Roofr\Booking\src\Listeners;


use Roofr\Booking\Events\ParkingSlotHasBeenReserved;

class OccupyParkingSlot
{
    /**
     * Handle the event.
     */
    public function handle(ParkingSlotHasBeenReserved $event): void
    {
        $event->parkingLot->occupy();
    }
}
