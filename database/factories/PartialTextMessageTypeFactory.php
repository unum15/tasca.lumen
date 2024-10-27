<?php

namespace Database\Factories;

use App\PartialTextMessageType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartialTextMessageTypeFactory extends Factory
{
    protected $model = PartialTextMessageType::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
