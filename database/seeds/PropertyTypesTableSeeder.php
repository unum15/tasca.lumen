<?php

use Illuminate\Database\Seeder;
use App\PropertyType;

class PropertyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PropertyType::create(['name' => 'Home']);
    }
}
