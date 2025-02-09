<?php

namespace App\Actions\Assignment;

use App\Models\Assignment;
use App\Models\Shift;
use App\Models\User;

class AutoAssignEmployeesAction
{
    public function execute()
    {
        $shifts = Shift::all();
        $employees = User::where('role', 'employee')->get();

        $conflicts = [];

        foreach ($shifts as $shift) {
            $assignedEmployees = [];

            foreach ($employees as $employee) {
                if (count($assignedEmployees) >= $shift->max_employees) {
                    break;
                }

                $dayOfWeek = date('l', strtotime($shift->date));

                if (! in_array($dayOfWeek, $employee->availability)) {
                    $conflicts[] = "Employee {$employee->name} is not available on {$shift->date}.";

                    continue;
                }

                $weeklyAssignments = Assignment::where('employee_id', $employee->_id)
                    ->whereBetween('shift_id', [date('Y-m-d', strtotime('-7 days', strtotime($shift->date))), $shift->date])
                    ->get();

                $totalHours = 0;
                foreach ($weeklyAssignments as $assignment) {
                    $assignedShift = Shift::find($assignment->shift_id);
                    if ($assignedShift) {
                        $totalHours += (strtotime($assignedShift->end_time) - strtotime($assignedShift->start_time)) / 3600;
                    }
                }

                if ($totalHours >= $employee->max_hours_per_week) {
                    $conflicts[] = "Employee {$employee->name} has exceeded max weekly hours.";

                    continue;
                }

                $existingAssignments = Assignment::where('employee_id', $employee->_id)->get();
                $overlapping = false;

                foreach ($existingAssignments as $assignment) {
                    $assignedShift = Shift::find($assignment->shift_id);
                    if ($assignedShift &&
                        (($shift->start_time >= $assignedShift->start_time && $shift->start_time < $assignedShift->end_time) ||
                         ($shift->end_time > $assignedShift->start_time && $shift->end_time <= $assignedShift->end_time))) {
                        $overlapping = true;
                        $conflicts[] = "Employee {$employee->name} has an overlapping shift.";
                        break;
                    }
                }

                if (! $overlapping) {
                    Assignment::create([
                        'shift_id' => $shift->_id,
                        'employee_id' => $employee->_id,
                    ]);
                    $assignedEmployees[] = $employee->name;
                }
            }
        }
    }
}
