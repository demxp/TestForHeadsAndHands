<?php

namespace App\Libs\TownWeather\Contracts;
  
Interface TownWeather
{
    public function getWeather($town);
}