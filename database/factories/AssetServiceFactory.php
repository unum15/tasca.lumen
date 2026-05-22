<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetService;
use App\Asset;
use App\AssetServiceType;

class AssetServiceFactory extends Factory
{
    protected $model = AssetService::class;

    public function definition()
    {
        $asset = Asset::factory()->create();
        $asset_service_type = AssetServiceType::factory()->create();

        return [
            'asset_id' => $asset->id,
            'asset_service_type_id' => $asset_service_type->id,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->randomDigitNotNull,
            'notes' => $this->faker->text,
            'asset_usage_type_id' => null,
            'asset_unit_id' => null,
            'usage_interval' => null,
            'part_number' => null,
            'time_usage_interval' => null,
            'asset_time_unit_id' => null,
        ];
    }
}
