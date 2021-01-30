<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\Appointment;

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
 
        $tasks = Task::
        whereNull('tasks.completion_date')
        ->doesnthave('Appointments', 'and', function ($query) {
            $query->where('date', '>=', date('Y-m-d'))
            ->orWhereNull('date');
        })
        ->get();
       
    
        foreach($tasks as $task){
            $notes = null;
            if(count($task->appointments) > 0){
                $notes=$task->appointments->last()->notes;
            }
            Appointment::create([
               'task_id' => $task->id,
               'notes' => $notes,
               'creator_id' => $task->creator_id,
               'updater_id' => $task->creator_id
            ]);
        }
    }
}
