<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetSub;
use App\AssetGroup;

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
            'sort_order' => $this->faker->word
        ];
    }
}
