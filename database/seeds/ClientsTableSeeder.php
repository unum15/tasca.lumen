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
        
        
        for($x=0;$x<=10;$x++){
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
            
/*            $client->update([
               'billing_contact_id' => $contact->id,
               'main_mailing_property_id' => $property->id
            ]);*/
        }
    }
}
