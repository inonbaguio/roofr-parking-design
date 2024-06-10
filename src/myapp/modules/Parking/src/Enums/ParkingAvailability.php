<?php

namespace Roofr\Parking\Enums;

enum ParkingAvailability: string
{
    case AVAILABLE = 'available';

    case RESERVED = 'reserved';

    case OCCUPIED = 'occupied';
}
