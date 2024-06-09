<?php

namespace database\seeders;

use Illuminate\Database\Seeder;
use Roofr\Booking\Models\Booking;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::factory()->count(50)->create();
    }
}
