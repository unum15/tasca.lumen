<?php

namespace Database\Factories;

use App\AssetGroup;
use App\AssetSub;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetSubFactory extends Factory
{
    protected $model = AssetSub::class;

    public function definition()
    {
        $asset_group = AssetGroup::factory()->create();

        return [
            'asset_group_id' => $asset_group->id,
            'name' => $this->faker->word,
            'number' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->word,
        ];
    }
}
