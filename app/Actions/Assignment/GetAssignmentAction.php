<?php

namespace App\Actions\Assignment;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Collection;

class GetAssignmentAction
{
    public function execute(): Collection
    {
        return Assignment::where('employee_id', auth()->id())->with('shift')->get();
    }
}
