<?php

namespace App\Actions\Assignment;

use App\Models\Assignment;
use App\Models\Shift;
use App\Models\User;
use Exception;

class UpdateAssignmentAction
{
    public function execute(string $shiftId, array $employeeIds)
    {
        $shift = Shift::find($shiftId);
        if (! $shift) {
            throw new Exception('Shift not found');
        }

        // Get current assignments for the shift
        $currentAssignments = Assignment::where('shift_id', $shiftId)->pluck('employee_id')->toArray();

        // Employees to be assigned
        $toAssign = array_diff($employeeIds, $currentAssignments);

        // Employees to be unassigned
        $toUnassign = array_diff($currentAssignments, $employeeIds);

        // Assign new employees
        foreach ($toAssign as $employeeId) {
            $this->assignEmployee($shift, $employeeId);
        }

        // Unassign removed employees
        Assignment::where('shift_id', $shiftId)->whereIn('employee_id', $toUnassign)->delete();
    }

    private function assignEmployee($shift, string $employeeId)
    {
        $employee = User::find($employeeId);
        if (! $employee) {
            throw new Exception("Employee {$employeeId} not found");
        }

        // Check if employee is available on shift's date
        $dayOfWeek = date('l', strtotime($shift->date));
        if (! in_array($dayOfWeek, $employee->availability)) {
            throw new Exception("Employee {$employee->name} not available on this day");
        }

        Assignment::create(['shift_id' => $shift->_id, 'employee_id' => $employeeId]);
    }
}
