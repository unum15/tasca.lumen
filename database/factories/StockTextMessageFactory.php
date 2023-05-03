<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\StockTextMessage;

class StockTextMessageFactory extends Factory
{
    protected $model = StockTextMessage::class;

    
      public function definition()
    {

        return [
            'message' => $this->faker->text
        ];
    }
}
