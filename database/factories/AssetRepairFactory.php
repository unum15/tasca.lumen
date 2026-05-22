<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetRepair;
use App\Asset;
use App\AssetUsageType;

class AssetRepairFactory extends Factory
{
    protected $model = AssetRepair::class;

    public function definition()
    {
        $asset = Asset::factory()->create();
        $asset_usage_type = AssetUsageType::factory()->create();

        return [
            'asset_id' => $asset->id,
            'asset_usage_type_id' => $asset_usage_type->id,
            'usage' => $this->faker->randomNumber(5),
            'repair' => $this->faker->sentence,
            'date' => $this->faker->date,
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'where' => $this->faker->city,
            'notes' => $this->faker->text,
        ];
    }
}
