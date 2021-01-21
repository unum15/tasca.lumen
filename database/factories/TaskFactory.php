<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Task;
use App\Order;
use App\LaborAssignment;
use App\LaborType;
use App\TaskAction;
use App\TaskStatus;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    
      public function definition()
    {
        $order = Order::factory()->create();
        $labor_assignment = LaborAssignment::factory()->create();
        $labor_type = LaborType::factory()->create();
        $task_action = TaskAction::factory()->create();
        $task_status = TaskStatus::factory()->create();

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->word,
            'order_id' => $order->id,
            'labor_type_id' => $labor_type->id,
            'task_status_id' => $task_status->id,
            'task_action_id' => $task_action->id,
            'hide' => $this->faker->boolean,
            'completion_date' => $this->faker->date,
            'group' => $this->faker->word,
            'task_hours' => $this->faker->randomDigitNotNull,
            'crew_hours' => $this->faker->randomFloat(2,0,1000).'',
            'notes' => $this->faker->text,
            'creator_id' => $this->faker->randomDigitNotNull,
            'updater_id' => $this->faker->randomDigitNotNull,
            'crew_id' => $this->faker->randomDigitNotNull,
            'closed_date' => $this->faker->date,
            'billed_date' => $this->faker->date,
            'hold_date' => $this->faker->date,
            'invoiced_date' => $this->faker->date,
            'labor_assignment_id' => $labor_assignment->id
        ];
    }
}
