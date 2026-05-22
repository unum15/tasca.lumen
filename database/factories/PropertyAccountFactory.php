<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\PropertyAccount;
use App\Property;

class PropertyAccountFactory extends Factory
{
    protected $model = PropertyAccount::class;

    public function definition()
    {
        $property = Property::factory()->create();

        return [
            'property_id' => $property->id,
            'number' => $this->faker->numerify('####'),
            'name' => $this->faker->company,
            'notes' => $this->faker->text,
            'access_code' => null,
            'address' => null,
            'backflow_water_system_id' => null,
            'city' => null,
        ];
    }
}
