<?php

namespace Roofr\Parking\Tests\Api;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Roofr\Booking\Enums\BookingStatus;
use Roofr\Parking\Enums\ParkingAvailability;
use Roofr\Parking\Enums\VehicleTypes;
use Roofr\Parking\Models\ParkingLot;
use Tests\TestCase;

class ParkingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
    }

    public function test_an_available_parking_spot_should_be_able_to_be_reserved_with_motorcycle()
    {
        $parkingLot = ParkingLot::factory()->available()->create();

        $response = $this->postJson('/api/parking-lot/reserve', [
            'vehicleType' => VehicleTypes::Motorcycle->value,
            'parkingLotId' => $parkingLot->id,
            'startTime' => now()->addHour()->toDateTimeString(),
            'endTime' => now()->addHours(2)->toDateTimeString(),
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'rate_per_hour', 'status']);
        $response->assertJsonPath('status', ParkingAvailability::RESERVED->value);

        $parkingLot = ParkingLot::find($response->json('id'));
        $this->assertEquals(ParkingAvailability::RESERVED->value, $parkingLot->status);
        $this->assertEquals($parkingLot->bookings->first()->status, BookingStatus::BOOKED->value);

        $response = $this->postJson('/api/parking-lot/reserve', [
            'vehicleType' => VehicleTypes::Motorcycle->value,
            'parkingLotId' => $parkingLot->id,
            'startTime' => now()->addHour()->toDateTimeString(),
            'endTime' => now()->addHours(2)->toDateTimeString(),
        ]);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Parking slot is already occupied.');
    }

    public function test_an_available_parking_spot_should_be_able_to_be_reserved_with_car()
    {
        $parkingLot = ParkingLot::factory()->available()->create();

        $response = $this->postJson('/api/parking-lot/reserve', [
            'vehicleType' => VehicleTypes::Car->value,
            'parkingLotId' => $parkingLot->id,
            'startTime' => now()->addHour()->toDateTimeString(),
            'endTime' => now()->addHours(2)->toDateTimeString(),
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'rate_per_hour', 'status']);
        $response->assertJsonPath('status', ParkingAvailability::RESERVED->value);

        $parkingLot = ParkingLot::find($response->json('id'));
        $this->assertEquals(ParkingAvailability::RESERVED->value, $parkingLot->status);
        $this->assertEquals($parkingLot->bookings->first()->status, BookingStatus::BOOKED->value);
    }

    public function test_an_available_parking_spot_should_be_able_to_be_reserved_with_van()
    {
        $parkingLot = ParkingLot::factory()->available()->count(10)->create();

        $response = $this->postJson('/api/parking-lot/reserve', [
            'vehicleType' => VehicleTypes::Van->value,
            'parkingLotId' => 5,
            'startTime' => now()->addHour()->toDateTimeString(),
            'endTime' => now()->addHours(2)->toDateTimeString(),
        ]);

        $response->assertStatus(201);
    }

    public function test_unavailable_adjacent_parking_spot_should_result_into_failure_into_booking()
    {
        ParkingLot::factory()->available()->count(10)->create();

        ParkingLot::whereIn('id', [4, 6])
            ->update(['status' => ParkingAvailability::OCCUPIED->value]);

        $response = $this->postJson('/api/parking-lot/reserve', [
            'vehicleType' => VehicleTypes::Van->value,
            'parkingLotId' => 5,
            'startTime' => now()->addHour()->toDateTimeString(),
            'endTime' => now()->addHours(2)->toDateTimeString(),
        ]);

        $response->assertStatus(500);
        $response->assertJsonPath('message', 'Adjacent parking slots are not available for the vehicle type. Please try again.');

        ParkingLot::whereIn('id', [4])
            ->update(['status' => ParkingAvailability::AVAILABLE->value]);

        $response = $this->postJson('/api/parking-lot/reserve', [
            'vehicleType' => VehicleTypes::Van->value,
            'parkingLotId' => 5,
            'startTime' => now()->addHour()->toDateTimeString(),
            'endTime' => now()->addHours(2)->toDateTimeString(),
        ]);

        $response->assertStatus(201);
    }
}
