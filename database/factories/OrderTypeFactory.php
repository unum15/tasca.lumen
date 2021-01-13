<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\OrderType;

class OrderTypeFactory extends Factory
{
    protected $model = OrderType::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
