<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Roofr\Parking\Models\ParkingLot;

class ParkingLotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ParkingLot::factory()->count(50)->create();
    }
}
