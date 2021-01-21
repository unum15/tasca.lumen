<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\OrderStatus;

class OrderStatusFactory extends Factory
{
    protected $model = OrderStatus::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
