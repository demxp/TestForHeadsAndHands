<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libs\TownWeather\OpenWeatherMap;

class TownWeatherProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Libs\TownWeather\Contracts\TownWeather', function ($app) {
            return new OpenWeatherMap();
        });
    }
}
