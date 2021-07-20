<?php

namespace App\Providers;

use App\Services\BookingServiceInterface;
use App\Services\FakeBookingService;
use App\Services\OrderService;
use App\Services\OrderServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OrderServiceInterface::class, function($app){
            return new OrderService();
        });

        $this->app->singleton(BookingServiceInterface::class, function($app){
            return new FakeBookingService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
