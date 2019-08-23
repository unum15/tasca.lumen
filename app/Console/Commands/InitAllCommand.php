<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ActivityLevel;
use App\Client;
use App\ClientType;
use App\Contact;
use App\ContactMethod;
use App\ContactType;
use App\Email;
use App\EmailType;
use App\PhoneNumber;
use App\PhoneNumberType;
use App\Project;
use App\PropertyType;
use App\Property;
use App\Order;
use App\OrderAction;
use App\OrderStatusType;
use App\OrderCategory;
use App\OrderDate;
use App\OrderPriority;
use App\OrderStatus;
use App\OrderType;
use App\Permission;
use App\Role;
use App\Setting;
use App\SignIn;
use App\Task;
use App\TaskAction;
use App\TaskAppointmentStatus;
use App\TaskDate;
use App\TaskStatus;
use App\TaskType;
use App\TaskCategory;


class InitAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate default data for Tasca.';

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
        $this->call('init:roles');
        $this->call('init:settings');
        $this->call('init:types');
        $this->call('init:admin');
    }
}
