<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user_firstName' => $this->user->userInfo->first_name,
            'user_secondName' => $this->user->userInfo->second_name,
            'user_lastName' => $this->user->userInfo->last_name,
            'status_id' => $this->status_id,
            'phone_number' => $this->phone_number,
            'inn' => $this->inn,
            'status_name' => $this->status->name,
            'link_web' => $this->link_web,
            'description' => $this->description,
            'created_at' => $this->created_at->format('d.m.Y, h:i'),
            'updated_at' => $this->updated_at->format('d.m.Y, h:i'),
        ];
    }
}
