<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Contact;
use App\Project;
use App\Property;
use App\Priority;
use App\Order;
use App\OrderCategory;
use App\OrderPriority;
use App\OrderType;
use App\OrderStatus;
use App\OrderAction;
use App\Task;
use App\TaskType;
use App\TaskStatus;
use App\TaskAction;
Use App\TaskCategory;
use App\WorkType;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class ProjectsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('projects')->delete();
        $faker = Factory::create();
        $properties = Property::all();
        $contacts = Contact::pluck('id')->toArray();
        $service_order_categories = OrderCategory::pluck('id')->toArray();
        $service_order_priorities = OrderPriority::pluck('id')->toArray();
        $service_order_types = OrderType::pluck('id')->toArray();
        $service_order_statuses = OrderStatus::pluck('id')->toArray();
        $service_order_actions = OrderAction::pluck('id')->toArray();
        
        
        $task_categories = TaskCategory::pluck('id')->toArray();
        $task_types = TaskType::pluck('id')->toArray();
        $task_statuses = TaskStatus::pluck('id')->toArray();
        $task_actions = TaskAction::pluck('id')->toArray();
        
        $today = date_create();
        $yesterday = date_create();
        $yesterday->modify('-1 day');
        $last_week = date_create();
        $last_week->modify('-1 week');
        $last_month = date_create();
        $last_month->modify('-1 month');
        $last_year = date_create();
        $last_year->modify('-1 year');
        $next_week = date_create();
        $next_week->modify('+1 week');
        $next_year = date_create();
        $next_year->modify('+1 year');
        
        foreach($properties as $property){
            $projects_total= rand(1,5);
            for($project_count=0;$project_count<5;$project_count++){
                $client_contacts = Contact::whereHas('clients', function($q) use ($property){
                    $q->where('client_id', $property->client_id);
                })->pluck('id')->toArray();
                $open_date = $faker->dateTimeBetween('-1 month');
                $closed_date = null;
                $expiration = clone $open_date;
                $expiration->modify('+30 days');
                if(rand(0,4)%4 == 0){
                    $closed_date = $faker->dateTimeBetween($open_date->format('Y-m-d'));
                }
                $project = Project::create([
                    'name' => $faker->word,
                    'notes' => $faker->text,
                    'client_id' => $property->client_id,
                    'contact_id' => $faker->randomElement($client_contacts),
                    'open_date' => $open_date->format('Y-m-d'),
                    'close_date' => $closed_date ? $closed_date->format('Y-m-d') : null,
                    'creator_id' => $faker->randomElement($contacts),
                    'updater_id' => $faker->randomElement($contacts)
                ]);
                
                $order = Order::create([
                    'project_id' => $project->id,
                    'order_status_type_id' => 3,
                    'date' => $faker->date,
                    'approval_date' => $open_date->format('Y-m-d'),
                    'completion_date' => $closed_date ? $closed_date->format('Y-m-d') : null,
                    'expiration_date' => $faker->dateTimeBetween('-1 month','+1 year'),
                    'name' => $faker->word,
                    'description' => $faker->text,
                    'order_category_id' => $faker->randomElement($service_order_categories),
                    'order_priority_id' => $faker->randomElement($service_order_priorities),
                    'order_type_id' => $faker->randomElement($service_order_types),
                    'order_status_id' => $faker->randomElement($service_order_statuses),
                    'order_action_id' => $faker->randomElement($service_order_actions),
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
                    'renewal_date' => $faker->date,
                    'notification_lead' => $faker->numberBetween(1, 30),
                    'renewal_message' => $faker->text,
                    'creator_id' => $faker->randomElement($contacts),
                    'updater_id' => $faker->randomElement($contacts)
                ]);
                
                $order->properties()->sync([$property->id]);

                $task = Task::create([
                    'order_id' => $order->id,
                    'name' => $faker->word,
                    'description' => $faker->text,
                    'completion_date' => $closed_date ? $closed_date->format('Y-m-d') : null,
                    'task_category_id' => $faker->randomElement($task_categories),
                    'task_type_id' => $faker->randomElement($task_types),
                    'task_status_id' => $faker->randomElement($task_statuses),
                    'task_action_id' => $faker->randomElement($task_actions),
                    'crew_hours' => $faker->numberBetween(1, 30),
                    'notes' => $faker->text,
                    'creator_id' => $faker->randomElement($contacts),
                    'updater_id' => $faker->randomElement($contacts)
                ]);

                $task->dates()->create([
                    'date' => $faker->dateTimeBetween($open_date->format('Y-m-d')),
                    'creator_id' => $faker->randomElement($contacts),
                    'updater_id' => $faker->randomElement($contacts)
                ]);
            }
        }
    }
}
