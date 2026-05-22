<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Asset;
use App\AssetType;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition()
    {
        $asset_type = AssetType::factory()->create();

        return [
            'name' => $this->faker->word,
            'asset_type_id' => $asset_type->id,
            'notes' => $this->faker->text,
            'year' => null,
            'make' => null,
            'model' => null,
            'trim' => null,
            'vin' => null,
            'parent_asset_id' => null,
            'asset_home_id' => null,
            'manufacture' => null,
            'purchase_cost' => null,
            'purchase_date' => null,
            'asset_category_id' => null,
            'asset_brand_id' => null,
            'asset_group_id' => null,
            'asset_sub_id' => null,
            'item_number' => null,
            'location' => null,
            'needs_maintenances' => false,
            'needs_parts' => false,
            'needs_repairs' => false,
            'needs_fuelings' => false,
            'needs_services' => false,
        ];
    }
}
