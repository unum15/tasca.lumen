<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PopulateDatabaseAdminCommand;
use App\Console\Commands\InitAdminCommand;
use App\Console\Commands\InitAllCommand;
use App\Console\Commands\InitIrrigationWaterTypesCommand;
use App\Console\Commands\InitRolesCommand;
use App\Console\Commands\InitSettingsCommand;
use App\Console\Commands\InitTypesCommand;
use App\Console\Commands\InitAssetTypesCommand;
use App\Console\Commands\InitBackflowTypesCommand;
use App\Console\Commands\InitOverheadCommand;
use App\Console\Commands\TruncateDatabaseCommand;
use App\Console\Commands\ResetHelpCommand;
use App\Console\Commands\AppointmentCreateCommand;
use App\Console\Commands\OrderCloseCommand;
use App\Console\Commands\OrderStatusCommand;
use App\Console\Commands\ReminderClockOutCommand;

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
        InitIrrigationWaterTypesCommand::class,
        InitRolesCommand::class,
        InitSettingsCommand::class,
        InitTypesCommand::class,
        InitAssetTypesCommand::class,
        InitBackflowTypesCommand::class,
        InitOverheadCommand::class,
        AppointmentCreateCommand::class,
        OrderCloseCommand::class,
        OrderStatusCommand::class,
        ReminderClockOutCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->command('Appointment:Create')->timezone(env("TIMEZONE", 'America/Denver'));
       $schedule->command('Order:Status')->timezone(env("TIMEZONE", 'America/Denver'));
       $schedule->command('Reminder:Email')->timezone(env("TIMEZONE", 'America/Denver'))->hourly();
       //$schedule->command('db:closeOrders')->timezone(env("TIMEZONE", 'America/Denver'));
    }
}
