<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\ClientType;
use App\ContactType;
use App\EmailType;
use App\PhoneNumberType;
use App\PropertyType;
use App\Client;

class LookupTableSeeder extends Seeder
{
    public function run()
    {
        if (ClientType::count() === 0) {
            ClientType::factory()->create();
        }
        if (ContactType::count() === 0) {
            ContactType::factory()->create();
        }
        if (EmailType::count() === 0) {
            EmailType::factory()->create();
        }
        if (PhoneNumberType::count() === 0) {
            PhoneNumberType::factory()->create();
        }
        if (PropertyType::count() === 0) {
            PropertyType::factory()->create();
        }
        if (Client::count() === 0) {
            Client::factory()->create();
        }
    }
}
