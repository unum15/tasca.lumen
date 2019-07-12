<?php

use Illuminate\Database\Seeder;
use App\EmailType;

class EmailTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_types')->delete();
        ContactType::create(['name' => 'Owner']);
    }
}
