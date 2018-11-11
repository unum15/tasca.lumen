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
            ServiceOrderPriority::create([
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
            'name' => 'default_service_order_action_id',
            'value' => ServiceOrderAction::where('name', 'To Do')->first()->id
        ]);
        Setting::create([
            'name' => 'default_service_order_category_id',
            'value' => ServiceOrderCategory::where('name', 'Irrigation')->first()->id
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
        
        $olddb = DB::connection('pgsql_old');
        
        $client_sql="
            SELECT
                client_index,
                client_name,
                clients.notes,
                clients.referred_by,
                types.type,
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
                contact_method
            FROM
                contacts.contacts
                LEFT JOIN clients.active_levels ON (contacts.active_level_index=active_levels.type_index)
                LEFT JOIN contacts.contact_methods ON (contacts.contact_method_index=contact_methods.contact_method_index)
            ORDER BY
                contact_index
        ";
        
        $contacts = $olddb->select($contact_sql);
        
        $activity_levels = ActivityLevel::all();
        $client_types = ClientType::all();
        $contact_methods = ContactMethod::all();
        $contact_types = ContactType::all();        
        $email_types = EmailType::all();
        $phone_number_types = PhoneNumberType::all();
        $property_types = PropertyType::all();
        
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
                    'activity_level_id' => $activity_levels[$activity_level]->id,
                    'contact_method_id' => $contact_methods[$contact_method]->id
                ]
            );
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
                    'client_type_id' => $client_types[$client_type]->id,
                    'activity_level_id' => $activity_levels[$activity_level]->id,
                    'contact_method_id' => $contact_methods[$contact_method]->id
                ]
            );
            
            $property_sql="
                SELECT
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
                    types.type,
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
                    $contact_id = $contacts_map[$property->contact_index]->id;
                }
                $new_property = $new_client->properties()->create([
                    'name' => $property->property_name,
                    'notes' => $property->notes,
                    'activity_level_id' => $activity_levels[$activity_level]->id,
                    'phone_number' => $property->phone,
                    'address1' => $property->address1,
                    'address2' => $property->address2,
                    'city' => $property->city,
                    'state' => $property->state,
                    'zip' => $property->zip,
                    'primary_contact_id' => $contact_id,
                    'work_property' => $property->work_property,
                    'property_type_id' => $property_types[$property_type]->id,
                    'creator_id' => $admin->id,
                    'updater_id' => $admin->id
                ]);            
            }
            
            $associated_contacts = $olddb->select("SELECT contact_index,COALESCE(type,'Owner') AS type FROM clients.clients_contacts LEFT JOIN contacts.types ON (clients_contacts.contact_type_index=types.type_index) WHERE client_index='".$client->client_index."'");
            foreach($associated_contacts as $associated_contact){
                $contact = Contact::find($contacts_map[$associated_contact->contact_index]);
                $contact_type = $contact_types->search($associated_contact->type);
                $new_client->contacts()->save($contact,['contact_type_id' => $contact_types[$contact_type]->id]);
            }
        }
        
        //Contact::where('login', 'paul')->first()->update(['login' => 'paul@waterscontracting.com']);
    }
}
