<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PopulateDatabaseDefaultsCommand;
use App\Console\Commands\TruncateDatabaseCommand;
use App\Console\Commands\MigrateOldDataCommand;
use App\Console\Commands\ResetHelpCommand;
use App\Console\Commands\CreateTaskDatesCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        PopulateDatabaseDefaultsCommand::class,
        TruncateDatabaseCommand::class,
        MigrateOldDataCommand::class,
        ResetHelpCommand::class,
        CreateTaskDatesCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->command('db:createTaskDates')->daily(); 
    }
}
