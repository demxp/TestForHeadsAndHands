<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TownWeather;

class Town extends Model
{

    /* Отключение первичного ключа - инкрементного поля */
    public $incrementing = false;

    /* Назначение первичного ключа */

    protected $primaryKey = 'town_id';
    
    protected $fillable = [
        'town_id', 'name'
    ];

    /* Функция добавления города с запросом температуры */

    public static function add($fields)
    {
        $town = new static;
        $town->fill($fields);
        $request_current_temp = TownWeather::getWeather($fields["town_id"]);
        $town->current_temp = $request_current_temp["temp"];
        $town->save();
        return $town;
    }

    /* Функция удаления города */

    public function remove()
    {
        $this->delete();
    }       

    /* Функция обновления температуры - для CRON */

    public function renewTemp()
    {
        $request_current_temp = TownWeather::getWeather($this->town_id);
        $this->current_temp = $request_current_temp["temp"];
        $this->save();
    }
}
