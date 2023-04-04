<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\SmsMessageType;

class SmsMessageTypeFactory extends Factory
{
    protected $model = SmsMessageType::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->text,
            'uses_date' => $this->faker->boolean,
            'sort_order' => $this->faker->randomDigitNotNull
        ];
    }
}
