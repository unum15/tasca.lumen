<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ActivityLevel;
use App\ClientType;
use App\Contact;
use App\ContactMethod;
use App\ContactType;
use App\EmailType;
use App\PhoneNumberType;
use App\PropertyType;
use App\ServiceOrderAction;
use App\ServiceOrderCategory;
use App\ServiceOrderPriority;
use App\ServiceOrderStatus;
use App\ServiceOrderType;
use App\Setting;
use App\TaskAction;
use App\TaskStatus;
use App\TaskCategory;
use App\TaskType;


class PopulateDatabaseDefaultsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:defaults';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $activity_levels = [
            [
                'name' => 'Level 1',
                'notes' =>  'Customers that have called in the last three years.',
                'sort_order' => 1
            ],
            [
                'name' => 'Level 2',
                'notes' =>  'Customers that have not called in the past three years.',
                'sort_order' => 2
            ],        
            [
                'name' => 'Level 3',
                'notes' =>  'Customers that have not called in the past five years.',
                'sort_order' => 3
            ],        
            [
                'name' => 'Level 4',
                'notes' =>  'Customers that have moved, but the location is still good.',
                'sort_order' => 4
            ],        
            [
                'name' => 'Level 5',
                'notes' =>  'Customers have moved and location is gone.',
                'sort_order' => 5
            ]
        ];        
        foreach($activity_levels as $activity_level){
            ActivityLevel::create($activity_level);
        };
        
        
        $names = [
                'None',
                'Mail',
                'Email',
                'Text'
        ];
        $sort = 1;
        foreach($names as $name){
            ContactMethod::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        
        $names = [
            'Residential',
            'Commercial',
            'Contractor',
            'Government',
            'Management',
            'HOA',
            'Other',
        ];
        $sort = 1;
        foreach($names as $name){
            ClientType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            "Owner",
            "Manager",
            "Maintenance",
            "Billing",
            "Contract Manager",
            "Project Manager",
            "Contractor",
            "Renter",
            "Family Member",
            "President",
            "Foreman"
        ];
        $sort = 1;
        foreach($names as $name){
            ContactType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }

        $names = [
            'Home',
            'Office',
            'Shop',
            'Store',
            'Rental',
            'Apartments',
            'Retail',
            'Restaurant',
            'Park',
            'Job Site',
            'Condo',
            'HOA',
            'Wharehouse'            
        ];
        $sort = 1;
        foreach($names as $name){
            PropertyType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            'Personal',
            'Office',
            'Home'            
        ];
        $sort = 1;
        foreach($names as $name){
            EmailType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            'Mobile',
            'Home',
            'Office',
            'Work',
            'Extension',
            'Unknown'            
        ];
        $sort = 1;
        foreach($names as $name){
            PhoneNumberType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            "Next Action",
            "Active",
            "Planning",
            "Pending",
            "On Hold",
            "Postponed",
            "Waiting",
            "Someday",
            "Reference",
            "Canceled"
        ];
        $sort = 1;
        foreach($names as $name){
            ServiceOrderPriority::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            "Renovation",
            "Consulting",
            "Other Projects",
        ];
        $sort = 1;
        foreach($names as $name){
            ServiceOrderCategory::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        
        $names = [
            "Waiting Bid" => [
                "Contact",
                "Site Visit",
                "Bid/Price",
                "Design",
                "Get P.O.",
                "Follow Up",            
                "To Do",
                "Report",
                "Bill",
                "Other",
                "Close Out",            
            ],
            "Bidded" => [
                        ],
            "Waiting Approval" => [
                        ],
            "Approved" => [
                        ],
            "Call Back" => [
                        ],
            "Will Call Back" => [
                        ],
            "On Hold" => [
                        ],
            "Completed" => [
                        ],
            "Pre Bid" => [
                        ]
        ];
        $sort = 1;
        foreach($names as $name => $actions){
            $status = ServiceOrderStatus::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
            $sort_action = 1;
            foreach($actions as $action){
                $status->serviceOrderActions()->create([
                    'name' => $action,
                    'sort_order' => $sort_action++
                ]);
            }
        }
        
                
        
        $names = [
            "Lead",
            "Quote",
            "Estimate",
            "Bid"
        ];
        $sort = 1;
        foreach($names as $name){
            ServiceOrderType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }

        
        $names = [
            "Active" => [
                "Call/Email",
                "Waiting for INFO",
                "Schedule",
                "Bill",
                "Close Out",
                "Wait",
                "Wating of AP",
                "ReSchedule",
                "Report",
                "Next Task",
                "Bid/Price"
                         ],
            "Next Action" => [
                        ],
            "Pending" => [
                        ],
            "Done" => [
                        ],
            "Cancelled" => [
                        ],
            "Inprogress" => [
                        ],
            "Waiting on Customer" => [
                        ]
        ];
        $sort = 1;
        foreach($names as $name => $actions){
            $status = TaskStatus::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
            $sort_action = 1;
            foreach($actions as $action){
                $status->taskActions()->create([
                    'name' => $action,
                    'sort_order' => $sort_action++
                ]);
            }
        }
        
        $names = [
            "Stop By",
            "Other",
            "Errand",
            "Office",
            "Appointment",
            "Audit",
            "Winterizing",
            "Tune Up",
            "Startup",
            "Day Job",
            "Repair",
            "Service Call"
        ];
        $sort = 1;
        foreach($names as $name){
            TaskCategory::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        //create contact so people can login
        
        Contact::create([
            'name' => 'Admin',
            'activity_level_id' => 1,
            'login' => 'admin@example.com',
            'password' => password_hash("adminpass", PASSWORD_DEFAULT),
            'creator_id' => 1,
            'updater_id' => 1 
        ]);
        
        //set defaults for forms
        ActivityLevel::where('name', 'Level 1')->first()->update(['default' => true]);
        ClientType::where('name', 'Residential')->first()->update(['default' => true]);
        ContactMethod::where('name', 'Text')->first()->update(['default' => true]);
        ContactType::where('name', 'Owner')->first()->update(['default' => true]);
        EmailType::where('name', 'Personal')->first()->update(['default' => true]);
        PhoneNumberType::where('name', 'Mobile')->first()->update(['default' => true]);
        PropertyType::where('name', 'Home')->first()->update(['default' => true]);
        ServiceOrderAction::where('name', 'To Do')->first()->update(['default' => true]);
        ServiceOrderPriority::where('name', 'Next Action')->first()->update(['default' => true]);
        ServiceOrderStatus::where('name', 'Approved')->first()->update(['default' => true]);
        TaskAction::where('name', 'Schedule')->first()->update(['default' => true]);
        TaskStatus::where('name', 'Next Action')->first()->update(['default' => true]);
//        TaskType::where('name', 'Service Call')->first()->update(['default' => true]);
//        WorkType::where('name', 'Irrigation')->first()->update(['default' => true]);

        Setting::create([
            'name' => 'default_activity_level_id',
            'value' => ActivityLevel::where('name', 'Level 1')->first()->id
        ]);        
        Setting::create([
            'name' => 'default_client_type_id',
            'value' => ClientType::where('name', 'Residential')->first()->id
        ]);
        Setting::create([
            'name' => 'default_contact_method_id',
            'value' => ContactMethod::where('name', 'Text')->first()->id
        ]);
        Setting::create([
            'name' => 'default_contact_type_id',
            'value' => ContactType::where('name', 'Owner')->first()->id
        ]);
        Setting::create([
            'name' => 'default_email_type_id',
            'value' => EmailType::where('name', 'Personal')->first()->id
        ]);
        Setting::create([
            'name' => 'default_phone_number_type_id',
            'value' => PhoneNumberType::where('name', 'Mobile')->first()->id
        ]);
        Setting::create([
            'name' => 'default_property_type_id',
            'value' => PropertyType::where('name', 'Home')->first()->id
        ]);
        Setting::create([
            'name' => 'default_service_order_action_id',
            'value' => ServiceOrderAction::where('name', 'To Do')->first()->id
        ]);
        Setting::create([
            'name' => 'default_service_order_category_id',
            'value' => ServiceOrderCategory::where('name', 'Consulting')->first()->id
        ]);
        Setting::create([
            'name' => 'default_service_order_priority_id',
            'value' => ServiceOrderPriority::where('name', 'Next Action')->first()->id
        ]);
        Setting::create([
            'name' => 'default_service_order_status_id',
            'value' => ServiceOrderStatus::where('name', 'Approved')->first()->id
        ]);
        Setting::create([
            'name' => 'default_task_action_id',
            'value' => TaskAction::where('name', 'Schedule')->first()->id
        ]);
        Setting::create([
            'name' => 'default_task_status_id',
            'value' => TaskStatus::where('name', 'Next Action')->first()->id
        ]);
        Setting::create([
            'name' => 'default_task_category_id',
            'value' => TaskCategory::where('name', 'Service Call')->first()->id
        ]);
        Setting::create([
            'name' => 'default_service_order_type_id',
            'value' => ServiceOrderType::where('name', 'Estimate')->first()->id
        ]);

        ServiceOrderStatus::where('name', 'Completed')->first()->update(['allow_work_order' => true]);

    }
}
