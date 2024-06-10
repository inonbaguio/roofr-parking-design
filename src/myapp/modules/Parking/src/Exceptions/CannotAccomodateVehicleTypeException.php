<?php

namespace Roofr\Parking\Exceptions;

class CannotAccomodateVehicleTypeException extends \Exception
{
    public function __construct(
        $message = 'Adjacent parking slots are not available for the vehicle type. Please try again.',
        $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
