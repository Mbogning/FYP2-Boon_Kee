<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    protected $table = 'work_schedule';
    protected $fillable = [
        'user_id',
        'user_role_id',
        'work_date'
    ];
}
