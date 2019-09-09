<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Contact::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'creator_id' => 0,
        'updater_id' =>0
    ];
});

$factory->define(App\ActivityLevel::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Client::class, function (Faker\Generator $faker) {
    $contact = factory(App\Contact::class)->create();
    return [
        'name' => $faker->name,
        'creator_id' => $contact->id,
        'updater_id' => $contact->id
    ];
});

$factory->define(App\ClientType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\ContactMethod::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\ContactType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});


$factory->define(App\Email::class, function (Faker\Generator $faker) {
    $contact = factory(App\Contact::class)->create();
    $type = factory(App\EmailType::class)->create();
    return [
        'contact_id' => $contact->id,
        'email_type_id' => $type->id,
        'email' => $faker->email,
        'creator_id' => $contact->id,
        'updater_id' => $contact->id,
    ];
});

$factory->define(App\EmailType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});
$factory->define(App\Order::class, function (Faker\Generator $faker) {
    $contact = factory(App\Contact::class)->create();
    $project = factory(App\Project::class)->create();
    $order_status_type = factory(App\OrderStatusType::class)->create();
    return [
        'name' => $faker->word,
        'project_id' => $project->id,
        'order_status_type_id' => $order_status_type->id,
        'creator_id' => $contact->id,
        'updater_id' => $contact->id,
    ];
});

$factory->define(App\OrderStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\OrderStatusType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\OrderAction::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\OrderPriority::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\OrderStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\PhoneNumber::class, function (Faker\Generator $faker) {
    $contact = factory(App\Contact::class)->create();
    $type = factory(App\PhoneNumberType::class)->create();
    return [
        'contact_id' => $contact->id,
        'phone_number_type_id' => $type->id,
        'phone_number' => $faker->phoneNumber,
        'creator_id' => $contact->id,
        'updater_id' => $contact->id,
    ];
});

$factory->define(App\PhoneNumberType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Property::class, function (Faker\Generator $faker) {
    $activity_level = factory(App\ActivityLevel::class)->create();
    $contact = factory(App\Contact::class)->create();
    $client = factory(App\Client::class)->create();
    $property_type = factory(App\PropertyType::class)->create();
    return [
        'name' => $faker->word,
        'activity_level_id' => $activity_level->id,
        'property_type_id' => $property_type->id,
        'client_id' => $client->id,
        'creator_id' => $contact->id,
        'updater_id' => $contact->id,
    ];
});

$factory->define(App\PropertyType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});


$factory->define(App\Project::class, function (Faker\Generator $faker) {
    $contact = factory(App\Contact::class)->create();
    $client = factory(App\Client::class)->create();
    return [
        'name' => $faker->word,
        'client_id' => $client->id,
        'creator_id' => $contact->id,
        'updater_id' => $contact->id
    ];
});


$factory->define(App\Task::class, function (Faker\Generator $faker) {
    $contact = factory(App\Contact::class)->create();
    return [
        'name' => $faker->word,
        'creator_id' => $contact->id,
        'updater_id' => $contact->id,
    ];
});

$factory->define(App\SignIn::class, function (Faker\Generator $faker) {
    $contact = factory(App\Contact::class)->create();
    return [
        'contact_id' => $contact->id,
//        'task_date_id',
//        'sign_in',
        'notes' => 'Factory created!',
        'creator_id' => $contact->id,
        'updater_id' => $contact->id,
    ];
});


$factory->define(App\TaskAction::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\TaskDate::class, function (Faker\Generator $faker) {
    $contact = factory(App\Contact::class)->create();
    $task = factory(App\Task::class)->create();
    return [
        'task_id' => $task->id,
        'notes' => 'Factory created!',
        'creator_id' => $contact->id,
        'updater_id' => $contact->id,
    ];
});


$factory->define(App\TaskType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\WorkType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Vehicle::class, function (Faker\Generator $faker) {
    $type = factory('App\VehicleType')->create();
    return [
        'name' => $faker->word,
        'vehicle_type_id' => $type->id,
        'year' => $faker->randomDigitNotNull,
        'make' => $faker->word,
        'model' => $faker->word,
        'trim' => $faker->word,
        'vin' => $faker->word,
        'notes' => $faker->text
    ];
});

$factory->define(App\VehicleType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\Fueling::class, function (Faker\Generator $faker) {
    $vehicle = factory('App\Vehicle')->create();
    return [
        'vehicle_id' => $vehicle->id,
        'beginning_reading' => $faker->randomDigitNotNull,
        'ending_reading' => $faker->randomDigitNotNull,
        'date' => $faker->date,
        'gallons' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000) . "",
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000) . "",
        'notes' => $faker->text
    ];
});

$factory->define(App\Part::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'on_hand' => $faker->randomDigitNotNull,
        'notes' => $faker->text
    ];
});

$factory->define(App\Repair::class, function (Faker\Generator $faker) {
    $vehicle = factory('App\Vehicle')->create();
    return [
        'vehicle_id' => $vehicle->id,
        'repair' => $faker->word,
        'ending_reading' => $faker->randomDigitNotNull,
        'date' => $faker->date,
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000) . "",
        'where' => $faker->word,
        'notes' => $faker->text
    ];
});

$factory->define(App\ServiceType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\Service::class, function (Faker\Generator $faker) {
    $vehicle = factory('App\Vehicle')->create();
    $serviceType = factory('App\ServiceType')->create();
    $usageType = factory('App\UsageType')->create();
    return [
        'vehicle_id' => $vehicle->id,
        'service_type_id' => $serviceType->id,
        'description' => $faker->text,
        'quantity' => $faker->randomDigitNotNull,
        'usage_type_id' => $usageType->id,
        'usage_interval' => $faker->randomDigitNotNull,
        'part_number' => $faker->word,
        'notes' => $faker->text,
        'time_interval' => '00:15:00'
    ];
});

$factory->define(App\UsageType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\Maintenance::class, function (Faker\Generator $faker) {
    $service = factory('App\Service')->create();
    return [
        'service_id' => $service->id,
        'ending_reading' => $faker->randomDigitNotNull,
        'date' => $faker->date,
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000) . "",
        'where' => $faker->word,
        'notes' => $faker->text
    ];
});
