<?php

namespace App\Actions\Auth;

use App\Models\Assignment;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GetEmployeeAction
{
    public function execute(): Collection
    {
        $employees = User::where('role', 'employee')->get();

        $assignments = Assignment::whereIn('employee_id', $employees->pluck('_id'))->get();

        $shifts = Shift::whereIn('_id', $assignments->pluck('shift_id'))->get()->keyBy('_id');

        $employees->each(function ($employee) use ($assignments, $shifts) {
            $assignedShifts = [];
            $hasConflict = false;
            $conflictMessages = [];
            $totalAssignedHours = 0;

            $assignments->where('employee_id', $employee->_id)->each(function ($assignment) use ($shifts, &$assignedShifts, &$hasConflict, &$conflictMessages, &$totalAssignedHours) {
                $shift = $shifts->get($assignment->shift_id);

                if ($shift) {
                    $shiftStart = Carbon::parse($shift->start_time);
                    $shiftEnd = Carbon::parse($shift->end_time);
                    $shiftHours = $shiftEnd->diffInHours($shiftStart);

                    $shiftData = [
                        'shift_id' => $shift->_id,
                        'start' => $shiftStart->format('H:i'),
                        'end' => $shiftEnd->format('H:i'),
                        'date' => Carbon::parse($shift->date)->format('Y-m-d'),
                        'hours' => $shiftHours,
                    ];

                    // Check for conflicts with already assigned shifts
                    foreach ($assignedShifts as $existingShift) {
                        if ($existingShift['date'] === $shiftData['date']) {
                            $existingStart = Carbon::parse($existingShift['start']);
                            $existingEnd = Carbon::parse($existingShift['end']);
                            $newStart = $shiftStart;
                            $newEnd = $shiftEnd;

                            if (
                                ($newStart->between($existingStart, $existingEnd)) ||
                                ($newEnd->between($existingStart, $existingEnd)) ||
                                ($existingStart->between($newStart, $newEnd)) ||
                                ($existingEnd->between($newStart, $newEnd))
                            ) {
                                $hasConflict = true;
                                $conflictMessages[] = "Conflict: Shift {$shiftData['shift_id']} ({$shiftData['start']}-{$shiftData['end']}) overlaps with another shift on {$shiftData['date']}.";
                            }
                        }
                    }

                    $assignedShifts[] = $shiftData;
                    $totalAssignedHours += $shiftHours;
                }
            });

            // Check if assigned hours exceed max_hours_per_week
            if ($employee->max_hours_per_week !== null && $totalAssignedHours > $employee->max_hours_per_week) {
                $hasConflict = true;
                $conflictMessages[] = "Conflict: Employee assigned {$totalAssignedHours} hours but max allowed is {$employee->max_hours_per_week}.";
            }

            $employee->assigned_shifts = array_values($assignedShifts);
            $employee->conflict = $hasConflict;
            $employee->conflict_messages = $hasConflict ? $conflictMessages : [];
        });

        return $employees;
    }
}
