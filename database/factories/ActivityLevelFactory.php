<?php

namespace Database\Factories;

use App\ActivityLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLevelFactory extends Factory
{
    protected $model = ActivityLevel::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'default' => $this->faker->boolean
        ];
    }
}
