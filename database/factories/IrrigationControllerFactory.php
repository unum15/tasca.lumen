<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\IrrigationController;
use App\IrrigationSystem;

class IrrigationControllerFactory extends Factory
{
    protected $model = IrrigationController::class;

    public function definition()
    {
        $system = IrrigationSystem::factory()->create();

        return [
            'irrigation_system_id' => $system->id,
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'placement' => null,
            'irrigation_controller_location_id' => null,
            'model' => null,
            'zones' => null,
            'username' => null,
            'password' => null,
            'property_unit_id' => null,
            'accessible' => null,
        ];
    }
}
