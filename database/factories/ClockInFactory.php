<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\ClockIn;
use App\Contact;
use App\LaborActivity;
use App\Appointment;

class ClockInFactory extends Factory
{
    protected $model = ClockIn::class;

    
      public function definition()
    {
        $contact = Contact::factory()->create();
        $labor_activity = LaborActivity::factory()->create();
        $appointment = Appointment::factory()->create();

        return [
            'contact_id' => $contact->id,
            'clock_in' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'clock_out' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'notes' => $this->faker->text,
            'creator_id' => $this->faker->randomDigitNotNull,
            'updater_id' => $this->faker->randomDigitNotNull,
            'appointment_id' => $appointment->id,
            'labor_activity_id' => $labor_activity->id
        ];
    }
}
