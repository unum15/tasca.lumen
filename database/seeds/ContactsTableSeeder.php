<?php

use Illuminate\Database\Seeder;
use App\ActivityLevel;
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
        $contact_methods = ContactMethod::pluck('id')->toArray();
        $email_types = EmailType::pluck('id')->toArray();
        $phone_number_types = PhoneNumberType::pluck('id')->toArray();
        
        
        $admin = Contact::create([
                'name' => $faker->name,
                'notes' => $faker->text,
                'activity_level_id' => $faker->randomElement($activity_levels),
                'contact_method_id' => $faker->randomElement($contact_methods),
                'login' => 'admin@example.com',
                'password' => password_hash("testpass", PASSWORD_DEFAULT),
                'creator_id' => 0,
                'updater_id' => 0
        ]);
        
        
        $adminRole = Role::where('name', 'admin')->first();
        $admin->attachRole($adminRole);

        
        for($x=0;$x<=10;$x++){
            $contact = Contact::create([
                'name' => $faker->name,
                'notes' => $faker->realText,
                'activity_level_id' => $faker->randomElement($activity_levels),
                'contact_method_id' => $faker->randomElement($contact_methods),
                'creator_id' => $admin->id,
                'updater_id' => $admin->id
            ]);
            
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
        }
    }
}
