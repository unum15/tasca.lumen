<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetImprovement;
use App\Asset;

class AssetImprovementFactory extends Factory
{
    protected $model = AssetImprovement::class;

    public function definition()
    {
        $asset = Asset::factory()->create();

        return [
            'asset_id' => $asset->id,
            'description' => $this->faker->sentence,
            'details' => $this->faker->text,
            'date' => $this->faker->date,
            'cost' => $this->faker->randomFloat(2, 0, 10000),
            'name' => null,
        ];
    }
}
