<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetCategory;

class AssetCategoryFactory extends Factory
{
    protected $model = AssetCategory::class;

    
      public function definition()
    {

        return [
            'name' => $this->faker->word,
            'number' => strtoupper($this->faker->unique()->randomLetter),
            'notes' => $this->faker->text,
            'sort_order' => (string)$this->faker->randomDigitNotNull,
            'creator_id' => null,
            'updater_id' => null,
        ];
    }
}
