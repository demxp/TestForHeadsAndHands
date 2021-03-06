<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Api_Token extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'token', 'expire'
    ];

    /* Отключение полей времени обновления и создания в таблице*/

    public $timestamps = false;

    /* Назначение имени таблицы для модели */

	protected $table = 'api_tokens';

    /* Привязка модели пользователя */

    public function user()
    {
        return $this->hasOne(User::class);
    } 

    /* Функция обновления токена */

    public static function RegenerateToken()
    {
        $random_token = md5(uniqid(mt_rand(), true));
        self::updateOrCreate(
            [
                'user_id' => \Auth::user()->id,
            ],
            [
                'token' => $random_token,
                'expire' => date("Y-m-d H:i:s", time()+3600)
            ]
        );

        return $random_token;                	
    }

    /* Функция проверки токена с проверкой актуальности */

    public static function CheckToken($token)
    {
    	$user = self::where('token', $token)->where('expire','>',date("Y-m-d H:i:s"))->count();
        if($user != 0){
        	return true;
        }
        return false;
    }
}
