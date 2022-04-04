<?php

namespace App\Http\Controllers;

use App\Models\WorkSchedule;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function view_schedule()
    {
        $user = auth()->user();

        return view('work_schedule.view', [
            'work_schedule' => WorkSchedule::get_worker_schedule($user->id)
        ]);
    }
}
