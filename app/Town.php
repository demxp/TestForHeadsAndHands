<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Providers\TownWeatherProvider;

class Town extends Model
{
    protected $fillable = [
        'town_id', 'name', 'current_temp'
    ];

    public static function add($fields)
    {
        $town = new static;
        $town->fill($fields);
        $request_current_temp = TownWeatherProvider::getWeather($fields["town_id"]);
        $town->current_temp = $request_current_temp["temp"];
        $town->save();
        return $town;
    }

    public function remove()
    {
        $this->delete();
    }       
}
