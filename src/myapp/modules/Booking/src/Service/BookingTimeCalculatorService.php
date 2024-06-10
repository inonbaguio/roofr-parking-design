<?php

namespace Roofr\Booking\Service;

use Roofr\Booking\Exceptions\OverlapsWithAnotherBookingException;
use Roofr\Booking\Models\Booking;
use Roofr\Parking\DTOs\ReserveParkingData;

class BookingTimeCalculatorService
{
    public function canAccomodateRequestedParkingTime(ReserveParkingData $reserveParkingData): bool
    {
        $overlappingBookings = Booking::where('parking_slot_id', $reserveParkingData->parkingLotId)
            ->where(
                function ($query) use ($reserveParkingData) {
                    $query->whereBetween('start_time', [$reserveParkingData->startTime, $reserveParkingData->endTime])
                        ->orWhereBetween('end_time', [$reserveParkingData->startTime, $reserveParkingData->endTime]);
                }
            )
            ->exists();

        if ($overlappingBookings) {
            throw new OverlapsWithAnotherBookingException();
        }

        return true;
    }
}
