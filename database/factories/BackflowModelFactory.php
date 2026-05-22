<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowModel;
use App\BackflowManufacturer;
use App\BackflowType;

class BackflowModelFactory extends Factory
{
    protected $model = BackflowModel::class;

    public function definition()
    {
        $manufacturer = BackflowManufacturer::factory()->create();
        $type = BackflowType::factory()->create();

        return [
            'backflow_manufacturer_id' => $manufacturer->id,
            'backflow_type_id' => $type->id,
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
