<?php

namespace App\Console\Commands;

use App\Appointment;
use App\Task;
use Illuminate\Console\Command;

class AppointmentCreateCommand extends Command
{
    protected $signature = 'appointment:create';

    protected $description = 'Creates new appointments based off past and expired appointments.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $tasks = Task::whereNull('tasks.completion_date')
            ->doesnthave('Appointments', 'and', function ($query) {
                $query->where('date', '>=', date('Y-m-d'))
                    ->orWhereNull('date');
            })
            ->get();

        foreach ($tasks as $task) {
            $notes = null;
            if (count($task->appointments) > 0) {
                $notes = $task->appointments->last()->notes;
            }
            Appointment::create([
                'task_id' => $task->id,
                'notes' => $notes,
                'creator_id' => $task->creator_id,
                'updater_id' => $task->creator_id,
            ]);
        }
    }
}
