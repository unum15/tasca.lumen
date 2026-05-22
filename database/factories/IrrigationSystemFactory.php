<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\IrrigationSystem;
use App\Property;

class IrrigationSystemFactory extends Factory
{
    protected $model = IrrigationSystem::class;

    public function definition()
    {
        $property = Property::factory()->create();

        return [
            'property_id' => $property->id,
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'point_of_connection_location' => null,
            'irrigation_water_type_id' => null,
            'backflow_assembly_id' => null,
            'filter_model' => null,
            'filter_location' => null,
            'property_unit_id' => null,
            'start_up_cost' => null,
            'management_cost' => null,
            'winterizing_cost' => null,
            'visits_count' => null,
        ];
    }
}
