<?php

use Illuminate\Database\Seeder;
use App\BackflowAssembly;
use App\BackflowType;
use App\BackflowWaterSystem;
use App\BackflowUse;
use App\BackflowManufacturer;
use App\BackflowModel;
use App\Contact;
use App\Project;
use App\Property;


class BackflowAssemblyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('backflow_assemblies')->delete();
        $faker = Faker\Factory::create();
        $properties = Property::all();
        $backflow_types = BackflowType::pluck('id')->toArray();
        $backflow_water_systems = BackflowWaterSystem::pluck('id')->toArray();
        $backflow_uses = BackflowUse::pluck('id')->toArray();
        $backflow_manufacturers = BackflowManufacturer::pluck('id')->toArray();
        $backflow_models = BackflowModel::pluck('id')->toArray();

        foreach($properties as $property){
            $client_contacts = Contact::whereHas('clients', function($q) use ($property){
                $q->where('client_id', $property->client_id);
            })->pluck('id')->toArray();
            $assembly = BackflowAssembly::create([
                'property_id' => $property->id,
                'contact_id' => $faker->randomElement($client_contacts),
                'backflow_type_id' => $faker->randomElement($backflow_types),
                'backflow_water_system_id' => $faker->randomElement($backflow_water_systems),
                'backflow_use_id' => $faker->randomElement($backflow_uses),
                'backflow_manufacturer_id' => $faker->randomElement($backflow_manufacturers),
                'backflow_model_id' => $faker->randomElement($backflow_models),
                'placement' => $faker->text,
                'size' => $faker->regexify('[1-3] x [1-3]'),
                'serial_number' => $faker->regexify('[\w-]{3-9}'),
                'notes' => $faker->text
            ]);
        }
    }
            
}
