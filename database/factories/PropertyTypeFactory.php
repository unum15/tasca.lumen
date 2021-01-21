<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\PropertyType;

class PropertyTypeFactory extends Factory
{
    protected $model = PropertyType::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'default' => $this->faker->boolean
        ];
    }
}
