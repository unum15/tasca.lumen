<?php

use Illuminate\Database\Seeder;
use App\ContactType;

class ContactTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactType::create(['name' => 'Owner']);
    }
}
