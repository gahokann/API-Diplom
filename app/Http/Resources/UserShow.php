<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->userInfo->first_name,
            'second_name' => $this->userInfo->second_name,
            'last_name' => $this->userInfo->last_name,
            'email' => $this->email,
            'phone' => $this->userInfo->phone_number,
            'photo' => $this->userInfo->photo,
            'role_name' => $this->role->name,
            'company_name' => empty($this->company->name) ? null : $this->company->name,
            'orders' => UserShowOrder::collection($this->userOrder),
        ];
    }
}
