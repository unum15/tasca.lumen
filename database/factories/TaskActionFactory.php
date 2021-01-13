<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\TaskAction;

class TaskActionFactory extends Factory
{
    protected $model = TaskAction::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
