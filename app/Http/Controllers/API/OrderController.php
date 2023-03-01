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

class OrderController extends BaseController
{
    public function index() {
        $user = User::find(auth('api')->user()->id);

        return $this->sendResponse(OrderResource::collection($user->userOrder), 'All Order User`s');
    }

    public function show($id)
    {
        $order = Order::find($id);

        if($order != Null) {
            if(auth('api')->user()->id == $order->user_id) {
                return $this->sendResponse(new OrderResource($order), 'Order User`s');
            }
            else {
                return $this->sendResponse('', 'Error 404!');
            }
        }
        else {
            return $this->sendResponse(false, 'Error 404!');
        }
    }
}
