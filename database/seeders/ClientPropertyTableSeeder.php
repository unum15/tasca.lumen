<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Client;
use App\Property;
use Faker\Factory;

class ClientPropertyTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        $clients = Client::all();
        $properties = Property::all();

        foreach($clients as $client){
            $contractor = rand(0,1);
            if($contractor){
                $client->linkedProperties()->attach($faker->randomElement($properties));
            }
        }
    }
}
