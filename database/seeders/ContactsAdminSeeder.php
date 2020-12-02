<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\ActivityLevel;
use App\Contact;
use App\ContactMethod;
Use App\Role;


class ContactsAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Contact::create([
                'name' => 'Admin Administrator',
                'activity_level_id' => ActivityLevel::first()->id,
                'show_maximium_activity_level_id' => ActivityLevel::first()->id,
                'contact_method_id' => ContactMethod::first()->id,
                'login' => 'admin@example.com',
                'password' => password_hash("adminpass", PASSWORD_DEFAULT),
                'creator_id' => 0,
                'updater_id' => 0
        ]);
//        $adminRole = Role::where('name', 'admin')->first();
//        $admin->attachRole($adminRole);

    }
}
