<?php

namespace Database\Factories;

use App\ContactMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMethodFactory extends Factory
{
    protected $model = ContactMethod::class;

    
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
