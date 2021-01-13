<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\TaskStatus;

class TaskStatusFactory extends Factory
{
    protected $model = TaskStatus::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
