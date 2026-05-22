<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowAssembly;
use App\Property;
use App\BackflowType;
use App\BackflowWaterSystem;
use App\BackflowSize;
use App\BackflowManufacturer;
use App\BackflowModel;

class BackflowAssemblyFactory extends Factory
{
    protected $model = BackflowAssembly::class;

    public function definition()
    {
        $property = Property::factory()->create();

        return [
            'property_id' => $property->id,
            'notes' => $this->faker->text,
            'property_unit_id' => null,
            'contact_id' => null,
            'backflow_type_id' => null,
            'backflow_water_system_id' => null,
            'backflow_size_id' => null,
            'backflow_manufacturer_id' => null,
            'backflow_model_id' => null,
            'active' => true,
            'month' => null,
            'use' => null,
            'placement' => null,
            'gps' => null,
            'serial_number' => null,
            'property_account_id' => null,
            'need_access' => false,
        ];
    }
}
