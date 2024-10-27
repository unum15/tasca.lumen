<?php

namespace Database\Factories;

use App\OrderAction;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderActionFactory extends Factory
{
    protected $model = OrderAction::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
