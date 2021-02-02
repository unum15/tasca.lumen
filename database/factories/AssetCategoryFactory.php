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
            'number' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->word
        ];
    }
}
