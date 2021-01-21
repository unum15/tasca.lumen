<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\OrderAction;

class OrderActionFactory extends Factory
{
    protected $model = OrderAction::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
