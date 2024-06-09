<?php

namespace Roofr\Booking\Listeners;

use Illuminate\Support\Carbon;
use Roofr\Booking\Enums\BookingStatus;
use Roofr\Booking\Events\ParkingSlotHasBeenReserved;

class CreateBookingForParking
{
    /**
     * Handle the event.
     */
    public function handle(ParkingSlotHasBeenReserved $event): void
    {
        $event->parkingLot->createBooking([
            'parking_slot_id' => $event->parkingLot->id,
            'user_id' => 5,
            'paid_amount' => $this->calculateAmount($event->reserveParkingData->startTime, $event->reserveParkingData->endTime, $event->parkingLot->rate_per_hour),
            'start_time' => $event->reserveParkingData->startTime,
            'end_time' => $event->reserveParkingData->endTime,
            'status' => BookingStatus::BOOKED->value,
        ]);
    }

    private function calculateAmount(string $startTime, string $endTime, float $ratePerHour) :float
    {
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse($endTime);

        $hours = $startTime->diffInHours($endTime);

        return $hours * $ratePerHour;
    }
}
