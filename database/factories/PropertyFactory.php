<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Property;
use App\ActivityLevel;
use App\Client;
use App\Contact;
use App\PropertyType;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    
      public function definition()
    {
        $activity_level = ActivityLevel::factory()->create();
        $client = Client::factory()->create();
        $contact = Contact::factory()->create();
        $property_type = PropertyType::factory()->create();

        return [
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'activity_level_id' => $activity_level->id,
            'property_type_id' => $property_type->id,
            'client_id' => $client->id,
            'work_property' => $this->faker->boolean,
            'billing_property' => $this->faker->boolean,
            'phone_number' => $this->faker->word,
            'address1' => $this->faker->word,
            'address2' => $this->faker->word,
            'city' => $this->faker->word,
            'state' => $this->faker->word,
            'zip' => $this->faker->word,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id,
            'phreebooks_id' => $this->faker->randomDigitNotNull,
            'abbreviation' => $this->faker->word
        ];
    }
}
