<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Project;
use App\Client;
use App\Contact;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        $client = Client::factory()->create();
        $contact = Contact::factory()->create();

        return [
            'client_id' => $client->id,
            'name' => $this->faker->word,
            'notes' => $this->faker->text,
            'contact_id' => $contact->id,
            'open_date' => $this->faker->date,
            'close_date' => $this->faker->date,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id,
        ];
    }
}
