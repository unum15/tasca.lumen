<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\IrrigationZone;
use App\IrrigationController;

class IrrigationZoneFactory extends Factory
{
    protected $model = IrrigationZone::class;

    public function definition()
    {
        $controller = IrrigationController::factory()->create();

        return [
            'irrigation_controller_id' => $controller->id,
            'number' => $this->faker->randomDigitNotNull,
            'name' => $this->faker->word,
            'plant_type' => null,
            'head_type' => null,
            'gallons_per_minute' => null,
            'application_rate' => null,
            'heads' => null,
        ];
    }
}
