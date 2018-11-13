<?php

namespace App\Http\Controllers\ApiV1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;
use Auth;
use App\Api_Token;

class UsersController extends Controller
{
    /**
     * Вывод всех зарегистрированных пользователей.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all()->toArray();
    }

    /**
     * Вывод данных запрошенного пользователя.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id)->toArray();
    }    

    /**
     * Сохранение нового пользователя с валидацией.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|alpha|unique:users',
            'password' => 'required|min:5'
        ]);

        if($validator->fails()) {
            return [
                "status" => "error",
                "message" => "ValidateError",
                "errors" => $validator->messages()->all()
            ];
        }        

        $user = User::add($request->all());

        return [
            "status" => "ok"
        ];
    }

    /**
     * Обновление пользователя с валидацией.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'login' => [
                'required',
                'alpha',
                Rule::unique('users')->ignore($user->id),
            ]
        ]);

        if($validator->fails()) {
            return [
                "status" => "error",
                "message" => "ValidateError",
                "errors" => $validator->messages()->all()
            ];
        }           

        $user->edit($request->all());

        return [
            "status" => "ok"
        ];
    }

    /**
     * Удаление пользователя.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->remove();
        return [
            "status" => "ok"
        ];
    }

    /* Авторизация и генерация токена */
    
    public function AuthUser(Request $request)
    {
        if(Auth::attempt([
            'login' => $request->get('login'),
            'password' => $request->get('password')
        ]))
        {
            $token = Api_Token::RegenerateToken();
            return [
                "token" => $token
            ];
        }
        return [
            "error_auth",
        ];
    }
}