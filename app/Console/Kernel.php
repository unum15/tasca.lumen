<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PopulateDatabaseAdminCommand;
use App\Console\Commands\InitAdminCommand;
use App\Console\Commands\InitAllCommand;
use App\Console\Commands\InitRolesCommand;
use App\Console\Commands\InitSettingsCommand;
use App\Console\Commands\InitTypesCommand;
use App\Console\Commands\InitVehicleTypesCommand;
use App\Console\Commands\InitBackflowTypesCommand;
use App\Console\Commands\TruncateDatabaseCommand;
use App\Console\Commands\ResetHelpCommand;
use App\Console\Commands\CreateTaskDatesCommand;
use App\Console\Commands\CloseOrdersCommand;
use App\Console\Commands\UpdateOrderStatusCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        InitAdminCommand::class,
        InitAllCommand::class,
        InitRolesCommand::class,
        InitSettingsCommand::class,
        InitTypesCommand::class,
        InitVehicleTypesCommand::class,
        InitBackflowTypesCommand::class,
        CreateTaskDatesCommand::class,
        CloseOrdersCommand::class,
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
       //$schedule->command('db:closeOrders')->timezone(env("TIMEZONE", 'America/Denver'));
    }
}
