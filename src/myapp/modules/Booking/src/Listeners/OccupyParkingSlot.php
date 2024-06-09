<?php

namespace Roofr\Booking\Listeners;


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
