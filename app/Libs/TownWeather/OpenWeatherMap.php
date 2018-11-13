<?php

namespace App\Libs\TownWeather;
  
use App\Libs\TownWeather\Contracts\TownWeather;
  
class OpenWeatherMap implements TownWeather
{
    public function getWeather($town)
    {
      if(is_array($town)){
      	return $this->requestManyTowns($town);
      }
      return $this->requestOneTown($town);
    }

    public function ApiKey()
    {
    	return env('OPEN_WEATHER_MAP_KEY');
    }

    public function requestOneTown(int $town_id)
    {
    	$link = "http://api.openweathermap.org/data/2.5/weather?id=".$town_id."&units=metric&APPID=".$this->ApiKey()
    	return $this->request($link);
    }

    public function requestManyTowns(array $towns)
    {
    	if(count($towns) > 20){
    		return [
    			"status" => "error",
    			"message" => "Maximum towns per minute is 20";
    		];
    	}

    	$acc = [];

    	foreach($towns as $town){
    		if(!is_null($town)){
    			$acc[] = $this->requestOneTown($town);
    		}
    	}

    	return $acc;
    }

    public function request($link)
    {
		$response = json_decode(file_get_contents($link));
		if($request['cod'] != '200'){
    		return [
    			"status" => "error",
    			"message" => $request['message'];
    		];
		}

		return [
			"id" => $request["id"],
			"temp" => $request["main"]["temp"];
		];
    }

}