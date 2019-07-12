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
        $this->call(PermissionsTableSeeder::class);
        $this->call(ActivityLevelsTableSeeder::class);
        $this->call(ContactTypesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
    }
}
