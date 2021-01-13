<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\OrderStatusType;

class OrderStatusTypeFactory extends Factory
{
    protected $model = OrderStatusType::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
