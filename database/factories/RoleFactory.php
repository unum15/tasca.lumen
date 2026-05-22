<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'display_name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence,
        ];
    }
}
