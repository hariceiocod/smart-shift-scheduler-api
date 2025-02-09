<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'max_hours_per_week' => $this->max_hours_per_week,
            'availability' => $this->availability,
            'assigned_shifts' => $this->assigned_shifts,
            'conflict' => $this->conflict,
            'conflict_messages' => $this->conflict_messages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
