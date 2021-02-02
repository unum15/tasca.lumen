<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetGroup;
use App\AssetType;

class AssetGroupFactory extends Factory
{
    protected $model = AssetGroup::class;

    
      public function definition()
    {
        $asset_type = AssetType::factory()->create();

        return [
            'asset_type_id' => $asset_type->id,
            'name' => $this->faker->word,
            'number' => $this->faker->word,
            'notes' => $this->faker->text,
            'sort_order' => $this->faker->word
        ];
    }
}
