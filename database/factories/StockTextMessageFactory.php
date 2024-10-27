<?php

namespace Database\Factories;

use App\StockTextMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockTextMessageFactory extends Factory
{
    protected $model = StockTextMessage::class;

    public function definition()
    {

        return [
            'message' => $this->faker->text,
        ];
    }
}
