<?php

namespace Database\Factories;

use App\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\ActivityLevel;
use App\ContactMethod;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    
      public function definition()
    {
        $activity_level = ActivityLevel::factory()->create();
        $contact_method = ContactMethod::factory()->create();

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'activity_level_id' => $activity_level->id,
            'contact_method_id' => $contact_method->id,
            'login' => $this->faker->word,
            'password' => $this->faker->word,
            'google_calendar_token' => $this->faker->word,
            'google_calendar_id' => $this->faker->word,
            'show_help' => $this->faker->boolean,
            'show_maximium_activity_level_id' => $this->faker->randomDigitNotNull,
            'default_service_window' => $this->faker->randomDigitNotNull,
            'pending_days_out' => $this->faker->randomDigitNotNull,
            'fluid_containers' => $this->faker->boolean,
            'creator_id' => $this->faker->randomDigitNotNull,
            'updater_id' => $this->faker->randomDigitNotNull,
            'phreebooks_id' => $this->faker->randomDigitNotNull,
            'backflow_certification_number' => $this->faker->word
        ];
    }
}
