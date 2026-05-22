<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetMaintenance;
use App\AssetService;
use App\AssetUsageType;

class AssetMaintenanceFactory extends Factory
{
    protected $model = AssetMaintenance::class;

    public function definition()
    {
        $asset_service = AssetService::factory()->create();
        $asset_usage_type = AssetUsageType::factory()->create();

        return [
            'asset_service_id' => $asset_service->id,
            'asset_usage_type_id' => $asset_usage_type->id,
            'usage' => $this->faker->randomNumber(5),
            'date' => $this->faker->date,
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'where' => $this->faker->city,
            'notes' => $this->faker->text,
        ];
    }
}
