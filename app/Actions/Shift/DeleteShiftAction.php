<?php

namespace App\Actions\Shift;

use App\Models\Shift;
use Exception;

class DeleteShiftAction
{
    public function execute(string $id): void
    {
        $shift = Shift::find($id);

        if (! $shift) {
            throw new Exception('Shift not found');
        }

        $shift->delete();

    }
}
