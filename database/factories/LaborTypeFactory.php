<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\LaborType;

class LaborTypeFactory extends Factory
{
    protected $model = LaborType::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
