<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();
        DB::table('client_contact')->delete();
        DB::table('clients')->delete();
        DB::table('properties')->delete();
        DB::table('emails')->delete();
        DB::table('phone_numbers')->delete();
        DB::table('contacts')->delete();
        DB::table('email_types')->delete();
        DB::table('phone_number_types')->delete();
        DB::table('contact_types')->delete();
        DB::table('property_types')->delete();
        DB::table('contact_methods')->delete();
        $this->call(PermissionsTableSeeder::class);
        $this->call(ActivityLevelsTableSeeder::class);
        $this->call(ContactMethodsTableSeeder::class);
        $this->call(ContactTypesTableSeeder::class);
        $this->call(EmailTypesTableSeeder::class);
        $this->call(PhoneNumberTypesTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(PropertyTypesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
    }
}
