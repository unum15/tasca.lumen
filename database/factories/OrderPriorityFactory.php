<?php

namespace Database\Factories;

use App\OrderPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderPriorityFactory extends Factory
{
    protected $model = OrderPriority::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
