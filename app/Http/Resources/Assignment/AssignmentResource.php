<?php

namespace App\Http\Resources\Assignment;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'shift_id' => $this->shift_id,
            'start' => Carbon::parse($this->shift->date.' '.$this->shift->start_time)->format('Y-m-d H:i'),
            'end' => Carbon::parse($this->shift->date.' '.$this->shift->end_time)->format('Y-m-d H:i'),
            'employee_id' => $this->employee_id,
        ];
    }
}
