<?php

namespace Roofr\Booking\Listeners;


use Roofr\Booking\Events\ParkingSlotHasBeenReserved;

class SendParkingConfirmationEmail
{
    /**
     * Handle the event.
     */
    public function handle(ParkingSlotHasBeenReserved $event): void
    {
        logger()->info('Sending parking confirmation email to user');
    }
}
