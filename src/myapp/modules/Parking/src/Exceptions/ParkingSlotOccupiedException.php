<?php

namespace Roofr\Parking\Exceptions;

class ParkingSlotOccupiedException extends \Exception
{
    public function __construct(
        $message = 'Parking slot is already occupied.',
        $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
