<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ActivityLevel;
use App\ClientType;
use App\ContactMethod;
use App\ContactType;
use App\EmailType;
use App\PhoneNumberType;
use App\PropertyType;
use App\OrderAction;
use App\OrderStatusType;
use App\OrderCategory;
use App\OrderPriority;
use App\OrderStatus;
use App\OrderType;
use App\TaskAction;
use App\AppointmentStatus;
use App\TaskStatus;
use App\TaskType;
use App\TaskCategory;

class InitTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create initial types for Tasca.';

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
                'Text',
                'Call'
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
            OrderPriority::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        $names = [
            "Irrigation",
            "Landscape",
            "Renovation",
            "Consulting",
            "Backflow",
            "Lighting",
            "Planting",
            "Water Feature",
            "Other Projects",
            "Weekly Lawn Care",
            "Landscape Care",
            "Annual Lawn Care"
        ];
        $sort = 1;
        foreach($names as $name){
            OrderCategory::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        
        $names = [
            "Will Call Back",
            "Reviewing",
            "Renewing",
            "On Hold",
            "Canceled"
        ];
        $sort = 1;
        $statuses = [];
        foreach($names as $name){
            $status = OrderStatus::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
            $statuses[$name] = $status->id;
        }
        
        
        $actions = [
                    "Contact" => [$statuses['Renewing']],
                    "Site Visit" => [$statuses['Reviewing']],
                    "Bid/Price" => [$statuses['Reviewing']],
                    "Get P.O." => [$statuses['On Hold']],
                    "Follow Up" => [$statuses['Will Call Back'],$statuses['Reviewing'],$statuses['On Hold']],
                    "Close Out" => [$statuses['Will Call Back'],$statuses['On Hold'],$statuses['Canceled']]
                ];
        
        $sort = 1;
        foreach($actions as $name => $statuses){
            $action = OrderAction::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
            
            $action->orderStatuses()->sync($statuses);
        }
                
       $names = [
            "Service Order",
            "Pending Work Order",
            "Work Order"
        ];
        $sort = 1;
        foreach($names as $name){
            OrderStatusType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }

        $names = [
            "No Appointment",
            "Contact for Appointment",
            "Confirmed Appointment",
            "Message",
            "Text",
            "Email"
        ];
        $sort = 1;
        foreach($names as $name){
            AppointmentStatus::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }

        
        $service_order_type_id = OrderStatusType::where('name', 'Service Order')->first()->id;
        $pending_work_order_type_id = OrderStatusType::where('name', 'Pending Work Order')->first()->id;
        $work_order_type_id = OrderStatusType::where('name', 'Work Order')->first()->id;
        
        $names = [
            "T & M",
            "Lead",
            "Quote",
            "Estimate",
            "Bid"
        ];
        $sort = 1;
        foreach($names as $name){
            OrderType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }

        $names = [
            "Non Billing",
            "Billing"
        ];
        $sort = 1;
        foreach($names as $name){
            TaskType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }

        $names = [
            "In Review" => [1],
            "Completed" => [1],
            "Call Off" => [1],
            "Pending" => [2],
            "In Progress" => [2],
            "Done" => [2],
            "On Hold" => [2],
            "Cancelled" => [2],
        ];

        
        $sort = 1;
        foreach($names as $name => $types){
            $status = TaskStatus::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
            $status->taskTypes()->sync($types);
        }
        $actions = [
            "Call/Email" => [1],
            "Schedule" => [1, 2],
            "Bill" => [2],
            "Close Out" => [1],
            "Report" => [1, 2],
        ];
        $sort = 1;
        foreach($actions as $name => $types){
            $action = TaskAction::create([
               'name' => $name,
               'sort_order' => $sort++
            ]);
            $action->taskTypes()->sync($types);
        }
        $names = [
            "Site Visit" => [1],
            "Appointment" => [1],
            "Office" => [1],
            "Errand" => [1],
            "Evaluation" => [2],
            "Day Task" => [2],
            "Service Task" => [2]
        ];
        $sort = 1;
        foreach($names as $name => $types){
            $category = TaskCategory::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
            $category->taskTypes()->sync($types);
        }
    }
}
