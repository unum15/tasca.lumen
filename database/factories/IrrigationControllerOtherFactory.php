<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\IrrigationControllerOther;
use App\IrrigationController;

class IrrigationControllerOtherFactory extends Factory
{
    protected $model = IrrigationControllerOther::class;

    public function definition()
    {
        $controller = IrrigationController::factory()->create();

        return [
            'irrigation_controller_id' => $controller->id,
            'name' => $this->faker->word,
            'value' => $this->faker->word,
        ];
    }
}
