<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderMessage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'text' => $this->text,
            'user' => new UserMessage($this->user),
            'created_at' => date("d.m.Y, h:i", strtotime($this->created_at)),
            'id' => $this->id,
        ];
    }
}
