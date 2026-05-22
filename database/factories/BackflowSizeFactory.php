<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowSize;

class BackflowSizeFactory extends Factory
{
    protected $model = BackflowSize::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
