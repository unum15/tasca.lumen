<?php

use Illuminate\Database\Seeder;
use App\ActivityLevel;

class ActivityLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('activity_levels')->delete();
        for($x = 1; $x <= 5; $x++){
            ActivityLevel::create(['name' => 'Level ' . $x]);
        }
    }
}
