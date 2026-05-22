<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowManufacturer;

class BackflowManufacturerFactory extends Factory
{
    protected $model = BackflowManufacturer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
