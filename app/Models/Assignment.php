<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Assignment extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'assignments';

    protected $fillable = [
        'shift_id',
        'employee_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
