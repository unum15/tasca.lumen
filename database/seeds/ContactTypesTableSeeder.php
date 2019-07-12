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
        DB::table('contact_types')->delete();
        ContactType::create(['name' => 'Owner']);
    }
}
