<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\TaskDate;

class CreateTaskDatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:createTaskDates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new task dates based off past and expired task dates.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
 
        $tasks = Task::
        whereNull('tasks.completion_date')
        ->doesnthave('Dates', 'and', function ($query) {
            $query->where('date', '>', date('Y-m-d'));
        })
        ->get();
       
    
        foreach($tasks as $task){
            $notes = null;
            if(count($task->dates) > 0){
                $notes=$task->dates->last()->notes;
            }
            TaskDate::create([
               'task_id' => $task->id,
               'notes' => $notes,
               'creator_id' => $task->creator_id,
               'updater_id' => $task->creator_id
            ]);
        }
    }
}
