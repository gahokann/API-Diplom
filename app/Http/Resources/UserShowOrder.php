<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShowOrder extends JsonResource
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
            'title' => $this->title,
            'quantity' => $this->quantity,
            'employee_id' => $this->employee_id,
            'employee_firstName' => empty($this->employee->userInfo->first_name) ? null : $this->employee->userInfo->first_name,
            'employee_secondName' => empty($this->employee->userInfo->second_name) ? null : $this->employee->userInfo->second_name,
            'employee_lastName' => empty($this->employee->userInfo->last_name) ? null : $this->employee->userInfo->last_name,
            'user_firstName' => empty($this->user->userInfo->first_name) ? null : $this->user->userInfo->first_name,
            'user_secondName' => empty($this->user->userInfo->second_name) ? null : $this->user->userInfo->second_name,
            'user_lastName' => empty($this->user->userInfo->last_name) ? null : $this->user->userInfo->last_name,
            'status_name' => $this->status->name,
            'created_at' => date("d.m.Y, h:i", strtotime($this->created_at)),
        ];
    }
}
