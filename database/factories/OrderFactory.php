<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Order;
use App\Project;
use App\OrderStatusType;
use App\Contact;
use App\OrderCategory;
use App\OrderPriority;
use App\OrderType;
use App\OrderStatus;
use App\OrderAction;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    
      public function definition()
    {
        $project = Project::factory()->create();
        $order_status_type = OrderStatusType::factory()->create();
        $contact = Contact::factory()->create();
        $order_category = OrderCategory::factory()->create();
        $order_priority = OrderPriority::factory()->create();
        $order_type = OrderType::factory()->create();
        $order_status = OrderStatus::factory()->create();
        $order_action = OrderAction::factory()->create();

        return [
            'project_id' => $project->id,
            'name' => $this->faker->word,
            'order_status_type_id' => $order_status_type->id,
            'date' => $this->faker->date,
            'close_date' => $this->faker->date,
            'expiration_date' => $this->faker->date,
            'approval_date' => $this->faker->date,
            'start_date' => $this->faker->date,
            'description' => $this->faker->text,
            'progress_percentage' => $this->faker->randomDigitNotNull,
            'contact_id' => $contact->id,
            'approver_id' => $contact->id,
            'work_days' => $this->faker->word,
            'order_category_id' => $order_category->id,
            'order_priority_id' => $order_priority->id,
            'order_type_id' => $order_type->id,
            'order_status_id' => $order_status->id,
            'order_action_id' => $order_action->id,
            'location' => $this->faker->text,
            'instructions' => $this->faker->text,
            'notes' => $this->faker->text,
            'purchase_order_number' => $this->faker->word,
            'budget' => $this->faker->randomFloat(2,0,1000).'',
            'budget_plus_minus' => $this->faker->randomDigitNotNull,
            'budget_invoice_number' => $this->faker->word,
            'bid' => $this->faker->randomFloat(2,0,1000).'',
            'bid_plus_minus' => $this->faker->randomDigitNotNull,
            'invoice_number' => $this->faker->word,
            'service_window' => $this->faker->randomDigitNotNull,
            'renewable' => $this->faker->boolean,
            'recurrences' => $this->faker->randomDigitNotNull,
            'recurring' => $this->faker->boolean,
            'renewal_date' => $this->faker->date,
            'renewal_count' => $this->faker->randomDigitNotNull,
            'notification_lead' => $this->faker->randomDigitNotNull,
            'renewal_message' => $this->faker->text,
            'creator_id' => $this->faker->randomDigitNotNull,
            'updater_id' => $this->faker->randomDigitNotNull,
            'recurring_interval' => $this->faker->time,
            'renewal_interval' => $this->faker->time
        ];
    }
}
