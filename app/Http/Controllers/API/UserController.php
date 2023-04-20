<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\UserIndexResource;
use App\Models\Role;
use App\Helpers\Notifications\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function allUser() {
        $users = User::where('role_id', '<', '2')->get();
        return response(UserIndexResource::collection($users));
    }

    public function employees() {
        $employees = User::where('role_id', '>', '1')->get();

        return response(UserIndexResource::collection($employees));
    }

    public function changeRole(Request $request) {
        $validator = Validator::make($request->all(), [
            'value' => 'required|integer',
            'id' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $user = User::find($request->get('id'));
        if($user != null) {
            $user->update([
                'role_id' => $request->get('value')
            ]);

            // ! ==== Уведомления пользователю при изменении роли ====

            $arrayNotification = [
                'status_id' => 1,
                'description' => 'Сотрудник: ' . auth('api')->user()->userInfo->first_name . " " . auth('api')->user()->userInfo->second_name . " " . auth('api')->user()->userInfo->last_name . " изменил вам уровень доступа: " . $user->role->name,
                'order_id' => null,
                'company_id' => null,
                'user_id' => $request->get('id'),
                'employee_id' => auth('api')->user()->id,
                'initiator' => 'Сотрудник',
            ];

            Helper::create_notification($arrayNotification);

            // ! ==== ====

            return response('Роль успешно изменена');
        }
    }
}
