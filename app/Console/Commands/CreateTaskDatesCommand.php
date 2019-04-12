<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
 
        $oldTaskDates = TaskDate::where('date','<',date('Y-m-d'))
        ->whereNull('completion_date')
        ->get();
       
    
        foreach($oldTaskDates as $oldTaskDate){
            TaskDate::create([
               'task_id' => $oldTaskDate->task_id,
               'notes' => $oldTaskDate->notes,
               'creator_id' => $oldTaskDate->creator_id,
               'updater_id' => $oldTaskDate->creator_id
            ]);
        }
    }
}
