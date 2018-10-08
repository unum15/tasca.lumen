<?php

use Illuminate\Database\Seeder;
use App\Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->delete();
        $faker = Faker\Factory::create();
        
        for($x=0;$x<=10;$x++){
            Project::create([
                'name' => $faker->word,
                'notes' => $faker->text,
                'property_id' => $faker->numberBetween(1,100000),
                'contact_id' => $faker->numberBetween(1,100000),                
                'open_date' => $faker->date,
                'close_date' => $faker->date,
                'creator_id' => $faker->numberBetween(1,100000),
                'updater_id' => $faker->numberBetween(1,100000)
            ]);
        }
    }
}
