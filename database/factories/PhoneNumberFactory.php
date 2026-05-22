<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\PhoneNumber;
use App\Contact;
use App\PhoneNumberType;

class PhoneNumberFactory extends Factory
{
    protected $model = PhoneNumber::class;

    public function definition()
    {
        $contact = Contact::factory()->create();
        $phone_number_type = PhoneNumberType::factory()->create();

        return [
            'contact_id' => $contact->id,
            'phone_number_type_id' => $phone_number_type->id,
            'phone_number' => $this->faker->phoneNumber,
            'creator_id' => $contact->id,
            'updater_id' => $contact->id,
        ];
    }
}
