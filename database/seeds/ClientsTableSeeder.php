<?php

use Illuminate\Database\Seeder;
use App\ActivityLevel;
use App\Client;
use App\ClientType;
use App\Contact;
use App\ContactMethod;
use App\ContactType;
Use App\Email;
Use App\EmailType;
Use App\PhoneNumber;
Use App\PhoneNumberType;
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
        DB::table('clients')->delete();
        DB::table('client_contact')->delete();
        $faker = Faker\Factory::create();
        $activity_levels = ActivityLevel::pluck('id')->toArray();
        $client_types = ClientType::pluck('id')->toArray();
        $contact_methods = ContactMethod::pluck('id')->toArray();
        $contact_types = ContactType::pluck('id')->toArray();        
        $email_types = EmailType::pluck('id')->toArray();
        $phone_number_types = PhoneNumberType::pluck('id')->toArray();
        $property_types = PropertyType::pluck('id')->toArray();
        
        
        $admin = Contact::create([
                'name' => $faker->name,
                'notes' => $faker->text,
                'activity_level_id' => $faker->randomElement($activity_levels),
                'contact_method_id' => $faker->randomElement($contact_methods),
                'login' => 'admin@truecomputing.biz',
                'password' => password_hash("testpass", PASSWORD_DEFAULT),
                'creator_id' => $faker->numberBetween(1,100000),
                'updater_id' => $faker->numberBetween(1,100000)
        ]);

        
        for($x=0;$x<=10;$x++){
            $client = Client::create([
                'name' => $faker->lastName." Household",
                'notes' => $faker->realText,
                'activity_level_id' => 1,
                'referred_by' => $faker->name,
                'client_type_id' => $faker->randomElement($client_types),
                'contact_method_id' => $faker->randomElement($contact_methods),                
                'creator_id' => $admin->id,
                'updater_id' => $admin->id
            ]);
            
            $contact = $client->contacts()->create([
                'name' => $faker->name,
                'notes' => $faker->realText,
                'activity_level_id' => $faker->randomElement($activity_levels),
                'contact_method_id' => $faker->randomElement($contact_methods),
                'creator_id' => $admin->id,
                'updater_id' => $admin->id
            ],['contact_type_id' => $faker->randomElement($contact_types)]);
            
            $contact->emails()->create([
                'email_type_id' => $faker->randomElement($email_types),
                'email' => $faker->email,
                'creator_id' => $admin->id,
                'updater_id' => $admin->id
            ]);
            
            $contact->phoneNumbers()->create([
                'phone_number_type_id' => $faker->randomElement($phone_number_types),
                'phone_number' => $faker->phoneNumber,
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
                'primary_contact_id' => $contact->id,
                'work_property' => $faker->boolean,
                'property_type_id' => $faker->randomElement($property_types),
                'creator_id' => $admin->id,
                'updater_id' => $admin->id
            ]);
            
            $client->update([
               'billing_contact_id' => $contact->id,
               'billing_property_id' => $property->id
            ]);
        }
    }
}
