<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetAppraisal;
use App\Asset;

class AssetAppraisalFactory extends Factory
{
    protected $model = AssetAppraisal::class;

    public function definition()
    {
        $asset = Asset::factory()->create();

        return [
            'asset_id' => $asset->id,
            'date' => $this->faker->date,
            'appraisal' => $this->faker->randomFloat(2, 0, 100000),
            'name' => null,
        ];
    }
}
