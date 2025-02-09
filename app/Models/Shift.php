<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Shift extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'shifts';

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'max_employees',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'shift_id', '_id');
    }
}
