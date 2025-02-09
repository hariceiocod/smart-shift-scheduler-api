<?php

namespace App\Actions\Auth;

use App\Models\User;
use Exception;

class ShowEmployeeAction
{
    public function execute(string $id): ?User
    {
        $employee = User::find($id);

        if (! $employee) {
            throw new Exception('Employee not found');
        }

        return $employee;
    }
}
