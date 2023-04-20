<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends BaseController
{
    public function show() {
        $notifications = Notification::where('user_id', auth('api')->user()->id)->orderBy('created_at', 'desc')->get();


        return response(NotificationResource::collection($notifications));
    }

    public function read(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        Notification::find($request->get('id'))->update([
            'is_read' => 1
        ]);

        return response('Статус установлен');
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        Notification::find($request->get('id'))->delete();

        return response('Уведомление успешно удалено!');
    }
}
