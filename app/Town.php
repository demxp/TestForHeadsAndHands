<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $fillable = [
        'town_id', 'name', 'current_temp'
    ];

    public static function add($fields)
    {
        $town = new static;
        $town->fill($fields);
        $town->current_temp = 0;
        $town->save();
        return $town;
    }

    public function remove()
    {
        $this->delete();
    }       
}
