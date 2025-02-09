<?php

namespace App\Actions\Auth;

use App\Models\User;
use Exception;

class UpdateAvailabilityAction
{
    public function execute(array $availability, int $maxHoursPerWeek): ?User
    {
        $user = User::find(auth()->id());

        if (! $user) {
            throw new Exception('User not found');
        }

        $user->update([
            'availability' => $availability,
            'max_hours_per_week' => $maxHoursPerWeek,
        ]);

        return $user->refresh();

    }
}
