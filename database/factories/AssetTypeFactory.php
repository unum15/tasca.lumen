<?php

namespace Database\Factories;

use App\AssetBrand;
use App\AssetType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetTypeFactory extends Factory
{
    protected $model = AssetType::class;

    public function definition()
    {
        $asset_brand = AssetBrand::factory()->create();

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->word,
            'asset_brand_id' => $asset_brand->id,
            'number' => $this->faker->word,
        ];
    }
}
