<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'first_deleviryDate' => date("d.m.Y, h:i", strtotime($this->first_deleviryDate)),
            'last_deleviryDate' => empty($this->last_deleviryDate) ? null : date("d.m.Y", strtotime($this->last_deleviryDate)),
            'company' => $this->user->company,
            'company_name' => empty($this->company->name) ? null : $this->company->name,
            'photo' => $this->photo,
            'information' => $this->information,
            'user_id' => $this->user_id,
            'user_firstName' => $this->user->userInfo->first_name,
            'user_secondName' => $this->user->userInfo->second_name,
            'user_lastName' => $this->user->userInfo->last_name,
            'employee_id' => $this->employee_id,
            'employee_firstName' => empty($this->employee->userInfo->first_name) ? null : $this->employee->userInfo->first_name,
            'employee_secondName' => empty($this->employee->userInfo->second_name) ? null : $this->employee->userInfo->second_name,
            'employee_lastName' => empty($this->employee->userInfo->last_name) ? null : $this->employee->userInfo->last_name,
            'status_id' => $this->status_id,
            'status_name' => $this->status->name,
            'created_at' => date("d.m.Y, h:i", strtotime($this->created_at)),
            'updated_at' => $this->updated_at,
        ];
    }
}
