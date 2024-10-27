<?php

namespace Database\Factories;

use App\TaskAction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskActionFactory extends Factory
{
    protected $model = TaskAction::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
