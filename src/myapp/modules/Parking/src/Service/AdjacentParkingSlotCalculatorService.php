<?php

namespace Roofr\Parking\Service;

use Roofr\Parking\DTOs\ReserveParkingData;
use Roofr\Parking\Enums\ParkingAvailability;
use Roofr\Parking\Enums\VehicleTypeRequiredSlots;
use Roofr\Parking\Exceptions\CannotAccomodateVehicleTypeException;
use Roofr\Parking\Exceptions\ParkingSlotOccupiedException;
use Roofr\Parking\Models\ParkingLot;

class AdjacentParkingSlotCalculatorService
{
    /**
     * @throws CannotAccomodateVehicleTypeException
     * @throws ParkingSlotOccupiedException
     */
    public function canParkingSpotAccommodate(ReserveParkingData $reserveParkingData) : bool
    {
        $requiredNumberOfParkingSlots = VehicleTypeRequiredSlots::getSlots($reserveParkingData->vehicleType);

        if ($requiredNumberOfParkingSlots === 1) {
            $this->checkSingleSlot($reserveParkingData->parkingLotId);
            return true;
        }

        $slotRanges = $this->defineSlotRanges($reserveParkingData->parkingLotId, $requiredNumberOfParkingSlots);

        foreach ($slotRanges as $range) {
            if ($this->areSlotsFree($range)) {
                return true;
            }
        }

        throw new CannotAccomodateVehicleTypeException();
    }

    /**
     * @throws ParkingSlotOccupiedException
     */
    private function checkSingleSlot(int $parkingLotId): void
    {
        try {
            ParkingLot::where('id', $parkingLotId)
                ->where('status', ParkingAvailability::AVAILABLE->value)
                ->firstOrFail();
        } catch (\Exception $e) {
            throw new ParkingSlotOccupiedException();
        }
    }

    private function defineSlotRanges(int $parkingLotId, int $requiredNumberOfParkingSlots): array
    {
        return [
            [$parkingLotId - $requiredNumberOfParkingSlots + 1, $parkingLotId],
            [$parkingLotId, $parkingLotId + $requiredNumberOfParkingSlots - 1]
        ];
    }

    private function areSlotsFree(array $slotRanges): bool
    {
        for ($i = $slotRanges[0]; $i <= $slotRanges[1]; $i++) {
            if (!$this->isSlotFree($i)) {
                return false;
            }
        }

        return true;
    }

    private function isSlotFree(int $slotId): bool
    {
        $slot = ParkingLot::findOrFail($slotId);

        return $slot && $slot->status === ParkingAvailability::AVAILABLE->value;
    }
}
