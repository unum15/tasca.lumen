<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Setting;

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


class InitSettingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create initial settings for Tasca.';

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
            'value' =>"" //only wants project help on general tag
        ]);
        Setting::create([
            'name' => 'help_project_general',
            'value' =>
"
<h3>Project</h3>
<p>A project is the end result the customer needs completed. It can be a simple repair of something that is damaged, an ongoing service or a full design build job.</p>
<p>Project Name: Give the Project a short name.</p>
<p>Contact: The person who is overseeing the project. This will default to the billing contact.</p>
<h3>Orders</h3>
<p>Orders are the actions it will take to get the project completed. There can be a single action like a service call for a simple repair or several actions it will take to complete a design build job. There are 3 types of orders, Servie, Pending, and Work orders. Typically a order can be tied to a work phase or a billing invoice.</p>
<p>When creating a PWO or WO from a SO with multiple properties it will create a PWO or WO for each property. When creating a PWO or WO only one property can be selected.When a PWO or WO is created from a SO the SO that does not Renew will be closed. SO that renew will stay open with a new blank Approval and Start Dates. When the Client approves the renew of the order the Start Date will be updated with the Approval date or custom date.</p>
<h3>Project General Tab</h3>
<p>Notes: Place more details about the project here if need.</p>
<p>Open Date: This is the date the Project was created.</p>
<p>Close Date: This is the date the Project was closed. In Order to close a project all orders, and task must be completed, closed or expired, and no renewing SO. Projects will close out automatically after the number of days set in the settings, the default is 30 days.</p>
"
        ]);
        Setting::create([
            'name' => 'help_order_general',
            'value' => "
<h3>Order Details Tab</h3>
<ul>
    <li>Order Name: Give a short name for the type of order.</li>
    <li>Description: This is more descriptive of was the customer wants to be done. Keep it short more information can be made under the note tab.</li>
    <li>Category: This is used to group Orders together that are similar it can be customized in the setting. It can be Types of work, crews, or divisions.</li>
    <dl>
        <dt>Default options are:</dt>
        <dd>Construction: Orders for the Construction Crew.</dd>
        <dd>Maintenance: Orders for the Maintenance Crew.</dd>
        <dd>Service: Orders for the Service Crew.</dd>
    </dl>
    <li>Priority: Use this to keep track of the orders that need to be worked on before others.</li>
    <dl>
        <dt>Default options are:</dt>
        <dd>ASAP: Complete before any other client or job.</dd>
        <dd>Next Action: Complete as scheduled.</dd>
        <dd>Active: Complete when there is time.</dd>
        <dd>Non Active: The order has been placed on hold.</dd>
    </dl>
    <li>Type:  How is the customer being billed for the work being done. What type of pricing was given to the client?</li>
    <dl>
        <dt>Default options are:</dt>
        <dd>Lead: The client has told you about a job they need to be completed in the future.</dd>
        <dd>T & M: The work will be charged by the hour.</dd>
        <dd>Quote: The client has been given a quote for the cost of the order.</dd>
        <dd>Estimate: The client has been given an estimate for the cost of the order.</dd>
        <dd>Bid: The client has been given a Bid for the cost of the order.</dd>
    </dl>
    <li>Status: Where the order is in the process of being completed.</li>
    <dl>
        <dt>Default options are:</dt>
        <dd>Will Call Back: Client said they will call back.</dd>
        <dd>Reviewing: The order is being reviewed for  Quote or Bid.</dd>
        <dd>Renewing: Waiting to be renewed.</dd>
        <dd>On Hold: Waiting for approval from Client.</dd>
        <dd>Canceled: The order has be Canceled.</dd>
        <dd>Approved (only visible on WO tabs after the Approved date is entered.)</dd>
        <dd>Completed t(only visible on WO tabs after the Closed date is entered.)</dd>
    </dl>
    <li>Action: This is what needs to be done next in the process.</li>
    <dl>
        <dt>Default options are:</dt>
        <dd>Contact</dd>
        <dd>Follow Up</dd>
        <dd>Site Visit</dd>
        <dd>Bid</dd>
        <dd>Get P.O.</dd>
        <dd>Complete</dd>
        <dd>Close</dd>
    </dl>
</ul>


    

"
        ]);

        Setting::create([
            'name' => 'help_service_order',
            'value' => "
<h3>Service Order</h3>
<p>A service order is when a client inquires about service, this can be a Lead, Estimate, Quote or Bid. This would be work that you have not been authorized to do but may in the future. Use this section to keep track of leads, quotes, or bids you have pending.</p>
<p>A SO must be assigned to a project with an Open Date, Each SO must have a  Property, Name, Description,  Category, Priority, Type, Status and Action.</p>
<p>Check “Show Closed” to view the closed Service Orders.</p>
<p>Check “Show Expired” to view Service Orders that have Expired.</p>
<p>Property: This is the property the work will be done on, each order within a project can be assigned to a single property. It will default to the billing property. When creating a SO multiple properties can be selected. Click on the drop-down and hold the CTRL key to select multiple properties. This will allow WOs that include several properties to be created for each property</p>
"
        ]);
        
        
        Setting::create([
            'name' => 'help_pending_work_order',
            'value' =>
"
<h3>Pending Work Order</h3>
<p>Pending Work Orders are orders that the client has authorized to be completed but has not been placed on the schedule yet. Use pending work orders to keep track of upcoming work that you need to schedule.</p>
"
        ]);
        
        Setting::create([
            'name' => 'help_work_order',
            'value' =>
"
<h3>Work Order</h3>
<p>Work Orders has been authorized by the client to be completed and the Start date falls within the number of days out. This is the work assigned to each employee or crew to complete.</p>
"
        ]);
        
        Setting::create([
            'name' => 'help_order_calendar',
            'value' => "
<h3>Order Calendar Tab</h3>
<p>Use the Calendar tab to approve an order, set the start date, and set up recurring orders.</p>
<ul>
<li>Order Date: This is the date the customer made the first contact about the needed service. This will default to the current date.
<li>Close Date: The date a Recurring or Renewing SO was closed.<li>
<li>Expiration Date: A date can be assigned to hide this SO form the Calendar. It also can be the date the Quote, Estimate, or Bid expires. </li>
<li>Approval Date: The date the customer approves the order, this will typically be the date the customer calls and ask for the service.</li>
<li>Start Date: The date the order will start or the date the client is told the order will be started. This will default to the approved date.</li>
<li>Service Window: This is the time it will take to complete the order. Or it can be used to note the days the client was told the order will be completed.</li>
<li>Recurrences: Will this order be performed once or several times throughout the contract.The Start date will be the first date the order will be first be filled.</li>
<ul>
    <li>Times: How many orders will be created.</li>
    <li>Every: How often will an Order be created.</li>
    <li>Frequency: Yearly, Monthly, Weekly, Day</li>
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
<h3>Order Notes Tab</h3>
<p>Place notes here.</p>
"
        ]);

        Setting::create([
            'name' => 'help_order_billing',
            'value' =>
"
<h3>Order Billing Tab</h3>
Budget and bid information.
"
        ]);

        
        Setting::create([
            'name' => 'help_order_renewing',
            'value' =>
"
<h3>Service Order Renewing Tab</h3>
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
            'name' => 'default_nonbilling_task_action_id',
            'value' => TaskAction::where('name', 'Schedule')->first()->id
        ]);
        Setting::create([
            'name' => 'default_billing_task_action_id',
            'value' => TaskAction::where('name', 'Schedule')->first()->id
        ]);
        Setting::create([
            'name' => 'default_nonbilling_task_status_id',
            'value' => TaskStatus::where('name', 'In Review')->first()->id
        ]);
        Setting::create([
            'name' => 'default_billing_task_status_id',
            'value' => TaskStatus::where('name', 'In Progress')->first()->id
        ]);
        Setting::create([
            'name' => 'default_nonbilling_task_category_id',
            'value' => TaskCategory::where('name', 'Site Visit')->first()->id
        ]);
        Setting::create([
            'name' => 'default_billing_task_category_id',
            'value' => TaskCategory::where('name', 'Service Task')->first()->id
        ]);
        Setting::create([
            'name' => 'default_order_type_id',
            'value' => OrderType::where('name', 'Estimate')->first()->id
        ]);
    }
}