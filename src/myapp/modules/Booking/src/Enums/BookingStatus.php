<?php

namespace Roofr\Booking\Enums;

enum BookingStatus: string
{
    case BOOKED = 'booked';

    case COMPLETED = 'completed';

    case CANCELLED = 'cancelled';
}
