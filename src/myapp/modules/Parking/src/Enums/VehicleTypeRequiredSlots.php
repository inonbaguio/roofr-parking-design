<?php

namespace Roofr\Parking\Enums;

enum VehicleTypeRequiredSlots: int
{
    case Motorcycle = 1;
    case Van = 3;

    public static function getSlots(string $vehicleType): int
    {
        return match(strtolower(trim($vehicleType))) {
            'motorcycle', 'car' => self::Motorcycle->value,
            'van' => self::Van->value,
            default => throw new \InvalidArgumentException("Invalid vehicle type: $vehicleType"),
        };
    }
}
