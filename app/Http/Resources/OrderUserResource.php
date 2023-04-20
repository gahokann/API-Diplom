<?php

namespace App\Http\Resources;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderUserResource extends JsonResource
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
            'last_deleviryDate' => empty($this->last_deleviryDate) ? null : date("d.m.Y, h:i", strtotime($this->last_deleviryDate)),
            'company_name' => $this->user->company->name,
            'company' => [
                'id' => $this->user->company->id,
                'name' => $this->user->company->name,
                'user_id' => $this->user->id,
                'user_firstName' => $this->user->userInfo->first_name,
                'user_secondName' => $this->user->userInfo->second_name,
                'user_lastName' => $this->user->userInfo->last_name,
                'phone_number' => $this->user->company->phone_number,
                'inn' => $this->user->company->inn,
                'status_id' => $this->user->company->status_id,
                'status_name' => $this->user->company->status->name,
                'link_web' => $this->user->company->link_web,
                'description' => $this->user->company->description,
                'created_at' => $this->user->company->created_at->format('d.m.Y, h:i'),
                'updated_at' => $this->user->company->updated_at->format('d.m.Y, h:i'),
            ],
            'statuses' => OrderStatus::all(),
            'photo' => $this->photo,
            'information' => $this->information,
            'user_id' => $this->user_id,
            'user_firstName' => $this->user->userInfo->first_name,
            'user_secondName' => $this->user->userInfo->second_name,
            'user_lastName' => $this->user->userInfo->last_name,
            'employee_id' => $this->employee_id,
            'employee' => [
                'id' => $this->user_id,
                'firstName' => empty($this->employee->userInfo->first_name) ? null : $this->employee->userInfo->first_name,
                'secondName' => empty($this->employee->userInfo->second_name) ? null : $this->employee->userInfo->second_name,
                'lastName' => empty($this->employee->userInfo->last_name) ? null : $this->employee->userInfo->last_name,
                'role' => empty($this->employee->role->name) ? null : $this->employee->role->name,
                'phone' => empty($this->employee->userInfo->phone_number) ? null : $this->employee->userInfo->phone_number,
                'email' => empty($this->employee->email) ? null : $this->employee->email,
            ],
            'status_id' => $this->status_id,
            'status_name' => $this->status->name,
            'created_at' => date("d.m.Y, h:i", strtotime($this->created_at)),
            'updated_at' => $this->updated_at,
        ];
    }
}
