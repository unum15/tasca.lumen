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
use App\OrderStatusType;
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
use App\TaskType;
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
"
<h3>Project</h3>
<p>A project is the end result the customer needs completed. It can be a simple repair of something that is damaged, an ongoing service or a full design build job.</p>
<p>Project Name: Give the Project a short name.</p>
<p>Contact: The person who is overseeing the project. This will default to the billing contact.</p>
<h3>Orders</h3>
<p>Orders are the actions it will take to get the project completed. There can be a single action like a service call for a simple repair or several actions it will take to complete a design build job. There are 3 types of orders, Servie, Pending, and Work orders. Typically a order can be tied to a work phase or a billing invoice.</p>
"
        ]);
        Setting::create([
            'name' => 'help_project_general',
            'value' =>
"
<p>Notes: Place more details about the project here if need.</p>
<p>Open Date: This is the date the Project was created.</p>
<p>Close Date: This is the date the Project was closed. In Order to close a project all orders, and task must be completed, closed or expired, and no renewing SO. Projects will close out automatically after the number of days set in the settings, the default is 30 days.</p>
"
        ]);
        Setting::create([
            'name' => 'help_order_general',
            'value' => "
<p>Order Name: Give a short name for the type of order</p>
<p>Description: This is more descriptive of was the customer wants to be done. Keep it short more information can be made under the note tab.</p>
<p>Category: This is used to group Orders together that are similar it can be customized in the setting. It can be Types of work, crews, or divisions.</p>
<p>Service: Orders for the Service Crew</p>
<p>Priority: Use this to keep track of the orders that need to be worked on before others.</p>
<p>Type:  How is the customer being billed for the work being done. What type of pricing was given to the client?</p>
<p>Status: Where the order is in the process of being completed.</p>
<p>Action: This is what needs to be done next in the process.</p>
<p>Order Date: This is the date the customer made the first contact about the needed service.</p>
<p>Close Date The date the SO was converted to a PWO or WO</p>
<p>Expiration Date: A date can be assigned to hide this SO form the Calendar.</p>
"
        ]);

        Setting::create([
            'name' => 'help_service_order',
            'value' => "
<p>A service order is when a client inquires about service, this can be a Lead, Estimate, Quote or Bid. This would be work that you have not been authorized to do but may in the future. Use this section to keep track of leads, quotes, or bids you have pending.</p>
<p>Property: This is the property the work will be done on, each order within a project can be assigned to a single property. When creating a SO multiple properties can be selected. Click on the property select box and hold the CTRL key to select multiple properties. This will allow WOs that include several properties to be created for each property.</p>
<p>When creating a PWO or WO from a SO with multiple properties it will create a PWO or WO for each property. When creating a PWO or WO only one property can be selected.</p>
<p>When a PWO or WO is created from a SO the SO that does not Renew will be closed. SO that renew will stay open with a new blank Approval and Start Dates.</p>
<p>A SO must be assigned to a project with an Open Date, Each SO must have a  Property, Name, Description,  Category, Priority, Type, Status and Action.</p>
"
        ]);
        
        
        Setting::create([
            'name' => 'help_pending_work_order',
            'value' =>
"
<p>Pending Work Orders are orders that the client has authorized to be completed but has not been placed on the schedule yet. Use pending work orders to keep track of upcoming work that you need to schedule.</p>
"
        ]);
        
        Setting::create([
            'name' => 'help_work_order',
            'value' =>
"
<p>Work Orders has been authorized by the client to be completed and the Start date falls within the number of days out. This is the work assigned to each employee or crew to complete.</p>
"
        ]);
        
        Setting::create([
            'name' => 'help_order_calendar',
            'value' => "
<p>Use the Calendar place the order on the calendar and set up recurring orders. Service orders with date will show up on the order calendar.</p>
<p>Approval Date: The date the customer approves the order, this will typically be the date the customer calls and ask for the service.</p>
<p>Start Date: The date the order will start or the date the client is told the order will be started. This will default to the approved date.</p>
<p>Service Window: This is the time it will take to complete the order. Or it can be used to note the days the client was told the order will be completed.</p>
<p>Recurrences: Will this order be performed once or several times throughout the contract. Weekly, Biweekly, or Monthly. 1 means this will be done 1 time. 30 means this will be done 30 times.</p>
"
        ]);
        
        Setting::create([
            'name' => 'help_task',
            'value' =>
"
<h3>Task</h3>
<p>Tasks are the To Do items that get the orders completed they are assigned to an employee or crew. They are the items that need to be done for an order to be completed. There are 2 types of tasks; Non-billing Tasks need to be done in preparation for the order to be completed. This is typically the tasks that are not charged to the client. Billing Tasks need to done to complete the order and the client will be billed for.</p>
<p>Tasks are typically completed in one day however they can be scheduled for unlimited days. Each date will need to be added to the Task.If a task is not completed on the assigned date it will need to have another date that it will be completed add. This will keep a history of when tasks are scheduled. The uncompleted task with no scheduled dates or past dates will show up on the task list as unscheduled.</p>
<p>Task under service orders have 2 uses. The Non Billing task are task that need to be done in order for the client to approve the order. For example visiting the client or job, providing a quote or bid. The Billing task will be used when creating the PWO or WO to assign to a employee or crew to complete the order. There need to be at least on Billing task entered before a SO can create a PWO or WO. Additional one can be enter here or later.</p>
<p>Non Billing task will show up on the task list to be scheduled in order to complete the next step to close the SO. Billing task will not show on the list until the SO as been converted to a PWO or WO.  Each SO need at least 1 billing task, the first one will default to the order Name and description, change as need.</p>
<p>Task Type: Select if its a Non Billing or Billing Task</p>
<p>Name: This will be the name the employee will see to complete the task.</p>
<p>Description: This is a more indepth of what the task will involve.</p>
<p>Category:This is what type of task it will be. What type of tools or equipment will be need or similar task that will be done the same day.</p>
<p>Status:</p>
<p>Action:</p>
<p>Day: This is the day of the week to schedule the task on.</p>
<p>Date: The date entered here will be the date the task will be scheduled.</p>
<p>Time: This is the time the task is scheduled for.</p>
<p>Job Hours: This is the time the the crew has to complete the job.</p>
<p>Crew: This is the crew assigned to the task.</p>
<p>Crew Hours: This is the total man hours to complete the job.</p>
<p>Group: This is used for sorting the tasks when scheduling.</p>
<p>Sort Order: This is used to place the task in order for the day.</p>
<p>Completion Date: When the task is complete the crew will enter the date here..</p>
"
        ]);
        
        Setting::create([
            'name' => 'help_order_notes',
            'value' =>
"
Place notes here.
"
        ]);

        Setting::create([
            'name' => 'help_order_billing',
            'value' =>
"
Budget and bid information.
"
        ]);

        
        Setting::create([
            'name' => 'help_order_renewing',
            'value' =>
"
<p>Checkbox: Check to contact the client to renew the order if the service will need to be repeated.</p>
<p>Renewal Date:This will be the next date the Client will be contact to renew the service. When a SO is converted to a PWO or WO blank Approval and Start Dates will be created then this SO will show up on the calendar on the renewal date.</p>
<p>Frequency: This will be how often the client will need to be contacted to renew the order. Can be monthly, quarterly or yearly. 0 means never, 999 means indefinitely.</p>
<p>Notification Lead: Then number of days  before the renewal for the notification to be sent to the client and show up on the calendar. </p>
"
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
            "Will Call Back",
            "Reviewing",
            "Renewing",
            "On Hold",
            "Canceled"
        ];
        $sort = 1;
        foreach($names as $name){
            $status = OrderStatus::create([
                'name' => $name,
                'sort_order' => $sort++
            ]);
        }
        
        
        $actions = [
                    "Contact" => [3],
                    "Site Visit" => [2],
                    "Bid/Price" => [2],
                    "Get P.O." => [4],
                    "Follow Up" => [1,2,4],
                    "Close Out" => [1,4,5]
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
            TaskAppointmentStatus::create([
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
            'value' => OrderAction::where('name', 'Site Visit')->first()->id
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
            'value' => OrderStatus::where('name', 'Reviewing')->first()->id
        ]);
        Setting::create([
            'name' => 'default_task_action_id',
            'value' => TaskAction::where('name', 'Schedule')->first()->id
        ]);
        Setting::create([
            'name' => 'default_task_status_id',
            'value' => TaskStatus::where('name', 'Pending')->first()->id
        ]);
        Setting::create([
            'name' => 'default_task_category_id',
            'value' => TaskCategory::where('name', 'Service Task')->first()->id
        ]);
        Setting::create([
            'name' => 'default_order_type_id',
            'value' => OrderType::where('name', 'Estimate')->first()->id
        ]);
        
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
        
        $order_action_closed = $order_actions->search('Close Out');
        $order_status_completed = $order_statuses->search('Completed');
        $order_status_cancelled = $order_statuses->search('Cancelled');
        
        
        $task_status_done = TaskStatus::where('name', 'Done')->first()->id;
        $task_status_cancelled = TaskStatus::where('name', 'Cancelled')->first()->id;
        $task_action_close = TaskAction::where('name', 'Close Out')->first()->id;

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
                        'order_status_type_id' => $work_order->approval_date == "" ? $service_order_type_id : $work_order->approval_date > date('Y-m-d', strtotime('+7 days')) ? $pending_work_order_type_id : $work_order_type_id,
                        'completion_date' => $work_order->date_completed,
                        'expiration_date' => $work_order->expires,
                        'approval_date' => $work_order->approval_date,
                        'start_date' => $work_order->approval_date,
                        'order_priority_id' => $order_priority,
                        'order_status_id' => !empty($work_order->date_completed) ? $order_status_completed: !empty($work_order->expires) ? $order_status_cancelled : $order_status,
                        'order_category_id' => $order_type,
                        'order_action_id' => !empty($work_order->date_completed) || !empty($work_order->expires) ? $order_action_closed: $order_action,
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
                            'name' => $task->description,
                            'description' => $task->description,
                            'task_type_id' => 2,
                            'task_status_id' => !empty($work_order->date_completed) ? $task_status_done: !empty($work_order->expires) ? $task_status_cancelled : $task_status_id,
                            'task_action_id' => !empty($work_order->date_completed) || !empty($work_order->expires) ? $task_action_close: $task_action_id,
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
