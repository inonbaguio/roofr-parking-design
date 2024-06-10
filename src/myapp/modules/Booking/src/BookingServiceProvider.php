<?php

namespace Roofr\Booking;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BookingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(BookingEventServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__.'/../routes/api.php');
    }
}
