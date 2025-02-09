<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $connection = 'mongodb';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin' or 'employee'
        'availability', // Days of the week available
        'max_hours_per_week',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'employee_id');
    }
}
