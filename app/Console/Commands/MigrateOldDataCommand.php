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
use App\OrderDate;
use App\OrderPriority;
use App\OrderStatus;
use App\OrderType;
use App\Setting;
use App\SignIn;
use App\Task;
use App\TaskAction;
use App\TaskAppointmentStatus;
use App\TaskDate;
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

    public function formatPhoneNumber($number){
        $number = preg_replace('/"\(\)/', '', $number);
        $number = preg_replace('/^\s+/', '', $number);
        $number = preg_replace('/\s+/', '-', $number);
        return $number;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        Setting::create([
            'name' => 'help_client',
            'value' => 'A client represents a household or organization that you do business with. Contact information for individuals and properties should be store on their respective pages.'
        ]);
        
        Setting::create([
            'name' => 'help_contact',
            'value' => 'A contact represent and individual.  Contacts can be associated with multiple clients and with multiple properties for each client.'
        ]);
        
        Setting::create([
            'name' => 'help_property',
            'value' => 'A property represent a physical location. Whether that location is a work, billing or administrative location.'
        ]);
        
        Setting::create([
            'name' => 'help_project',
            'value' =>
"<p>A project is the end result the customer needs completed. It can be a simple repair of something that is damaged, an ongoing service or a full design build job.</p>
<p>Project Name: Give the Project a short name.</p>
<p>Contact: The person who is overseeing the project. This will default to the billing contact.</p>
"
        ]);
        
        Setting::create([
            'name' => 'help_service_order',
            'value' => 'Orders are the actions it will take to get the project completed. There can be a single action like a service call for a simple repair or several actions it will take to complete a design build job. There are 3 types of orders, Servie, Pending, and Work orders. Typilicy a order can be tied to a work phase or a billing invoice.'
        ]);
        
        Setting::create([
            'name' => 'help_pending_work_order',
            'value' => 'Orders are the actions it will take to get the project completed. There can be a single action like a service call for a simple repair or several actions it will take to complete a design build job. There are 3 types of orders, Servie, Pending, and Work orders. Typilicy a order can be tied to a work phase or a billing invoice.'
        ]);
        
        Setting::create([
            'name' => 'help_work_order',
            'value' => 'Orders are the actions it will take to get the project completed. There can be a single action like a service call for a simple repair or several actions it will take to complete a design build job. There are 3 types of orders, Servie, Pending, and Work orders. Typilicy a order can be tied to a work phase or a billing invoice.'
        ]);
        
        Setting::create([
            'name' => 'help_task',
            'value' => 'Task are the To Do items that get the orders completed they are assigned to a employee or crew. They are the items that need to be done for a order to be completed. There are 2 type of tasks; Service Order Task (Change to Non Billing) are Tasks that need to be done in preparation for the order to be completed. This is typical the task that are not charged to the client. Work Order Task(Change to Billing) are Tasks that need to done to complete the order. This is work the client will be billed for. '
        ]);
        
        Setting::create([
            'name' => 'help_show',
            'value' => 'true'
        ]);
        
        
        
        
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
                "actions" => [
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
                    "Close Out"
                ],
                "allow_work_order" => false
            ],
            "Bidded" => [
                "actions" => [],
                "allow_work_order" => false
                        ],
            "Waiting Approval" => [
                "actions" => [],
                "allow_work_order" => false
                        ],
            "Approved" => [
                "actions" => [],
                "allow_work_order" => false
                        ],
            "Call Back" => [
                "actions" => [],
                "allow_work_order" => false
                        ],
            "Will Call Back" => [
                "actions" => [],
                "allow_work_order" => false
                        ],
            "On Hold" => [
                "actions" => [],
                "allow_work_order" => false
                        ],
            "Completed" => [
                "actions" => [],
                "allow_work_order" => true
                        ],
            "Pre Bid" => [
                "actions" => [],
                "allow_work_order" => false
                        ]
        ];
        $sort = 1;
        foreach($names as $name => $settings){
            $status = OrderStatus::create([
                'name' => $name,
                'sort_order' => $sort++,
                'allow_work_order' => $settings['allow_work_order']
            ]);
            $sort_action = 1;
            foreach($settings['actions'] as $action){
                $status->orderActions()->create([
                    'name' => $action,
                    'sort_order' => $sort_action++
                ]);
            }
        }
        
                
       $names = [
            "T & M",
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
            TaskAppointmentStatus::create([
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
        $work_orders_map = [];
        
        
        
        $find_name = function($item, $key){
            return $item->name == $key;
        };
        
        foreach($contacts as $contact){
            echo "Importing contact ".$contact->first_name." ".$contact->last_name."(".$contact->contact_index.")\n";
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
                    'phone_number' => $this->formatPhoneNumber($phone_number->phone),
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
            echo "Importing client ".$client->client_name."(".$client->client_index.")\n";
            $client_type = $client_types->search($client->type);
            $activity_level = $activity_levels->search($client->active_level);
            $contact_method = $contact_methods->search($client->contact_method);
            $billing_contact_id = null;
            if($client->billing_contact_index != ""){
                if(isset($contacts_map[$client->billing_contact_index])){
                    $billing_contact = Contact::find($contacts_map[$client->billing_contact_index]);
                    if($billing_contact){
                        $billing_contact_id = $billing_contact->id;
                    }
                }
            }
            $new_client = Client::create(
                [
                    'name' => $client->client_name,
                    'notes' => $client->notes,
                    'referred_by' => $client->referred_by,
                    'creator_id' => $admin->id,
                    'updater_id' => $admin->id,
                    'billing_contact_id' => $billing_contact_id,
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
                    COALESCE(types.type, 'Home') AS type
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
            $project_number = 1;
            foreach($properties as $property){
                $property_type = $property_types->search($property->type);
                $activity_level = $activity_levels->search($property->active_level);
                $new_property = $new_client->properties()->create([
                    'name' => $property->property_name,
                    'notes' => $property->notes,
                    'activity_level_id' => $activity_level,
                    'phone_number' => $this->formatPhoneNumber($property->phone),
                    'address1' => $property->address1,
                    'address2' => $property->address2,
                    'city' => trim($property->city),
                    'state' => $property->state,
                    'zip' => trim($property->zip),
                    'work_property' => $property->work_property,
                    'property_type_id' => $property_type,
                    'creator_id' => $admin->id,
                    'updater_id' => $admin->id
                ]);
                
                if($client->billing_property_index == $property->property_index){
                    $new_client->update(['main_mailing_property_id' => $new_property->id]);
                }
                $property_contacts = $olddb->select("SELECT contact_index FROM contacts.contacts_properties WHERE property_index='".$property->property_index."'");
                foreach($property_contacts as $property_contact){
                    $contact = Contact::find($contacts_map[$property_contact->contact_index]);
                    $new_property->contacts()->save($contact);
                }
                
                
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
                    $approver_id = null;
                    if($work_order->approved_by != ""){
                        $approver_id = $contacts_map[$work_order->approved_by];
                    }
                    $project = Project::create([
                        'client_id' => $new_client->id,
                        'name' => !empty($work_order->description) ? $work_order->description : 'Project #' . $project_number++,
                        'notes' => null,
                        'contact_id' => $contact_id,
                        'open_date' => $work_order->workorder_date,
                        'close_date' => !empty($work_order->date_completed) ? $work_order->date_completed: $work_order->expires, 
                        'creator_id' => $admin->id,
                        'updater_id' => $admin->id
                    ]);
                    
                    $order_action = $order_actions->search($work_order->action);
                    //$order_category = $order_categories->search($work_order->category);
                    $order_priority = $order_priorities->search($work_order->priority);
                    $order_status = $order_statuses->search($work_order->status);
                    $order_type = $order_types->search($work_order->type);
                    
                    $new_work_order = Order::create([                        
                        'project_id' => $project->id,
                        'description' => !empty($work_order->description) ? $work_order->description : 'Order #' . $work_order->workorder_index,
                        'name' => $work_order->description,
                        'order_date' => $work_order->workorder_date,
                        'renewable' => false,
                        'order_billing_type_id' => $work_order_type_id,
                        'completion_date' => $work_order->date_completed,
                        'expiration_date' => $work_order->expires,
                        'approval_date' => $work_order->approval_date,
                        'start_date' => $work_order->approval_date,
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
                        'progress_percentage' => $work_order->progress_percentage,
                        'contact_id' => $contact_id,
                        'approver_id' => $approver_id,
                        'work_days' => $work_order->work_days,
                        'creator_id' => $admin->id,
                        'updater_id' => $admin->id
                    ]);
                    
                    $new_work_order->properties()->save($new_property);
                    
                    
                    $work_orders_map[$work_order->workorder_index] = $new_work_order->id;
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
                            contact_status,
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
                            LEFT JOIN workorders.contact_status cs ON (s.contact_status_index = cs.contact_status_index)
                        WHERE
                            workorder_index='".$work_order->workorder_index."'
                        ;
                    ";
                    $tasks = $olddb->select($task_sql);
                    foreach($tasks as $task){
                        //contact status index
                        $task_status_id = null;
                        $task_action_id = null;
                        $task_category_id = null;
                        $task_appointment_status_id = null;
                        $task_appointment_status = TaskAppointmentStatus::where('name', $task->contact_status)->first();
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
                        if($task_appointment_status){
                            $task_appointment_status_id = $task_appointment_status->id;
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
                            'task_appointment_status_id' => $task_appointment_status_id,
                            'hide' => $task->day,
                            'completion_date' => $work_order->date_completed,
                            'crew_hours' => $task->crew_hours,
                            'task_hours' => $task->job_hours ? $task->job_hours.' hours' : null,
                            'notes' => $task->notes,
                            'sort_order' => $sort_order,
                            'group' => $group,
                            'creator_id' => $admin->id,
                            'updater_id' => $admin->id
                        ]);
                        
                        TaskDate::create([
                               'task_id' => $new_task->id,
                               'date' => $task->date,
                               'time' => $task->time,
                               'day' => $task->day,
                               'creator_id' => $admin->id,
                               'updater_id' => $admin->id
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
        
        $sign_ins = $olddb->select("SELECT * FROM contacts.sign_ins WHERE contact_index IS NOT NULL AND workorder_index IS NOT NULL");
        foreach($sign_ins as $sign_in){
            if(isset($contacts_map[$sign_in->contact_index]) && isset($contacts_map[$sign_in->workorder_index])){
                SignIn::create([
                   'contact_id' =>  $contacts_map[$sign_in->contact_index],
                   'order_id' =>  $contacts_map[$sign_in->workorder_index],
                   'sign_in' => $sign_in->sign_in_time,
                   'sign_out' => $sign_in->sign_out_time,
                   'creator_id' => $admin->id,
                   'updater_id' => $admin->id
                ]);
            }
        }
        //Contact::where('login', 'paul')->first()->update(['login' => 'paul@waterscontracting.com']);
    }
}
