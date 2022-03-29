<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class WorkSchedule extends Model
{
    protected $table = 'work_schedule';
    protected $fillable = [
        'user_id',
        'user_role_id',
        'work_date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'user_role_id');
    }
}
