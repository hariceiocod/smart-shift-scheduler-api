<?php

namespace App\Http\Controllers;

use App\Actions\Auth\GetEmployeeAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\ShowEmployeeAction;
use App\Actions\Auth\UpdateAvailabilityAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ShowEmployeeRequest;
use App\Http\Requests\Auth\UpdateAvailabilityRequest;
use App\Http\Resources\Auth\EmployeeCollection;
use App\Http\Resources\Auth\EmployeeDetailResource;
use App\Http\Resources\Auth\UserResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterAction $action)
    {
        try {
            $data = $request->validated();
            $user = $action->execute(
                $data['name'],
                $data['email'],
                $data['password'],
                $data['role'],
                $data['max_hours_per_week'],
                $data['availability']
            );

            return $this->successResponse('User registered successfully', new UserResource($user));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function login(LoginRequest $request, LoginAction $action)
    {
        try {
            $data = $request->validated();
            $user = $action->execute(
                $data['email'],
                $data['password'],
            );

            return $this->successResponse('User logged in successfully', new UserResource($user));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->successResponse('User logged out successfully');
    }

    public function update(UpdateAvailabilityRequest $request, UpdateAvailabilityAction $action)
    {
        try {
            $data = $request->validated();
            $user = $action->execute(
                $data['availability'],
                $data['max_hours_per_week'],
            );

            return $this->successResponse('User availability updated successfully', new EmployeeDetailResource($user));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function get(GetEmployeeAction $action)
    {
        $employees = $action->execute();

        return new EmployeeCollection($employees);
    }

    public function show(ShowEmployeeRequest $request, ShowEmployeeAction $action)
    {
        try {
            $data = $request->validated();
            $employee = $action->execute(
                $data['employee_id']
            );

            return $this->successResponse('Employee Details', new EmployeeDetailResource($employee));
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }

    }
}
