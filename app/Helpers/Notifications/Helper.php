<?php

namespace App\Helpers\Notifications;
use App\Models\Notification;

class Helper {
    public static function create_notification($array) {
        $notification = Notification::create([
            'status_id' => $array['status_id'],
            'description' => $array['description'],
            'order_id' => $array['order_id'],
            'company_id' => $array['company_id'],
            'user_id' => $array['user_id'],
            'employee_id' => $array['employee_id'],
            'initiator' => $array['initiator'],
            'is_read' => 0
        ]);

        return $notification;
    }

}
