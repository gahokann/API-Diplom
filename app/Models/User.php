<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded=[];

    public function role() {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function userInfo() {
        return $this->hasOne(UserInfo::class);
    }

    public function userOrder() {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function employeeOrder() {
        return $this->hasMany(Order::class, 'employee_id', 'id');
    }

    public function company() {
        return $this->hasMany(Company::class);
    }
}
