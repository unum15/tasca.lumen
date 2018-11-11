<?php

use Illuminate\Database\Seeder;
use App\Contact;
use App\Project;
use App\Property;
use App\Priority;
use App\ServiceOrder;
use App\ServiceOrderCategory;
use App\ServiceOrderPriority;
use App\ServiceOrderType;
use App\ServiceOrderStatus;
use App\ServiceOrderAction;
use App\Task;
use App\TaskType;
use App\TaskStatus;
use App\TaskAction;
Use App\TaskCategory;
use App\WorkOrder;
use App\WorkType;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->delete();
        $faker = Faker\Factory::create();
        $properties = Property::all();
        $contacts = Contact::pluck('id')->toArray();
        $service_order_categories = ServiceOrderCategory::pluck('id')->toArray();
        $service_order_priorities = ServiceOrderPriority::pluck('id')->toArray();
        $service_order_types = ServiceOrderType::pluck('id')->toArray();
        $service_order_statuses = ServiceOrderStatus::pluck('id')->toArray();
        $service_order_actions = ServiceOrderAction::pluck('id')->toArray();
        
        
        $task_categories = TaskCategory::pluck('id')->toArray();
        $task_types = TaskType::pluck('id')->toArray();
        $task_statuses = TaskStatus::pluck('id')->toArray();
        $task_actions = TaskAction::pluck('id')->toArray();
        
        //$priorities = Priority::pluck('id')->toArray();;
        $work_types = WorkType::pluck('id')->toArray();;
        foreach($properties as $property){
            $client_contacts = Contact::whereHas('clients', function($q) use ($property){
                $q->where('client_id', $property->client_id);
            })->pluck('id')->toArray();
            $project = Project::create([
                'name' => $faker->word,
                'notes' => $faker->text,
                'property_id' => $property->id,
                'contact_id' => $faker->randomElement($client_contacts),
                'open_date' => $faker->date,
                'close_date' => $faker->date,
                'creator_id' => $faker->randomElement($contacts),
                'updater_id' => $faker->randomElement($contacts)
            ]);
            
            $service_order = ServiceOrder::create([
                'project_id' => $project->id,
                'date' => $faker->date,
                'approval_date' => $faker->date,
                'completion_date' => $faker->date,
                'expiration_date' => $faker->date,
                'description' => $faker->text,
                'service_order_category_id' => $faker->randomElement($service_order_categories),
                'service_order_priority_id' => $faker->randomElement($service_order_priorities),
                'service_order_type_id' => $faker->randomElement($service_order_types),
                'service_order_status_id' => $faker->randomElement($service_order_statuses),
                'service_order_action_id' => $faker->randomElement($service_order_actions),
                'start_date' => $faker->date,
                'recurrences' => $faker->numberBetween(1, 5),
                'service_window' => $faker->numberBetween(1, 5),
                'location' => $faker->word,
                'instructions' => $faker->text,
                'notes' => $faker->text,
                'purchase_order_number' => $faker->numberBetween(1, 100000),
                'budget' => $faker->numberBetween(1, 10000),
                'budget_plus_minus' => $faker->numberBetween(1, 1000),
                'budget_invoice_number' => $faker->numberBetween(1, 100000),
                'bid' => $faker->numberBetween(1, 10000),
                'bid_plus_minus' => $faker->numberBetween(1, 1000),
                'invoice_number' => $faker->numberBetween(1, 100000),
                'renewable' => $faker->boolean,
                'frequency' => $faker->numberBetween(1,365),
                'renewal_date' => $faker->date,
                'notification_lead' => $faker->numberBetween(1, 30),
                'renewal_message' => $faker->text,
                'creator_id' => $faker->randomElement($contacts),
                'updater_id' => $faker->randomElement($contacts)
            ]);
            
            Task::create([
                'service_order_id' => $service_order->id,
                'description' => $faker->text,
                'billable' => true,
                'task_category_id' => $faker->randomElement($task_categories),
                //'task_type_id' => $faker->randomElement($task_types),
                'task_status_id' => $faker->randomElement($task_statuses),
                'task_action_id' => $faker->randomElement($task_actions),
                'day' => $faker->word,
                'date' => $faker->date,
                'time' => $faker->word,
                'job_hours' => $faker->numberBetween(1, 30),
                'crew_hours' => $faker->numberBetween(1, 30),
                'notes' => $faker->text,
            ]);
            
            $work_order = WorkOrder::create([
                'project_id' => $project->id,
                'completion_date' => $faker->date,
                'expiration_date' => $faker->date,
               // 'priority_id' => $faker->randomElement($priorities),
                'work_type_id' => $faker->randomElement($work_types),
                'crew' => $faker->numberBetween(1, 30),
                'total_hours' => $faker->numberBetween(1, 30),
                'location' => $faker->word,
                'instructions' => $faker->text,
                'notes' => $faker->text,
                'purchase_order_number' => $faker->numberBetween(1, 10000),
                'budget' => $faker->numberBetween(1, 10000),
                'budget_plus_minus' => $faker->numberBetween(1, 1000),
                'budget_invoice_number' => $faker->numberBetween(1, 100000),
                'bid' => $faker->numberBetween(1, 10000),
                'bid_plus_minus' => $faker->numberBetween(1, 1000),
                'invoice_number' => $faker->numberBetween(1, 100000),
                'creator_id' => $faker->randomElement($contacts),
                'updater_id' => $faker->randomElement($contacts)
            ]);
        }
    }
}
