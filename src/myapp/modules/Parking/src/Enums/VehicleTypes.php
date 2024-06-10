<?php

namespace Roofr\Parking\Enums;

enum VehicleTypes: string
{
    case Motorcycle = 'motorcycle';
    case Car = 'car';
    case Van = 'van';

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
