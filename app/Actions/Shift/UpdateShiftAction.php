<?php

namespace App\Actions\Shift;

use App\Models\Shift;
use Exception;

class UpdateShiftAction
{
    public function execute(string $id, string $date, string $startTime, string $endTime, int $maxEmployees): ?Shift
    {
        $shift = Shift::find($id);

        if (! $shift) {
            throw new Exception('Shift not found');
        }

        $shift->update([
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'max_employees' => $maxEmployees,
        ]);

        return $shift->refresh();
    }
}
