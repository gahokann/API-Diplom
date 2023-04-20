<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function employee() {
        return $this->hasOne(User::class, 'id', 'employee_id');
    }

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function status() {
        return $this->hasOne(NotificationStatus::class, 'id', 'status_id');
    }

    public function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
