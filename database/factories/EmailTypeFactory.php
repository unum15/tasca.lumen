<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\EmailType;

class EmailTypeFactory extends Factory
{
    protected $model = EmailType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->randomDigitNotNull,
            'default' => false,
        ];
    }
}
