<?php

namespace Roofr\Parking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Roofr\Parking\Enums\ParkingAvailability;
use Roofr\Parking\Models\ParkingLot;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoofrParkingModelsParkingLot>
 */
class ParkingLotFactory extends Factory
{
    public $model = ParkingLot::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'location_description' => $this->faker->sentence,
            'zone' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'latitude' => $this->faker->randomFloat(8, -90, 90),
            'longitude' => $this->faker->randomFloat(8, -180, 180),
            'rate_per_hour' => $this->faker->randomFloat(2, 0, 100),
            'status' => $this->faker->randomElement([
                ParkingAvailability::AVAILABLE->value,
                ParkingAvailability::RESERVED->value,
                ParkingAvailability::OCCUPIED->value,
            ]),
        ];
    }
}
