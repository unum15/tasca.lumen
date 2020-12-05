<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Asset;
use App\AssetType;
use App\AssetUsageType;
use App\AssetFueling;
use App\AssetService;
use App\AssetServiceType;
use App\AssetUnit;
use App\AssetTimeUnit;
use App\AssetMaintenance;

class AssetsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('assets')->delete();
        $faker = \Faker\Factory::create();
        $types = AssetType::pluck('id')->toArray();
        $usage_types = AssetUsageType::pluck('id')->toArray();
        $service_types = AssetServiceType::pluck('id')->toArray();
        $units = AssetUnit::pluck('id')->toArray();
        $time_units = AssetTimeUnit::pluck('id')->toArray();
        for($x=0;$x<10;$x++){
            Asset::create(
                [
                    'name' => $faker->word(),
                    'asset_type_id' => $faker->randomElement($types),
                    'asset_usage_type_id' => $faker->randomElement($usage_types),
                    'year' => $faker->regexify('20[02]\d'),
                    'make' => $faker->word(),
                    'model' => $faker->word(),
                    'trim' => $faker->word(),
                    'vin' => $faker->word(),
                    'notes' => $faker->text()
                ]);
        }

        $assets = Asset::pluck('id')->toArray();
        for($x=0;$x<10;$x++){
            AssetFueling::create(
                [
                    'asset_id' => $faker->randomElement($assets),
                    'asset_usage_type_id' => $faker->randomElement($usage_types),
                    'usage' => $faker->randomNumber(),
                    'date' => $faker->date(),
                    'gallons' => $faker->randomDigitNotNull(),
                    'amount' => $faker->randomFloat(),
                    'notes' => $faker->text()
                ]);
        }

        for($x=0;$x<10;$x++){
            AssetService::create(
                [
                    'asset_id' => $faker->randomElement($assets),
                    'asset_service_type_id' => $faker->randomElement($service_types),
                    'description' => $faker->word(),
                    'quantity' => $faker->randomNumber(),
                    'asset_unit_id' => $faker->randomElement($units),
                    'asset_usage_type_id' => $faker->randomElement($usage_types),
                    'usage_interval' => $faker->randomNumber,
                    'time_usage_interval' => $faker->randomDigitNotNull,
                    'asset_time_unit_id' => $faker->randomElement($time_units),
                    'part_number' => $faker->regexify('/[\w\d]{3,10}/'),
                    'notes' => $faker->text()
                ]);
        }
    }
}
