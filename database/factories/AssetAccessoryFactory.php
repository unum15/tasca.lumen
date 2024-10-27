<?php

namespace Database\Factories;

use App\Asset;
use App\AssetAccessory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetAccessoryFactory extends Factory
{
    protected $model = AssetAccessory::class;

    public function definition()
    {
        $asset = Asset::factory()->create();

        return [
            'asset_id' => $asset->id,
            'name' => $this->faker->word,
            'notes' => $this->faker->word,
            'value' => $this->faker->randomFloat(2, 0, 1000).'',
        ];
    }
}
