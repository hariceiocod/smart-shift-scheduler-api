<?php

namespace App\Http\Controllers;

use App\Actions\Shift\CreateShiftAction;
use App\Actions\Shift\DeleteShiftAction;
use App\Actions\Shift\GetShiftAction;
use App\Actions\Shift\UpdateShiftAction;
use App\Http\Requests\Shift\CreateShiftRequest;
use App\Http\Requests\Shift\DeleteShiftRequest;
use App\Http\Requests\Shift\UpdateShiftRequest;
use App\Http\Resources\Shift\ShiftCollection;
use App\Http\Resources\Shift\ShiftResource;

class ShiftController extends Controller
{
    public function index(GetShiftAction $action)
    {
        $shifts = $action->execute();

        return new ShiftCollection($shifts);
    }

    public function store(CreateShiftRequest $request, CreateShiftAction $action)
    {
        try {
            $data = $request->validated();
            $shift = $action->execute(
                $data['date'],
                $data['start_time'],
                $data['end_time'],
                $data['max_employees']
            );

            return $this->successResponse('Shift created successfully', new ShiftResource($shift));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(UpdateShiftRequest $request, UpdateShiftAction $action)
    {
        try {
            $data = $request->validated();
            $shift = $action->execute(
                $data['shift_id'],
                $data['date'],
                $data['start_time'],
                $data['end_time'],
                $data['max_employees']
            );

            return $this->successResponse('Shift updated successfully', new ShiftResource($shift));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(DeleteShiftRequest $request, DeleteShiftAction $action)
    {
        try {
            $data = $request->validated();
            $action->execute($data['shift_id']);

            return $this->successResponse('Shift deleted successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
