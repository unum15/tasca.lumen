<?php

use Illuminate\Database\Seeder;
use App\ActivityLevel;
use App\Client;
use App\Contact;
use App\ContactMethod;
use App\ContactType;
Use App\PropertyType;


class PropertiesTableSeeder extends Seeder
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
        $contact_methods = ContactMethod::pluck('id')->toArray();
        $contact_types = ContactType::pluck('id')->toArray();
        $property_types = PropertyType::pluck('id')->toArray();
        $admin = Contact::first();
        $clients = Client::all();
        
        
        foreach($clients as $client){
            $prop_count = rand(1,4);
            for($x=0;$x<$prop_count;$x++){
                $property = $client->properties()->create([
                    'name' => 'Home',
                    'notes' => $faker->realText,
                    'activity_level_id' => $faker->randomElement($activity_levels),
                    'phone_number' => $faker->phoneNumber,
                    'address1' => $faker->streetAddress,
                    'address2' => $faker->secondaryAddress,
                    'city' => $faker->city,
                    'state' => $faker->stateAbbr,
                    'zip' => $faker->postcode,
                    'work_property' => $faker->boolean,
                    'property_type_id' => $faker->randomElement($property_types),
                    'creator_id' => $admin->id,
                    'updater_id' => $admin->id
                ]);
                if($x==0){
                    $client->update([
                       'main_mailing_property_id' => $property->id
                    ]);
                }
            }
        }
    }
}
