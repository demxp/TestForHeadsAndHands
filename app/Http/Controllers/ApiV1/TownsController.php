<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Town;
use Illuminate\Validation\Rule;
use Validator;

class TownsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Town::all()->toArray();
    }

    /**
     * Store a newly created resource in storage.
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
     * Remove the specified resource from storage.
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
}
