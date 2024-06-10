<?php

namespace Roofr\Parking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Roofr\Booking\Models\Booking;
use Roofr\Parking\Database\Factories\ParkingLotFactory;
use Roofr\Parking\Enums\ParkingAvailability;

class ParkingLot extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'parking_lots';

    protected $primaryKey = 'id';

    protected $fillable = [
        'location_description',
        'zone',
        'rate_per_hour',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new ParkingLotFactory();
    }

    public function occupy()
    {
        $this->status = ParkingAvailability::OCCUPIED->value;
        $this->save();
    }

    public function reserve()
    {
        $this->status = ParkingAvailability::RESERVED->value;
        $this->save();
    }

    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Booking::class, 'parking_slot_id',   'id');
    }

    public function createBooking(array $bookingData)
    {
        $this->bookings()->create($bookingData);
    }
}
