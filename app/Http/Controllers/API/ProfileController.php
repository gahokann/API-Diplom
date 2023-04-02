<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserIndexResource;
use App\Models\Order;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends BaseController
{
    public function index() {
        $user = User::find(auth('api')->user()->id);
        // $user->loadMissing(['userOrder']);
        return $this->sendResponse(new UserIndexResource($user), 'User profile');
    }



    public function changeFIO(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'second_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = UserInfo::where('user_id', auth('api')->user()->id);

        $user->update([
            'first_name' => $request->get('first_name'),
            'second_name' => $request->get('second_name'),
            'last_name' => $request->get('last_name'),
        ]);

        return response('ФИО успешно изменено');
    }

    public function changeEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'email' => 'required|string|unique:users',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        if(!Hash::check($request->get('password'), auth('api')->user()->password)){ // Проверка пароля
            return $this->sendError('Ошибка! Старый пароль неверен!', '');
        }

        $user = User::find(auth('api')->user()->id);

        $user->update([
            'email' => $request->get('email'),
        ]);

        return response('Адрес электронной почты успешно изменён');
    }

    public function changePhone(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'phone_number' => 'required|string|max:12',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if(!Hash::check($request->get('password'), auth('api')->user()->password)){ // Проверка пароля
            return $this->sendError('Ошибка! Старый пароль неверен!', '');
        }

        $user = UserInfo::where('user_id', auth('api')->user()->id);

        $user->update([
            'phone_number' => $request->get('phone_number'),
        ]);


        return response('Номер телефона успешно изменён');
    }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'c_password' => 'required|same:new_password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if(!Hash::check($request->get('old_password'), auth('api')->user()->password)){ // Проверка пароля
            return $this->sendError('Ошибка! Старый пароль неверен!', '');
        }

        $user = User::find(auth('api')->user()->id);

        $user->update([
            'password' => Hash::make($request->get('new_password')),
        ]);


        return response('Пароль успешно изменен');
    }

}
