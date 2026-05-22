<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AssetPicture;
use App\Asset;

class AssetPictureFactory extends Factory
{
    protected $model = AssetPicture::class;

    public function definition()
    {
        $asset = Asset::factory()->create();

        return [
            'asset_id' => $asset->id,
            'filename' => $this->faker->uuid . '.jpg',
            'original_filename' => $this->faker->word . '.jpg',
            'notes' => $this->faker->text,
            'name' => null,
        ];
    }
}
