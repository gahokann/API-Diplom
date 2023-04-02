<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\UserIndexResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function allUser() {
        $users = User::where('role_id', '<', '2')->get();
        return response(UserIndexResource::collection($users));
    }

    public function employees() {
        $employees = User::where('role_id', '>', '2')->get();

        return response(UserIndexResource::collection($employees));
    }
}
