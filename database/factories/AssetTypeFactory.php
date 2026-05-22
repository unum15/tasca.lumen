<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetType;
use App\AssetBrand;

class AssetTypeFactory extends Factory
{
    protected $model = AssetType::class;

    
      public function definition()
    {
        $asset_brand = AssetBrand::factory()->create();

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => (string)$this->faker->randomDigitNotNull,
            'asset_brand_id' => $asset_brand->id,
            'number' => $this->faker->randomLetter,
            'creator_id' => null,
            'updater_id' => null,
        ];
    }
}
