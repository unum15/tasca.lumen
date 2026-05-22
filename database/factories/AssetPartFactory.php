<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetPart;

class AssetPartFactory extends Factory
{
    protected $model = AssetPart::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'on_hand' => $this->faker->randomDigitNotNull,
            'notes' => $this->faker->text,
        ];
    }
}
