<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\PartialTextMessageType;

class PartialTextMessageTypeFactory extends Factory
{
    protected $model = PartialTextMessageType::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
