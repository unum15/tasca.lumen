<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowWaterSystem;

class BackflowWaterSystemFactory extends Factory
{
    protected $model = BackflowWaterSystem::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'zip' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'contact' => null,
            'email' => null,
            'abbreviation' => null,
        ];
    }
}
