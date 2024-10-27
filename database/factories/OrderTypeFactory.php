<?php

namespace Database\Factories;

use App\OrderType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderTypeFactory extends Factory
{
    protected $model = OrderType::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
