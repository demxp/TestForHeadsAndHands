<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Town;
use Illuminate\Validation\Rule;
use Validator;
use App\Api_Token;

class TownsController extends Controller
{

    /**
     * Вывод всех городов.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Town::all()->toArray();
    }

    /**
     * добавлени нового города, валидация и сохранение новой модели.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'town_id' => 'required|integer|unique:towns',
            'name' => 'required'
        ]);

        if($validator->fails()) {
            return [
                "status" => "error",
                "message" => "ValidateError",
                "errors" => $validator->messages()->all()
            ];
        }        

        $town = Town::add($request->all());

        return [
            "status" => "ok"
        ];
    }

    /**
     * Удаление города.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Town::find($id)->remove();
        return [
            "status" => "ok"
        ];
    }

    /* Вывод температуры во всех городах с проверкой валидности токена, пришедшего в заголовках */

    public function GetAllWeather(Request $request)
    {
        $token = $request->headers->get('token');
        if((is_null($token)) || (!Api_Token::CheckToken($token))){
            return [
                "status" => "error_token"
            ];            
        }

        $acc = [];

        foreach(Town::all() as $town){
            $acc[] = [
                "town" => $town['name'], 
                "current_temp" => $town['current_temp']
            ];
        }

        return $acc;
    }
}
