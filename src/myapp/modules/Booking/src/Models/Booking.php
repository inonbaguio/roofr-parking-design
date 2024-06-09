<?php

namespace Roofr\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Roofr\Booking\Database\Factories\BookingFactory;

class Booking extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'booking';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new BookingFactory();
    }
}
