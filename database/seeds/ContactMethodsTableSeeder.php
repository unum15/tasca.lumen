<?php

use Illuminate\Database\Seeder;
use App\ContactMethod;

class ContactMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactMethod::create(['name' => 'Text']);
    }
}
