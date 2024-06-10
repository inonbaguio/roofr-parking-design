<?php

namespace Roofr\Parking;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ParkingServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__.'/../routes/api.php');
    }
}
