<?php

namespace Database\Factories;

use App\OrderCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderCategoryFactory extends Factory
{
    protected $model = OrderCategory::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
