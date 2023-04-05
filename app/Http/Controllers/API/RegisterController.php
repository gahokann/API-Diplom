<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|unique:user_infos',
            'first_name' => 'required|string',
            'second_name' => 'required|string',
            'last_name' => 'required|string',
            'date' => 'required|date',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ],
        [
            'email.unique' => 'Данный адрес электронной почты уже существует',
            'phone_number.unique' => 'Данный номер телефона уже существует',
        ]
        );

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create([
            'email' => $input['email'],
            'password' => $input['password'],
            'role_id' => 1,
        ]);

        UserInfo::create([
            'user_id' => $user->id,
            'first_name' => $input['first_name'],
            'second_name' => $input['second_name'],
            'last_name' => $input['last_name'],
            'date_birth' => $input['date'],
            'phone_number' => $input['phone_number']
        ]);


        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['number__column'] = $user->role_id;


        return response($success);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['number__column'] = $user->role_id;

            return response($success);
        }
        else{
            return $this->sendError('Ошибка! Почта или пароль неверны!', ['error' => 'Ошибка!']);
        }
    }
}

