<?php

namespace App\Actions\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterAction
{
    public function execute(string $name, string $email, string $password, string $role, int $maxHoursPerWeek, array $availability): User
    {
        try {
            return User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
                'max_hours_per_week' => $maxHoursPerWeek,
                'availability' => $availability,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            throw new Exception('Could not register user');
        }

    }
}
