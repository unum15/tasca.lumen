<?php

namespace Database\Factories;

use App\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyTypeFactory extends Factory
{
    protected $model = PropertyType::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'default' => $this->faker->boolean,
        ];
    }
}
