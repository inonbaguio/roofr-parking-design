<?php

namespace Roofr\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Roofr\Booking\Database\Factories\BookingFactory;
use Roofr\Parking\Models\ParkingLot;

class Booking extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'user_id',
        'parking_slot_id',
        'start_time',
        'paid_amount',
        'end_time',
        'status',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new BookingFactory();
    }

    public function parkingLot(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ParkingLot::class);
    }
}
