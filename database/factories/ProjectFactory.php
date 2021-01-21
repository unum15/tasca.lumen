<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Project;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    
      public function definition()
    {

        return [
            'client_id' => $this->faker->randomDigitNotNull,
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'contact_id' => $this->faker->randomDigitNotNull,
            'open_date' => $this->faker->date,
            'close_date' => $this->faker->date,
            'creator_id' => $this->faker->randomDigitNotNull,
            'updater_id' => $this->faker->randomDigitNotNull
        ];
    }
}
