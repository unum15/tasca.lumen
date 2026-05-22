<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetAccessory;
use App\Asset;

class AssetAccessoryFactory extends Factory
{
    protected $model = AssetAccessory::class;

    
      public function definition()
    {
        $asset = Asset::factory()->create();

        return [
            'asset_id' => $asset->id,
            'quantity' => null,
            'name' => $this->faker->word,
            'notes' => $this->faker->word,
            'value' => $this->faker->randomFloat(2,0,1000).'',
            'creator_id' => null,
            'updater_id' => null,
        ];
    }
}
