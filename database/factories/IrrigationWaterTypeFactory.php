<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\IrrigationWaterType;

class IrrigationWaterTypeFactory extends Factory
{
    protected $model = IrrigationWaterType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
