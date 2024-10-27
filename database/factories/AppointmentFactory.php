<?php

namespace Database\Factories;

use App\Appointment;
use App\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        $task = Task::factory()->create();

        return [
            'task_id' => $task->id,
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'day' => $this->faker->word,
            'notes' => $this->faker->text,
            'creator_id' => $this->faker->randomDigitNotNull,
            'updater_id' => $this->faker->randomDigitNotNull,
            'hours' => $this->faker->time,
            'sort_order' => $this->faker->word,
            'appointment_status_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
