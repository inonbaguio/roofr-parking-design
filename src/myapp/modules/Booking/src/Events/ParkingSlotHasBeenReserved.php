<?php

namespace Roofr\Booking\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Roofr\Parking\DTOs\ReserveParkingData;
use Roofr\Parking\Models\ParkingLot;

class ParkingSlotHasBeenReserved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ParkingLot $parkingLot, public ReserveParkingData $reserveParkingData)
    { 
    }
}
