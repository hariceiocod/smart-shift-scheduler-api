<?php

namespace App\Http\Controllers;

use App\Actions\Assignment\AutoAssignEmployeesAction;
use App\Actions\Assignment\GetAssignmentAction;
use App\Actions\Assignment\UpdateAssignmentAction;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Http\Resources\Assignment\AssignmentCollection;

class AssignmentController extends Controller
{
    public function index(GetAssignmentAction $action)
    {
        $assignments = $action->execute();

        return new AssignmentCollection($assignments);
    }

    public function update(UpdateAssignmentRequest $request, UpdateAssignmentAction $action)
    {
        try {
            $data = $request->validated();
            $action->execute($data['shift_id'], $data['employee_ids']);

            return $this->successResponse('Assignments updated successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function autoAssign(AutoAssignEmployeesAction $action)
    {
        try {
            $action->execute();

            return $this->successResponse('Employees auto assigned successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
