<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\ClientType;

class ClientTypeFactory extends Factory
{
    protected $model = ClientType::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
