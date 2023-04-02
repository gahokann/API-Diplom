<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    public function index() {
        $roles = Role::where('id', '<', 7)->orderBy('id', 'desc')->get();
        return response(RoleResource::collection($roles));
    }
}

