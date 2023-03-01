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
            'first_deleviryDate' => $this->first_deleviryDate,
            'last_deleviryDate' => $this->last_deleviryDate,
            'photo' => $this->photo,
            'information' => $this->information,
            'user_id' => $this->user_id,
            'employee_id' => $this->employee_id,
            'status_id' => $this->status_id,
            'status_name' => $this->status->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
