<?php

namespace App\Libs\TownWeather;
  
use App\Libs\TownWeather\Contracts\TownWeather;
  
class OpenWeatherMap implements TownWeather
{

    /* Точка входа - основная функция класса. Принимает массив или число */

    public function getWeather($town)
    {
      if(is_array($town)){
      	return $this->requestManyTowns($town);
      }
      return $this->requestOneTown($town);
    }

    /* Получение ключа API сервиса - используется файл .env */

    public function ApiKey()
    {
    	return env('OPEN_WEATHER_MAP_KEY');
    }

    /* Формирователь API ссылки и запрос погоды в одном городе */

    public function requestOneTown(int $town_id)
    {
    	$link = "http://api.openweathermap.org/data/2.5/weather?id=".$town_id."&units=metric&APPID=".$this->ApiKey();
    	return $this->request($link);
    }

    /* Циклический запрос при необходимости получения погоды в нескольких городах */
    /* Ограничение длины входного массива городов - 20 элементов */

    public function requestManyTowns(array $towns)
    {
    	if(count($towns) > 20){
    		return [
    			"status" => "error",
    			"message" => "Maximum towns per minute is 20"
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

    /* Непосредственный запрос к сервису и парсинг ответа */

    public function request($link)
    {
		$response = json_decode(file_get_contents($link));
		if($response->cod != '200'){
    		return [
    			"status" => "error",
    			"message" => $response->message
    		];
		}

		return [
			"id" => $response->id,
			"temp" => $response->main->temp
		];
    }

}