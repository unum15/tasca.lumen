<?php

use Illuminate\Database\Seeder;
use App\ClockIn;
use App\TaskDate;
use App\Contact;
use App\OverheadAssignment;
use App\OverheadCategory;


class ClockInsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('clock_ins')->delete();
        $task_dates = TaskDate::all();
        $contacts = Contact::whereHas(
                'clients', function ($q) {
                    $q->where('client_id', 1);
                }
            )->pluck('id');
        $assignments = OverheadAssignment::all();
        $faker = Faker\Factory::create();
        foreach($task_dates as $task_date){
            $clock_in = $faker->dateTimeThisMonth();
            $clock_out = $faker->dateTimeInInterval($clock_in, '2 hours');
            ClockIn::create(
                [
                    'task_date_id' => $task_date->id,
                    'contact_id' => $faker->randomElement($contacts),
                    'clock_in' => $clock_in->format('Y-m-d H:i:s'),
                    'clock_out' => $clock_out->format('Y-m-d H:i:s'),
                    'notes' => $faker->text(),
                    'creator_id' => 1,
                    'updater_id' => 1,
                ]
            );
        }
        
        foreach($assignments as $assignment){
            foreach($assignment->overhead_categories as $category){
                $clock_in = $faker->dateTimeThisMonth();
                $clock_out = $faker->dateTimeInInterval($clock_in, '2 hours');
                ClockIn::create(
                    [
                        'overhead_assignment_id' => $assignment->id,
                        'overhead_category_id' => $category->id,
                        'contact_id' => $faker->randomElement($contacts),
                        'clock_in' => $clock_in->format('Y-m-d H:i:s'),
                        'clock_out' => $clock_out->format('Y-m-d H:i:s'),
                        'notes' => $faker->text(),
                        'creator_id' => 1,
                        'updater_id' => 1,
                    ]
                );
            }
        }


    }
}
