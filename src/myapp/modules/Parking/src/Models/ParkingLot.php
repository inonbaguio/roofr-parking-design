<?php

namespace Roofr\Parking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Roofr\Parking\Database\Factories\ParkingLotFactory;


class ParkingLot extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'parking_lots';

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
}
