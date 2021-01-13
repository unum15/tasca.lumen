<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\LaborActivity;

class LaborActivityFactory extends Factory
{
    protected $model = LaborActivity::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'parent_id' => null
        ];
    }
}
