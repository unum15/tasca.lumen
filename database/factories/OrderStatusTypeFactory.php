<?php

namespace Database\Factories;

use App\OrderStatusType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusTypeFactory extends Factory
{
    protected $model = OrderStatusType::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
