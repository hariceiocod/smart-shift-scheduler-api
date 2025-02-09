<?php

namespace App\Actions\Shift;

use App\Models\Shift;

class CreateShiftAction
{
    public function execute(string $date, string $startTime, string $endTime, int $maxEmployees): Shift
    {
        return Shift::create([
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'max_employees' => $maxEmployees,
        ]);
    }
}
