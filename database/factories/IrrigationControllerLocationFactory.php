<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\IrrigationControllerLocation;

class IrrigationControllerLocationFactory extends Factory
{
    protected $model = IrrigationControllerLocation::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
