<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function employee() {
        return $this->hasOne(User::class, 'id', 'employee_id');
    }

    public function status() {
        return $this->hasOne(OrderStatus::class, 'id', 'status_id');
    }
}
