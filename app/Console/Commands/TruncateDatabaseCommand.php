<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\ActivityLevel;
use App\Client;
use App\ClientType;
use App\Contact;
use App\ContactMethod;
use App\ContactType;
use App\EmailType;
use App\PhoneNumberType;
use App\PropertyType;
use App\Property;
use App\ServiceOrder;
use App\ServiceOrderAction;
use App\ServiceOrderCategory;
use App\ServiceOrderPriority;
use App\ServiceOrderStatus;
use App\ServiceOrderType;
use App\Setting;
use App\Task;
use App\TaskAction;
use App\TaskStatus;
use App\TaskCategory;
use App\TaskType;
use App\WorkOrder;


class TruncateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all tables in database.  This deletes everything!!!!';

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
        DB::statement('TRUNCATE clients CASCADE');
        DB::statement('TRUNCATE properties CASCADE');
        DB::statement('TRUNCATE contacts CASCADE');
        Task::truncate();
        WorkOrder::truncate();
        ServiceOrder::truncate();
        //Property::truncate();
        //Client::truncate();
        //Contact::truncate();
        ActivityLevel::truncate();
        ClientType::truncate();
        ContactMethod::truncate();
        ContactType::truncate();
        EmailType::truncate();
        PhoneNumberType::truncate();
        PropertyType::truncate();
        ServiceOrderAction::truncate();
        ServiceOrderCategory::truncate();
        ServiceOrderPriority::truncate();
        ServiceOrderStatus::truncate();
        ServiceOrderType::truncate();
        Setting::truncate();
        TaskAction::truncate();
        TaskStatus::truncate();
        TaskCategory::truncate();
        TaskType::truncate();
    }
}
