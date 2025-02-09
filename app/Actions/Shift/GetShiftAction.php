<?php

namespace App\Actions\Shift;

namespace App\Actions\Shift;

use App\Models\Assignment;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Collection;

class GetShiftAction
{
    public function execute(): Collection
    {
        $shifts = Shift::latest()->get();

        return $shifts->map(function ($shift) {
            $assignments = Assignment::where('shift_id', $shift->_id)->get();

            $conflicts = false;
            $conflictMessages = [];

            $assignedEmployees = $assignments->map(function ($assignment) use (&$conflicts, &$conflictMessages, $shift) {
                $employee = User::find($assignment->employee_id);

                if ($employee) {
                    // Calculate total assigned hours for the last 7 days
                    $weeklyAssignments = Assignment::where('employee_id', $employee->_id)
                        ->whereBetween('shift_id', [
                            date('Y-m-d', strtotime('-7 days', strtotime($shift->date))),
                            $shift->date,
                        ])
                        ->get();

                    $totalHours = 0;
                    foreach ($weeklyAssignments as $weeklyAssignment) {
                        $assignedShift = Shift::find($weeklyAssignment->shift_id);
                        if ($assignedShift) {
                            $totalHours += (strtotime($assignedShift->end_time) - strtotime($assignedShift->start_time)) / 3600;
                        }
                    }

                    // Check if employee exceeds max hours per week
                    if ($totalHours > $employee->max_hours_per_week) {
                        $conflicts = true;
                        $conflictMessages[] = "Employee {$employee->name} exceeded max weekly hours ({$totalHours}/{$employee->max_hours_per_week}).";
                    }

                    return [
                        'employee_id' => $employee->_id,
                        'name' => $employee->name,
                        'hours_assigned' => (strtotime($shift->end_time) - strtotime($shift->start_time)) / 3600,
                    ];
                }

                return null;
            })->filter();

            return (object) [
                'shift_id' => $shift->_id,
                'date' => $shift->date,
                'start_time' => $shift->start_time,
                'end_time' => $shift->end_time,
                'max_employees' => $shift->max_employees,
                'assigned_employees' => $assignedEmployees->values(),
                'conflict' => $conflicts,
                'conflict_message' => $conflicts ? implode(', ', $conflictMessages) : null,
            ];
        });
    }
}
