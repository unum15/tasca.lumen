<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Client;
use App\ActivityLevel;
use App\ClientType;
use App\ContactMethod;
use App\Contact;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    
      public function definition()
    {
        $activity_level = ActivityLevel::factory()->create();
        $contact = Contact::factory()->create();
        $client_type = ClientType::factory()->create();
        $contact_method = ContactMethod::factory()->create();

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'referred_by' => $this->faker->word,
            'client_type_id' => $client_type->id,
            'activity_level_id' => $activity_level->id,
            'contact_method_id' => $contact_method->id,
            'billing_contact_id' => $contact->id,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id,
            'phreebooks_id' => $this->faker->randomDigitNotNull
        ];
    }
}
