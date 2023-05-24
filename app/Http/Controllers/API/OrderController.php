<?php

namespace App\Http\Controllers\API;

use App\Helpers\Notifications\Helper;
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
        $orders = Order::where('user_id', auth()->user()->id)->get();

        return response(OrderResource::collection($orders));
    }

    public function orderEmployee() {
        $orders = Order::where('employee_id', auth('api')->user()->id)->get();

        return response(OrderResource::collection($orders));
    }


    public function show($id)
    {
        $order = Order::find($id);

        if($order != Null) {
            if(auth('api')->user()->id == $order->user_id || auth('api')->user()->id == $order->employee_id || auth('api')->user()->role_id > 1) {

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
            'file' => '',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $imageName = time() . '.' . $request->file->extension();

        $path = 'orders';

        $request->file->storeAs('public/' . $path, $imageName);

        $photo = 'storage'. '/' . $path . '/' . $imageName;



        $order = Order::create([
            'title' => $request->get('title'),
            'quantity' => $request->get('quantity'),
            'first_deleviryDate' => $request->get('first_deleviryDate'),
            'photo' => $photo,
            'information' => $request->get('information'),
            'user_id' => auth('api')->user()->id,
            'status_id' => 1
        ]);

        // ! ==== Уведомления для всех сотрудников при создании заказа ====

        $users = User::where('role_id', '>', 1)->get();

        foreach ($users as  $user) {
            Helper::create_notification([
                'status_id' => 8,
                'description' => 'Пользователь: ' . $order->user->userInfo->first_name . " " . $order->user->userInfo->second_name . " " . $order->user->userInfo->last_name . ' сделал заказ',
                'order_id' => $order->id,
                'company_id' => null,
                'user_id' => $user->id,
                'employee_id' => null,
                'initiator' => 'Пользователь',
            ]);
        }

        // ! ==== ====

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

    public function orderWork(Request $request) {
        $validator = Validator::make($request->all(), [
            'orderID' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order = Order::find($request->get('orderID'));

        if($order != null && auth('api')->user()->role_id > 1 && $order->employee_id != auth('api')->user()->id && $order->employee_id == null) {
            $order->update([
                'employee_id' => auth('api')->user()->id,
            ]);

            // ! ==== Уведомления пользователю при взятии заказа сотрудником ====

            $arrayNotification = [
                'status_id' => 3,
                'description' => 'Сотрудник: ' . auth('api')->user()->userInfo->first_name . " " . auth('api')->user()->userInfo->second_name . " " . auth('api')->user()->userInfo->last_name . " взял ваш заказ №" . $order->id . " в работу.",
                'order_id' => $order->id,
                'company_id' => null,
                'user_id' => $order->user_id,
                'employee_id' => auth('api')->user()->id,
                'initiator' => 'Сотрудник',
            ];

            Helper::create_notification($arrayNotification);

            // ! ==== ====

            return response('Заказ успешно взят в работу');
        }
        else
            return $this->sendError('Ошибка при совершении операции!');
    }

    public function removeEmployeeOrder(Request $request) {
        $validator = Validator::make($request->all(), [
            'orderID' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order = Order::find($request->get('orderID'));

        if($order != null && auth('api')->user()->role_id > 3 && $order->employee_id != null) {
            $order->update([
                'employee_id' => null,
            ]);

            $arrayNotification = [
                'status_id' => 4,
                'description' => 'Руководитель: ' . auth('api')->user()->userInfo->first_name . " " . auth('api')->user()->userInfo->second_name . " " . auth('api')->user()->userInfo->last_name . " с вашего заказа №" . $order->id . ' снял сотрудника.',
                'order_id' => $order->id,
                'company_id' => null,
                'user_id' => $order->user_id,
                'employee_id' => auth('api')->user()->id,
                'initiator' => 'Сотрудник',
            ];

            Helper::create_notification($arrayNotification);

            // ! ==== ====

            return response('Сотрудник успешно снят с заказа!');
        }
        else
            return $this->sendError('Ошибка при совершении операции!');
    }

    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(), [
            'orderID' => 'required|integer',
            'status' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order = Order::find($request->get('orderID'));


        if($order != null) {
            $order->update([
                'status_id' => $request->get('status')
            ]);

            $arrayNotification = [
                'status_id' => 5,
                'description' => 'Сотрудник: ' . auth('api')->user()->userInfo->first_name . " " . auth('api')->user()->userInfo->second_name . " " . auth('api')->user()->userInfo->last_name . " изменил статус вашего заказа №" . $order->id . ": " .  $order->status->name,
                'order_id' => $order->id,
                'company_id' => null,
                'user_id' => $order->user_id,
                'employee_id' => auth('api')->user()->id,
                'initiator' => 'Сотрудник',
            ];

            Helper::create_notification($arrayNotification);

            return response('Статус успешно изменён');
        }
        else
            return $this->sendError('Ошибка при совершении операции!');



    }

}
