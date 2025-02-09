<?php

namespace App\Http\Resources\Shift;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
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
            'shift_id' => $this->shift_id,
            'date' => Carbon::parse($this->date)->format('Y-m-d'),
            'start_time' => Carbon::parse($this->start_time)->format('H:i'),
            'end_time' => Carbon::parse($this->end_time)->format('H:i'),
            'max_employees' => $this->max_employees,
            'assigned_employees' => $this->assigned_employees,
            'conflict' => $this->conflict,
            'conflict_message' => $this->conflict_message,
        ];
    }
}
