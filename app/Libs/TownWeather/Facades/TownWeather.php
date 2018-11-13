<?php

namespace App\Libs\TownWeather\Facades;

use Illuminate\Support\Facades\Facade;

class TownWeather extends Facade {
    protected static function getFacadeAccessor() {
    	return 'App\Libs\TownWeather\Contracts\TownWeather'; 
    }
}