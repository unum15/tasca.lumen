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

class FixOldDataCommand extends Command
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
        $olddb = DB::connection('pgsql_old');
        $admin = Contact::where('login', 'paul@waterscontracting.com')->first();                
                
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
        
        $contacts_map = [];
        $work_orders_map = [];
        
        
        foreach($contacts as $index => $contact){
            $contacts_map[$contact->contact_index] = $index + 1;
        }
                
                $work_order_sql = "
                    SELECT
                        workorder_index
                    FROM 
                        workorders.workorders
                        LEFT JOIN properties.properties p ON (workorders.property_index = p.property_index)
                    ORDER BY
                        p.client_index,p.property_index,workorder_index
                ";

                $work_orders = $olddb->select($work_order_sql);
                foreach($work_orders as $index => $work_order){
                    $work_orders_map[$work_order->workorder_index] = $index+1;
                }
            
            
            
        $sign_ins = $olddb->select("SELECT * FROM contacts.sign_ins WHERE contact_index IS NOT NULL AND workorder_index IS NOT NULL");
        foreach($sign_ins as $sign_in){
            if(isset($contacts_map[$sign_in->contact_index]) && isset($work_orders_map[$sign_in->workorder_index])){
                SignIn::create([
                   'contact_id' =>  $contacts_map[$sign_in->contact_index],
                   'order_id' =>  $work_orders_map[$sign_in->workorder_index],
                   'sign_in' => $sign_in->sign_in_time,
                   'sign_out' => $sign_in->sign_out_time,
                   'creator_id' => $admin->id,
                   'updater_id' => $admin->id
                ]);
            }
        }
    }
}
