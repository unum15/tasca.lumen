<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetBrand;
use App\AssetCategory;

class AssetBrandFactory extends Factory
{
    protected $model = AssetBrand::class;

    
      public function definition()
    {
        $asset_category = AssetCategory::factory()->create();

        return [
            'asset_category_id' => $asset_category->id,
            'name' => $this->faker->word,
            'number' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->word
        ];
    }
}
