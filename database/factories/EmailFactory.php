<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Email;
use App\Contact;
use App\EmailType;

class EmailFactory extends Factory
{
    protected $model = Email::class;

    public function definition()
    {
        $contact = Contact::factory()->create();
        $email_type = EmailType::factory()->create();

        return [
            'contact_id' => $contact->id,
            'email_type_id' => $email_type->id,
            'email' => $this->faker->safeEmail,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id,
        ];
    }
}
