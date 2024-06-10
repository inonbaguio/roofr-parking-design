<?php

namespace Roofr\Parking\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Roofr\Booking\Events\ParkingSlotHasBeenReserved;
use Roofr\Booking\Exceptions\OverlapsWithAnotherBookingException;
use Roofr\Booking\Service\BookingTimeCalculatorService;
use Roofr\Parking\DTOs\ReserveParkingData;
use Roofr\Parking\Exceptions\CannotAccomodateVehicleTypeException;
use Roofr\Parking\Models\ParkingLot;
use Roofr\Parking\Service\AdjacentParkingSlotCalculatorService;

class ReserveParkingLot
{
    public function __construct(
        public AdjacentParkingSlotCalculatorService $adjacentParkingSlotCalculatorService,
        public BookingTimeCalculatorService $bookingTimeCalculatorService,
        protected DatabaseManager $databaseManager,
        protected Dispatcher $events
    ) {}

    public function handle(ReserveParkingData $reserveParkingData) : ParkingLot
    {
        /**
         * @throws CannotAccomodateVehicleTypeException
         *
         * Custom exception if the adjacent parking slot cannot accomodate the vehicle type
         *
         * Van requires 3 adjacent parking slots
         * Motor/Car requires only 1 parking slot
         */
        $this->adjacentParkingSlotCalculatorService->canParkingSpotAccommodate($reserveParkingData);

        /**
         * @throws OverlapsWithAnotherBookingException
         *
         * Custom exception if the parking lot is already booked for the requested time
         */
        $this->bookingTimeCalculatorService->canAccomodateRequestedParkingTime($reserveParkingData);

        $parkingLot = ParkingLot::findOrFail($reserveParkingData->parkingLotId);

        $this->databaseManager->transaction(function () use ($parkingLot, $reserveParkingData) {
            $this->events->dispatch(
                new ParkingSlotHasBeenReserved(
                    $parkingLot,
                    $reserveParkingData
                )
            );
        });

        return $parkingLot->fresh();
    }
}
