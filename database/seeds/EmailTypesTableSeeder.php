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
        EmailType::create(['name' => 'Owner']);
    }
}
