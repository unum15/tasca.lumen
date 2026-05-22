<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\PropertyUnit;
use App\Property;

class PropertyUnitFactory extends Factory
{
    protected $model = PropertyUnit::class;

    public function definition()
    {
        $property = Property::factory()->create();

        return [
            'property_id' => $property->id,
            'name' => $this->faker->word,
            'number' => $this->faker->numerify('##'),
            'notes' => $this->faker->text,
            'coordinates' => null,
            'phone' => null,
        ];
    }
}
