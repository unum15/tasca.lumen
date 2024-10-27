<?php

namespace Database\Factories;

use App\LaborType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaborTypeFactory extends Factory
{
    protected $model = LaborType::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
