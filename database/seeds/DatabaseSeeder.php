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
        DB::table('client_contact')->delete();
        DB::table('clients')->delete();
        DB::table('properties')->delete();
        DB::table('emails')->delete();
        DB::table('phone_numbers')->delete();
        DB::table('contacts')->delete();
        
        //create the admin user first
        $this->call(ContactsAdminSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(PropertiesTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(ClientPropertyTableSeeder::class);
    }
}
