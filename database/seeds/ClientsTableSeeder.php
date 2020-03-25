<?php

use Illuminate\Database\Seeder;
use App\ActivityLevel;
use App\Client;
use App\ClientType;
use App\Contact;
use App\ContactMethod;
use App\ContactType;
Use App\PropertyType;


class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $activity_levels = ActivityLevel::pluck('id')->toArray();
        $client_types = ClientType::pluck('id')->toArray();
        $contact_methods = ContactMethod::pluck('id')->toArray();
        $contact_types = ContactType::pluck('id')->toArray();        
        $property_types = PropertyType::pluck('id')->toArray();
        $admin = Contact::first();
        
        
        for($x=0;$x<=50;$x++){
            $client = Client::create([
                'name' => $faker->lastName." Household",
                'notes' => $faker->realText,
                'activity_level_id' => $faker->randomElement($activity_levels),
                'referred_by' => $faker->name,
                'client_type_id' => $faker->randomElement($client_types),
                'contact_method_id' => $faker->randomElement($contact_methods),                
                'creator_id' => $admin->id,
                'updater_id' => $admin->id
            ]);
        }
    }
}
