<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowValve;

class BackflowValveFactory extends Factory
{
    protected $model = BackflowValve::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
