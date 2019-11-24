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

$factory->define(App\BackflowAssembly::class, function (Faker\Generator $faker) {
    $property = factory('App\Property')->create();
    $contact = factory('App\Contact')->create();
    $style = factory('App\BackflowStyle')->create();
    return [
        'property_id' => $property->id,
        'contact_id' => $contact->id,
        'water_system' => $faker->word,
        'use' => $faker->word,
        'placement' => $faker->word,
        'backflow_style_id' => $style->id,
        'manufacturer' => $faker->word,
        'size' => $faker->word,
        'model_number' => $faker->word,
        'serial_number' => $faker->word,
        'notes' => $faker->word
    ];
});

$factory->define(App\BackflowStyle::class, function (Faker\Generator $faker) {
    return [
        'name' => substr($faker->word,0,4),
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowInstallationStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowTestStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowAssemblyTest::class, function (Faker\Generator $faker) {
    $installStatus = factory('App\BackflowInstallationStatus')->create();
    $testStatus = factory('App\BackflowTestStatus')->create();
    return [
        'visual_inspection_notes' => $faker->word,
        'backflow_installation_status_id' => $installStatus->id,
        'valve_1_psi_across' => $faker->randomDigitNotNull,
        'valve_1_test_status_id' => $testStatus->id,
        'valve_2_psi_across' => $faker->randomDigitNotNull,
        'valve_2_test_status_id' => $testStatus->id,
        'differential_pressure_relief_valve_opened_at' => $faker->randomDigitNotNull,
        'opened_under_2_status_id' => $testStatus->id,
        'pressure_vacuum_breaker_opened_at' => $faker->randomDigitNotNull,
        'opened_under_1_status_id' => $testStatus->id
    ];
});


$factory->define(App\BackflowStyleValf::class, function (Faker\Generator $faker) {
    return [
        'backflow_style_id' => $faker->randomDigitNotNull,
        'name' => $faker->word,
        'test_name' => $faker->word,
        'success_label' => $faker->word,
        'fail_label' => $faker->word
    ];
});

$factory->define(App\BackflowCertification::class, function (Faker\Generator $faker) {
    return [
        'backflow_assembly_id' => $faker->randomDigitNotNull,
        'visual_inspection_notes' => $faker->word,
        'backflow_installation_status_id' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowValvePart::class, function (Faker\Generator $faker) {
    return [
        'backflow_style_valve_id' => $faker->randomDigitNotNull,
        'name' => $faker->word
    ];
});

$factory->define(App\BackflowWaterSystem::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowUs::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowManufacturer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowModel::class, function (Faker\Generator $faker) {
    return 
    ];
});

$factory->define(App\BackflowType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowAssembly::class, function (Faker\Generator $faker) {
    return [
        'property_id' => $faker->randomDigitNotNull,
        'contact_id' => $faker->randomDigitNotNull,
        'backflow_type_id' => $faker->randomDigitNotNull,
        'backflow_water_system_id' => $faker->randomDigitNotNull,
        'backflow_use_id' => $faker->randomDigitNotNull,
        'backflow_manufacturer_id' => $faker->randomDigitNotNull,
        'backflow_model_id' => $faker->randomDigitNotNull,
        'placement' => $faker->word,
        'size' => $faker->word,
        'serial_number' => $faker->word,
        'notes' => $faker->word
    ];
});

$factory->define(App\BackflowTypeValf::class, function (Faker\Generator $faker) {
    return [
        'backflow_type_id' => $faker->randomDigitNotNull,
        'name' => $faker->word,
        'test_name' => $faker->word,
        'success_label' => $faker->word,
        'fail_label' => $faker->word
    ];
});

$factory->define(App\BackflowValvePart::class, function (Faker\Generator $faker) {
    return [
        'backflow_type_valve_id' => $faker->randomDigitNotNull,
        'name' => $faker->word
    ];
});

$factory->define(App\BackflowModel::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});
