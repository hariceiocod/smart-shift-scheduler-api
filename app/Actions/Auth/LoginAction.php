<?php

namespace App\Actions\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginAction
{
    public function execute(string $email, string $password): User
    {
        try {
            $user = User::where('email', $email)->first();

            if (! $user) {
                throw new Exception('User not found. Please Register');
            }

            if (! Hash::check($password, $user->password)) {
                throw new Exception('Invalid credentials');
            }

            return $user;
        } catch (\Throwable $th) {
            Log::error($th);
            throw new Exception($th->getMessage());
        }

    }
}
