<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderUserResource;
use App\Http\Resources\UserIndexResource;
use App\Models\Order;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    public function orderAll() {
        $orders = Order::all();


        return response(OrderResource::collection($orders));
    }

    public function orderUser() {
        $orders = Order::where('user_id', auth('api')->user()->id)->get();

        return response(OrderResource::collection($orders));
    }

    public function show($id)
    {
        $order = Order::find($id);

        if($order != Null) {
            if(auth('api')->user()->id == $order->user_id) {
                return response(new OrderUserResource($order));
            }
            else {
                return $this->sendError('', 'Error 404!');
            }
        }
        else {
            return $this->sendError(false, 'Error 404!');
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'quantity' => 'required|integer',
            'first_deleviryDate' => 'required|date',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        Order::create([
            'title' => $request->get('title'),
            'quantity' => $request->get('quantity'),
            'first_deleviryDate' => $request->get('first_deleviryDate'),
            'photo' => $request->get('photo'),
            'information' => $request->get('information'),
            'user_id' => auth('api')->user()->id,
            'status_id' => 1
        ]);

        return response('Заказ успешно создан');
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'quantity' => 'required|integer',
            'first_deleviryDate' => 'required|date',
            'photo' => 'string',
            'information' => 'string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order = Order::find($id);

        $order->update([
            'title' => $request->get('title'),
            'quantity' => $request->get('quantity'),
            'first_deleviryDate' => $request->get('first_deleviryDate'),
            'information' => $request->get('information'),
        ]);

        return $this->sendResponse(true, 'Order update success');
    }
}
