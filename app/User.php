<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /* Привязка токена к пользователю */

    public function token()
    {
        return $this->hasOne(UserToken::class);
    } 

    /* Функция добавления пользователя с криптованием пароля */

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();
        return $user;
    }

    /* Редактирование пользователя */

    public function edit($fields)
    {
        $this->fill($fields);
        if(!is_null($fields['password'])){
            $this->password = bcrypt($fields['password']);
        }
        $this->save();

    }

    /* Удаление пользователя */

    public function remove()
    {
        $this->delete();
    }       
}
