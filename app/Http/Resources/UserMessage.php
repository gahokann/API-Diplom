<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMessage extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->userInfo->phone_number,
            'role_name' => $this->role->name,
            'role_id' => $this->role->id,
            'role_info' => $this->role->info,
            'first_name' => $this->userInfo->first_name,
            'photo' => $this->userInfo->photo,
            'second_name' => $this->userInfo->second_name,
            'last_name' => $this->userInfo->last_name,
            'date_birth' => $this->userInfo->date_birth,
        ];
    }
}
