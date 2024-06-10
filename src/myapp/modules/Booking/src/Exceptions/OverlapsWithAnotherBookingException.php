<?php

namespace Roofr\Booking\Exceptions;

use Exception;

class OverlapsWithAnotherBookingException extends Exception
{
    public function __construct(
        $message = 'The requested time overlaps with an existing booking.',
        $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
