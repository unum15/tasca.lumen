<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\OrderCategory;

class OrderCategoryFactory extends Factory
{
    protected $model = OrderCategory::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
