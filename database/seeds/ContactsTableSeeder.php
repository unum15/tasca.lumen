<?php

use Illuminate\Database\Seeder;
use App\ActivityLevel;
use App\Client;
use App\Contact;
use App\ContactMethod;
use App\ContactType;
Use App\Email;
Use App\EmailType;
Use App\PhoneNumber;
Use App\PhoneNumberType;
Use App\PropertyType;
Use App\Role;


class ContactsTableSeeder extends Seeder
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
        $clients = Client::pluck('id')->toArray();
        $contact_methods = ContactMethod::pluck('id')->toArray();
        $contact_types = ContactType::pluck('id')->toArray();
        $email_types = EmailType::pluck('id')->toArray();
        $phone_number_types = PhoneNumberType::pluck('id')->toArray();
        $admin = Contact::first();
        $clients = Client::all();
        
        foreach($clients as $client){
            $contact_count = rand(1,4);
            for($x=0;$x<$contact_count;$x++){
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
                if($x==0){
                    $client->update(['billing_contact_id' => $contact->id]);
                }
            }
        }
    }
}
