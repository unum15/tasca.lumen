<?php

use Illuminate\Database\Seeder;
use App\Client;
use App\Property;

class ClientPropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
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
