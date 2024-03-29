<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserIndexResource extends JsonResource
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
            'company' => $this->company,
            'photo' => $this->userInfo->photo,
            'company_name' => empty($this->company->name) ? null : $this->company->name,
            'company_status' => empty($this->company->status->id) ? null : $this->company->status->id,
            'second_name' => $this->userInfo->second_name,
            'last_name' => $this->userInfo->last_name,
            'date_birth' => $this->userInfo->date_birth,
            // 'order' => OrderResource::collection($this->whenLoaded('userOrder')),
        ];
    }
}

// Order::find($this->userOrder)
