<?php

namespace Database\Factories;

use App\LaborActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaborActivityFactory extends Factory
{
    protected $model = LaborActivity::class;

    public function definition()
    {

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'parent_id' => null,
        ];
    }
}
