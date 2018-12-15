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
use App\Email;
use App\EmailType;
use App\PhoneNumber;
use App\PhoneNumberType;
use App\Project;
use App\PropertyType;
use App\Property;
use App\Order;
use App\OrderAction;
use App\OrderBillingType;
use App\OrderCategory;
use App\OrderPriority;
use App\OrderStatus;
use App\OrderType;
use App\Setting;
use App\Task;
use App\TaskAction;
use App\TaskStatus;
use App\TaskCategory;

class MigrateOldDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Data from database schema to new schema.';

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
            $status = OrderStatus::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
            $sort_action = 1;
            foreach($actions as $action){
                $status->orderActions()->create([
                    'name' => $action,
                    'sort_order' => $sort_action++
                ]);
            }
        }
        
                
       $names = [
            "Service Order",
            "Pending Work Order",
            "Work Order"
        ];
        $sort = 1;
        foreach($names as $name){
            OrderBillingType::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }

        $work_order_type_id = OrderBillingType::where('name', 'Work Order')->first()->id;
        
        $names = [
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
            "Clean Up",
            "Bed Maintance",
            "Weekly Lawn Care",
            "Fertilizing",
            "Spraying",
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
            "Service Call",
            "Ditch Witch"
        ];
        $sort = 1;
        foreach($names as $name){
            TaskCategory::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        //set defaults for forms
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
            'name' => 'default_order_action_id',
            'value' => OrderAction::where('name', 'To Do')->first()->id
        ]);
        Setting::create([
            'name' => 'default_order_category_id',
            'value' => OrderCategory::where('name', 'Irrigation')->first()->id
        ]);
        Setting::create([
            'name' => 'default_order_priority_id',
            'value' => OrderPriority::where('name', 'Next Action')->first()->id
        ]);
        Setting::create([
            'name' => 'default_order_status_id',
            'value' => OrderStatus::where('name', 'Approved')->first()->id
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
            'name' => 'default_order_type_id',
            'value' => OrderType::where('name', 'Estimate')->first()->id
        ]);

        OrderStatus::where('name', 'Completed')->first()->update(['allow_work_order' => true]);  
        
        $olddb = DB::connection('pgsql_old');
        
        $client_sql="
            SELECT
                client_index,
                client_name,
                clients.notes,
                clients.referred_by,
                COALESCE(types.type, 'Residential') AS type,
                active_levels.type as active_level,
                contact_method,
                billing_contact_index,
                billing_property_index
            FROM
                clients.clients
                LEFT JOIN clients.types ON (clients.client_type=types.type_index)
                LEFT JOIN clients.active_levels ON (clients.active_level_index=active_levels.type_index)
                LEFT JOIN contacts.contact_methods ON (clients.contact_method_index=contact_methods.contact_method_index)
            ORDER BY
                client_index
        ";
        
        $clients = $olddb->select($client_sql);
        
        $contact_sql="
            SELECT
                contact_index,
                first_name,
                last_name,
                notes,
                login,
                active_levels.type as active_level,                
                COALESCE(contact_method, 'None') AS contact_method
            FROM
                contacts.contacts
                LEFT JOIN clients.active_levels ON (contacts.active_level_index=active_levels.type_index)
                LEFT JOIN contacts.contact_methods ON (contacts.contact_method_index=contact_methods.contact_method_index)
            ORDER BY
                contact_index
        ";
        
        $contacts = $olddb->select($contact_sql);
        
        $activity_levels = ActivityLevel::pluck('name', 'id');
        $client_types = ClientType::pluck('name', 'id');
        $contact_methods = ContactMethod::pluck('name', 'id');
        $contact_types = ContactType::pluck('name', 'id');        
        $email_types = EmailType::pluck('name', 'id');
        $phone_number_types = PhoneNumberType::pluck('name', 'id');
        $property_types = PropertyType::pluck('name', 'id');
        $order_actions = OrderAction::pluck('name', 'id');
        $order_categories = OrderCategory::pluck('name', 'id');
        $order_priorities = OrderPriority::pluck('name', 'id');
        $order_statuses = OrderStatus::pluck('name', 'id');
        $order_types = OrderType::pluck('name', 'id');
        
        $contacts_map = [];
        
        
        
        $find_name = function($item, $key){
            return $item->name == $key;
        };
        
        foreach($contacts as $contact){            
            $activity_level = $activity_levels->search($contact->active_level);
            $contact_method = $contact_methods->search($contact->contact_method);
            $new_contact = Contact::create(
                [
                    'name' => $contact->first_name.' '.$contact->last_name,
                    'notes' => $contact->notes,
                    'login' => $contact->login,
                    'password' => password_hash($contact->last_name, PASSWORD_DEFAULT),
                    'creator_id' => 1,
                    'updater_id' => 1,                    
                    'activity_level_id' => $activity_level,
                    'contact_method_id' => $contact_method
                ]
            );
            $phone_numbers_sql="
                SELECT
                    phone,
                    type
                FROM
                    contacts.phone_numbers
                    LEFT JOIN contacts.phone_types ON (phone_numbers.type_index = phone_types.type_index)
                WHERE
                    phone != ''
                    AND contact_index='".$contact->contact_index."'
            ";
            $phone_numbers = $olddb->select($phone_numbers_sql);
            foreach($phone_numbers as $phone_number){
                $phone_number_type = $phone_number_types->search($phone_number->type);
                PhoneNumber::create([
                    'contact_id' => $new_contact->id,
                    'phone_number_type_id' => $phone_number_type,
                    'phone_number' => $phone_number->phone,
                    'creator_id' => 1,
                    'updater_id' => 1, 
                ]);
            }
            $emails_sql="
                SELECT
                    email,
                    type
                FROM
                    contacts.emails
                    LEFT JOIN contacts.email_types ON (emails.type_index = email_types.type_index)
                WHERE
                    email != ''
                    AND contact_index='".$contact->contact_index."'
            ";
            $emails = $olddb->select($emails_sql);
            foreach($emails as $email){
                $email_type = $email_types->search($email->type);
                Email::create([
                    'contact_id' => $new_contact->id,
                    'email_type_id' => $email_type,
                    'email' => $email->email,
                    'creator_id' => 1,
                    'updater_id' => 1, 
                ]);
            }
            $contacts_map[$contact->contact_index] = $new_contact->id;
        }
        $admin = Contact::orderBy('id')->first();
        foreach($clients as $client){
            $client_type = $client_types->search($client->type);
            $activity_level = $activity_levels->search($client->active_level);            
            $contact_method = $contact_methods->search($client->contact_method);
            $new_client = Client::create(
                [
                    'name' => $client->client_name,
                    'notes' => $client->notes,
                    'referred_by' => $client->referred_by,
                    'creator_id' => $admin->id,
                    'updater_id' => $admin->id,
                    'client_type_id' => $client_type,
                    'activity_level_id' => $activity_level,
                    'contact_method_id' => $contact_method
                ]
            );
            
            $property_sql="
                SELECT
                    property_index,
                    property_name,
                    notes,
                    phone,
                    address1,
                    address2,
                    city,
                    state,
                    zip,
                    work_property,
                    active_levels.type as active_level,
                    COALESCE(types.type, 'Home') AS type,
                    contact_index
                FROM
                    properties.properties
                    LEFT JOIN properties.types ON (types.type_index=properties.type_index)
                    LEFT JOIN clients.active_levels ON (properties.active_level_index=active_levels.type_index)
                WHERE
                    client_index='".$client->client_index."'
                ORDER BY
                    property_index
            ";
            
            $properties = $olddb->select($property_sql);
            foreach($properties as $property){
                $property_type = $property_types->search($property->type);
                $activity_level = $activity_levels->search($property->active_level);
                $contact_id = null;
                if($property->contact_index != ""){
                    $contact_id = $contacts_map[$property->contact_index];
                }
                $new_property = $new_client->properties()->create([
                    'name' => $property->property_name,
                    'notes' => $property->notes,
                    'activity_level_id' => $activity_level,
                    'phone_number' => $property->phone,
                    'address1' => $property->address1,
                    'address2' => $property->address2,
                    'city' => $property->city,
                    'state' => $property->state,
                    'zip' => $property->zip,
                    'primary_contact_id' => $contact_id,
                    'work_property' => $property->work_property,
                    'property_type_id' => $property_type,
                    'creator_id' => $admin->id,
                    'updater_id' => $admin->id
                ]);
                
                
                
                $work_order_sql = "
                    SELECT
                        workorder_index,
                        property_index,
                        location,
                        instructions,
                        priority_text AS priority, 
                        notes,
                        budget::numeric AS budget,
                        bid::numeric AS bid,
                        approval_date,
                        progress_percentage,
                        date_completed,
                        invoice_number,
                        description,
                        contact_index,
                        deleted,
                        po_number,
                        workorder_date,
                        approved_by,
                        budget_invoice_number,
                        budget_plus_minus,
                        bid_plus_minus,
                        work_hours,
                        work_days,
                        expires,
                        status,
                        type,
                        action,
                        group_name
                    FROM 
                        workorders.workorders
                        LEFT JOIN workorders.priorities ON (workorders.priority_index = priorities.priority_index)
                        LEFT JOIN workorders.workorder_actions ON (workorders.action_index = workorder_actions.action_index)
                        LEFT JOIN workorders.workorder_statuses ON (workorders.status_index = workorder_statuses.status_index)
                        LEFT JOIN workorders.workorder_types ON (workorders.type_index = workorder_types.type_index)
                    WHERE
                        property_index='" . $property->property_index. "'
                    ORDER BY
                        workorder_index
                ";

                $work_orders = $olddb->select($work_order_sql);
                foreach($work_orders as $work_order){
                    $contact_id = null;
                    if($work_order->contact_index != ""){
                        $contact_id = $contacts_map[$work_order->contact_index];
                    }
                    $project = Project::create([
                        'name' => $client->client_name.' Project',
                        'notes' => null,
                        'property_id' => $new_property->id,
                        'contact_id' => $contact_id,
                        'open_date' => date("Y-m-d"),
                        'close_date' => null, 
                        'creator_id' => $admin->id,
                        'updater_id' => $admin->id
                    ]);
                    
                    $order_action = $order_actions->search($work_order->action);
                    //$order_category = $order_categories->search($work_order->category);
                    $order_priority = $order_priorities->search($work_order->priority);
                    $order_status = $order_statuses->search($work_order->status);
                    $order_type = $order_types->search($work_order->type);
                    
                    $new_work_order = Order::create([
                        
//                        progress_percentage,
//                        contact_index,
//                        approved_by,
//                        work_days,
                        
                        'project_id' => $project->id,
                        'description' => $work_order->description,
                        'order_date' => $work_order->workorder_date,
                        'approval_date' => $work_order->approval_date,
                        'renewable' => false,
                        'order_billing_type_id' => $work_order_type_id,
                        'completion_date' => $work_order->date_completed,
                        'expiration_date' => $work_order->expires,
                        'order_priority_id' => $order_priority,
                        'order_status_id' => $order_status,
                        'order_category_id' => $order_type,
                        'order_action_id' => $order_action,
                        'work_type_id' => null,
                        'crew' => null,
                        'total_hours' => $work_order->work_hours,
                        'location' => $work_order->location,
                        'instructions' => $work_order->instructions,
                        'notes' => $work_order->notes,
                        'purchase_order_number' => $work_order->po_number,
                        'budget' => $work_order->budget,
                        'budget_plus_minus' => $work_order->budget_plus_minus,
                        'budget_invoice_number' => $work_order->budget_invoice_number,
                        'bid' => $work_order->bid,
                        'bid_plus_minus' => $work_order->bid_plus_minus,
                        'invoice_number' => $work_order->invoice_number,
                        'creator_id' => $admin->id,
                        'updater_id' => $admin->id
                    ]);
                    $task_sql = "
                        SELECT
                            schedule_index,
                            workorder_index,
                            status,
                            type,
                            action, 
                            day,
                            date,
                            sorder,
                            \"time\",
                            contact_status_index,
                            job_hours,
                            crew_hours, 
                            description,
                            notes,
                            hide,
                            group_name
                       FROM
                            workorders.schedule s
                            LEFT JOIN workorders.status ON (s.status_index=status.status_index)
                            LEFT JOIN workorders.types t ON (s.type_index=t.type_index)
                            LEFT JOIN workorders.action a ON (s.action_index = a.action_index)
                        WHERE
                            workorder_index='".$work_order->workorder_index."'
                        ;
                    ";
                    $tasks = $olddb->select($task_sql);
                    foreach($tasks as $task){
                        $task_status_id = null;
                        $task_action_id = null;
                        $task_category_id = null;
                        $task_status = TaskStatus::where('name', $task->status)->first();
                        $task_action = TaskAction::where('name', $task->action)->first();
                        $task_category = TaskCategory::where('name', $task->type)->first();
                        if($task_status){
                            $task_status_id = $task_status->id;
                        }
                        if($task_action){
                            $task_action_id = $task_action->id;
                        }
                        if($task_category){
                            $task_category_id = $task_category->id;
                        }
                        
                        $sort_order = preg_replace('/\w/','', $task->sorder);
                        $group = preg_replace('/\d/','', $task->sorder);
                        if($sort_order === ''){
                            $sort_order = null;
                        }
                        if($group === ''){
                            $group = null;
                        }
                        $new_task = Task::create([
                            'order_id' => $new_work_order->id,
                            'description' => $task->description,
                            'billable' => true,
                            'task_status_id' => $task_status_id,
                            'task_action_id' => $task_action_id,
                            'task_category_id' => $task_category_id,
                            'day' => $task->day,
                            'date' => $task->date,
                            'time' => $task->time,
                            'job_hours' => $task->job_hours,
                            'crew_hours' => $task->crew_hours,
                            'notes' => $task->notes,
                            'sort_order' => $sort_order,
                            'group' => $group
                        ]);
                    }
                }
                
                
                
                
                
                
                
                
                
                
                
                
                
            }
            
            $associated_contacts = $olddb->select("SELECT contact_index,COALESCE(type,'Owner') AS type FROM clients.clients_contacts LEFT JOIN contacts.types ON (clients_contacts.contact_type_index=types.type_index) WHERE client_index='".$client->client_index."'");
            foreach($associated_contacts as $associated_contact){
                $contact = Contact::find($contacts_map[$associated_contact->contact_index]);
                $contact_type = $contact_types->search($associated_contact->type);
                $new_client->contacts()->save($contact,['contact_type_id' => $contact_type]);
            }
        }
        
        //Contact::where('login', 'paul')->first()->update(['login' => 'paul@waterscontracting.com']);
    }
}
