<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BackflowType;
use App\BackflowSuperType;

class BackflowTypeFactory extends Factory
{
    protected $model = BackflowType::class;

    public function definition()
    {
        $super_type = BackflowSuperType::factory()->create();

        return [
            'backflow_super_type_id' => $super_type->id,
            'name' => $this->faker->lexify('????'),
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
        ];
    }
}
