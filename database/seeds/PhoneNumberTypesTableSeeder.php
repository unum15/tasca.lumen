<?php

use Illuminate\Database\Seeder;
Use App\PhoneNumberType;

class PhoneNumberTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhoneNumberType::create(['name' => 'Owner']);
    }
}
