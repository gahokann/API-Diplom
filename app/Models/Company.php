<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function status() {
        return $this->hasOne(CompanyStatus::class, 'id', 'status_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
