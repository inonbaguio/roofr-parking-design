<?php

namespace Roofr\Booking\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Roofr\Booking\Models\Booking;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoofrParkingModelsParkingLot>
 */
class BookingFactory extends Factory
{
    public $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'parking_slot_id' => \Roofr\Parking\Models\ParkingLot::factory(),
            'start_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'status' => $this->faker->randomElement(['booked', 'completed', 'cancelled']),
            'paid_amount' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
