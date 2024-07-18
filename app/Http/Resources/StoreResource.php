<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
          return [
            'id' => (string)$this->id,
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'phone_number' => $this->phone_number,
            'user' => $this->user
        ];
    }
}
