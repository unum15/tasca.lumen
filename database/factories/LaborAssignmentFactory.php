<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\LaborAssignment;
use App\Order;

class LaborAssignmentFactory extends Factory
{
    protected $model = LaborAssignment::class;

    
      public function definition()
    {
        $order = Order::factory()->create();

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'parent_id' => null,
            'order_id' => $order->id
        ];
    }
}
