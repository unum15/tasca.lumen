<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetTimeUnit;

class AssetTimeUnitFactory extends Factory
{
    protected $model = AssetTimeUnit::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
