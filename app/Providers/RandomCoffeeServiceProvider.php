<?php

namespace App\Providers;

use App\Contracts\RandomCoffee as RandomCoffeeContract;
use App\Services\TelegramRandomCoffee;
use Illuminate\Support\ServiceProvider;

class RandomCoffeeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RandomCoffeeContract::class, function () {
            return new TelegramRandomCoffee();
        });
    }
}
