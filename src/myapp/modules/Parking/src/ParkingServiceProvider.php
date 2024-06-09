<?php

namespace Roofr\Parking;

use Illuminate\Support\ServiceProvider;

class ParkingServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
