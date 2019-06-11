<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PopulateDatabaseDefaultsCommand;
use App\Console\Commands\TruncateDatabaseCommand;
<<<<<<< HEAD
use App\Console\Commands\MigrateOldDataCommand;
use App\Console\Commands\ImportPhreeBooksIdsCommand;
=======
>>>>>>> origin/master
use App\Console\Commands\ResetHelpCommand;
use App\Console\Commands\CreateTaskDatesCommand;
use App\Console\Commands\UpdateOrderStatusCommand;

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
<<<<<<< HEAD
        MigrateOldDataCommand::class,
        ImportPhreeBooksIdsCommand::class,
=======
>>>>>>> origin/master
        ResetHelpCommand::class,
        CreateTaskDatesCommand::class,
        UpdateOrderStatusCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->command('db:createTaskDates')->timezone(env("TIMEZONE", 'America/Denver'));
       $schedule->command('db:updateOrderStatus')->timezone(env("TIMEZONE", 'America/Denver'));
    }
}
