<?php

namespace Roofr\Parking\DTOs;


use Carbon\Carbon;
use Spatie\LaravelData\Data;

class ReserveParkingData extends Data
{
    public function __construct(
        public string $vehicleType,
        public string $startTime,
        public string $endTime,
        public int $parkingLotId,
    ) {
    }
}
