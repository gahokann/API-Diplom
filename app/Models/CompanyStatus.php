<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyStatus extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function company() {
        return $this->hasMany(Company::class);
    }
}
