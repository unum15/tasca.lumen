<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\IrrigationSystemOther;
use App\IrrigationSystem;

class IrrigationSystemOtherFactory extends Factory
{
    protected $model = IrrigationSystemOther::class;

    public function definition()
    {
        $system = IrrigationSystem::factory()->create();

        return [
            'irrigation_system_id' => $system->id,
            'name' => $this->faker->word,
            'value' => $this->faker->word,
        ];
    }
}
