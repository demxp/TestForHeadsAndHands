<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Api_Token extends Model
{
    public function user()
    {
        return $this->hasOne(User::class);
    } 
}
