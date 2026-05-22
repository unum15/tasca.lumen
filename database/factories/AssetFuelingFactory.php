<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetFueling;
use App\Asset;
use App\AssetUsageType;

class AssetFuelingFactory extends Factory
{
    protected $model = AssetFueling::class;

    public function definition()
    {
        $asset = Asset::factory()->create();
        $asset_usage_type = AssetUsageType::factory()->create();

        return [
            'asset_id' => $asset->id,
            'asset_usage_type_id' => $asset_usage_type->id,
            'usage' => $this->faker->randomNumber(5),
            'date' => $this->faker->date,
            'gallons' => $this->faker->randomFloat(2, 0, 100),
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'notes' => $this->faker->text,
        ];
    }
}
