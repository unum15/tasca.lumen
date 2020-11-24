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
    $category = factory(App\OrderCategory::class)->create();
    $priority = factory(App\OrderPriority::class)->create();
    $type = factory(App\OrderType::class)->create();
    $status = factory(App\OrderStatus::class)->create();
    $action = factory(App\OrderAction::class)->create();
    return [
        'name' => $faker->word,
        'project_id' => $project->id,
        'order_status_type_id' => $order_status_type->id,
        'name' => $faker->word,
        'date' => $faker->date,
        'completion_date' => $faker->date,
        'expiration_date' => $faker->date,
        'approval_date' => $faker->date,
        'start_date' => $faker->date,
        'description' => $faker->word,
        'order_category_id' => $category->id,
        'order_priority_id' => $priority->id,
        'order_type_id' => $type->id,
        'order_status_id' => $status->id,
        'order_action_id' => $action->id,
        'recurrences' => $faker->randomDigitNotNull,
        'service_window' => $faker->randomDigitNotNull,
        'recurring' => $faker->boolean,
        'location' => $faker->word,
        'instructions' => $faker->word,
        'notes' => $faker->word,
        'purchase_order_number' => $faker->word,
        'budget' => (string)$faker->randomDigitNotNull,
        'budget_plus_minus' => $faker->randomDigitNotNull,
        'budget_invoice_number' => $faker->word,
        'bid' => (string)$faker->randomDigitNotNull,
        'bid_plus_minus' => $faker->randomDigitNotNull,
        'invoice_number' => $faker->word,
        'renewable' => $faker->boolean,
        'renewal_count' => $faker->randomDigitNotNull,
        'renewal_date' => $faker->date,
        'notification_lead' => $faker->randomDigitNotNull,
        'renewal_message' => $faker->word,
        'recurring_interval' => ($faker->randomDigitNotNull+1).' days',
        'renewal_interval' => ($faker->randomDigitNotNull+1).' days',
        'progress_percentage' => $faker->randomDigitNotNull,
        'work_days' => (string)$faker->randomDigitNotNull,
        'approver_id' => $contact->id,
        'contact_id' => $contact->id,
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

$factory->define(App\OrderCategory::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});


$factory->define(App\OrderStatus::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\OrderType::class, function (Faker\Generator $faker) {
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


$factory->define(App\BackflowCertification::class, function (Faker\Generator $faker) {
    return [
        'backflow_assembly_id' => $faker->randomDigitNotNull,
        'visual_inspection_notes' => $faker->word,
        'backflow_installation_status_id' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowWaterSystem::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'address' => $faker->word,
        'city' => $faker->word,
        'state' => substr($faker->word,0,2),
        'zip' => $faker->word,
        'phone' => $faker->word,
        'contact' => $faker->word,
        'email' => $faker->word,
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

$factory->define(App\BackflowType::class, function (Faker\Generator $faker) {
    $superType = factory('App\BackflowSuperType')->create();
    return [
        'backflow_super_type_id' => $superType->id,
        'name' => $faker->regexify('\w{4}'),
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowTypeValve::class, function (Faker\Generator $faker) {
    return [
        'backflow_type_id' => $faker->randomDigitNotNull,
        'name' => $faker->word,
        'test_name' => $faker->word,
        'success_label' => $faker->word,
        'fail_label' => $faker->word
    ];
});

$factory->define(App\BackflowSize::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowAssembly::class, function (Faker\Generator $faker) {
    $property = factory('App\Property')->create();
    $contact = factory('App\Contact')->create();
    $type = factory('App\BackflowType')->create();
    $system = factory('App\BackflowWaterSystem')->create();
    $size = factory('App\BackflowSize')->create();
    $manufacturer = factory('App\BackflowManufacturer')->create();
    $model = factory('App\BackflowModel')->create();
    return [
        'property_id' => $property->id,
        'contact_id' => $contact->id,
        'backflow_type_id' => $type->id,
        'backflow_water_system_id' => $system->id,
        'backflow_size_id' => $size->id,
        'backflow_manufacturer_id' => $manufacturer->id,
        'backflow_model_id' => $model->id,
        'use' => $faker->word,
        'placement' => $faker->word,
        'serial_number' => $faker->word,
        'notes' => $faker->word,
        'property_unit_id' => null,
        'active' => true,
        'month' => $faker->randomDigitNotNull,
        'gps' => null,
        'property_account_id' => null,
        'need_access' => false
    ];
});

$factory->define(App\BackflowModel::class, function (Faker\Generator $faker) {
    $manufacturer = factory('App\BackflowManufacturer')->create();
    $type = factory('App\BackflowType')->create();
    return [
        'backflow_manufacturer_id' => $manufacturer->id,
        'backflow_type_id' => $type->id,
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowOld::class, function (Faker\Generator $faker) {
    return [
        'active' => $faker->word,
        'prt' => $faker->word,
        'month' => $faker->word,
        'reference' => $faker->word,
        'water_system' => $faker->word,
        'account' => $faker->word,
        'owner' => $faker->word,
        'contact' => $faker->word,
        'email' => $faker->word,
        'phone' => $faker->word,
        'address' => $faker->word,
        'city' => $faker->word,
        'state' => $faker->word,
        'zip' => $faker->word,
        'location' => $faker->word,
        'laddress' => $faker->word,
        'lcity' => $faker->word,
        'lstate' => $faker->word,
        'lzip' => $faker->word,
        'gps' => $faker->word,
        'use' => $faker->word,
        'placement' => $faker->word,
        'style' => $faker->word,
        'manufacturer' => $faker->word,
        'size' => $faker->word,
        'model' => $faker->word,
        'serial' => $faker->word
    ];
});

$factory->define(App\BackflowValvePart::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowTestReport::class, function (Faker\Generator $faker) {
    $assembly = factory('App\BackflowAssembly')->create();
    return [
        'backflow_assembly_id' => $assembly->id,
        'visual_inspection_notes' => $faker->word,
        'notes' => $faker->text,
        'backflow_installed_to_code' => $faker->boolean,
        'report_date' => date('Y-m-d'),
        'submitted_date' => date('Y-m-d'),
        'tag_year' => $faker->regexify('\d{4}')
    ];
});

$factory->define(App\BackflowValve::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowTest::class, function (Faker\Generator $faker) {
    $report = factory('App\BackflowTestReport')->create();
    $contact = factory('App\Contact')->create();
    return [
        'backflow_test_report_id' => $report->id,
        'contact_id' => $contact->id,
        'reading_1' => sprintf('%.02f',$faker->randomFloat(2,0,2)),
        'reading_2' => sprintf('%.02f',$faker->randomFloat(2,0,2)),
        'passed' => null,
        'tested_on' => date('Y-m-d'),
        'notes' => $faker->text
    ];
});

$factory->define(App\BackflowSuperType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\BackflowRepair::class, function (Faker\Generator $faker) {
    $report = factory('App\BackflowTestReport')->create();
    $contact = factory('App\Contact')->create();
    $valve = factory('App\BackflowValve')->create();
    $part = factory('App\BackflowValvePart')->create();
    return [
        'backflow_test_report_id' => $report->id,
        'contact_id' => $contact->id,
        'backflow_valve_id' => $valve->id,
        'backflow_valve_part_id' => $part->id,
        'repaired_on' => date('Y-m-d')
    ];
});

$factory->define(App\BackflowCleaning::class, function (Faker\Generator $faker) {
    $report = factory('App\BackflowTestReport')->create();
    $contact = factory('App\Contact')->create();
    $valve = factory('App\BackflowValve')->create();
    $part = factory('App\BackflowValvePart')->create();
    return [
        'backflow_test_report_id' => $report->id,
        'contact_id' => $contact->id,
        'backflow_valve_id' => $valve->id,
        'backflow_valve_part_id' => $part->id,
        'cleaned_on' => date('Y-m-d')
    ];
});

$factory->define(App\PropertyUnit::class, function (Faker\Generator $faker) {
    $property = factory('App\Property')->create();
    return [
        'property_id' => $property->id,
        'name' => $faker->word,
        'number' => $faker->word,
        'phone' => $faker->word,
        'notes' => $faker->word
    ];
});

$factory->define(App\IrrigationWaterType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\IrrigationSystem::class, function (Faker\Generator $faker) {
    $property = factory('App\Property')->create();
    $type = factory('App\IrrigationWaterType')->create();
    $backflow = factory('App\BackflowAssembly')->create();
    return [
        'property_id' => $property->id,
        'name' => $faker->word,
        'point_of_connection_location' => $faker->word,
        'irrigation_water_type_id' => $type->id,
        'backflow_assembly_id' => $backflow->id,
        'filter_model' => $faker->word,
        'filter_location' => $faker->word,
        'property_unit_id' => null,
        'notes' => $faker->word
    ];
});

$factory->define(App\IrrigationController::class, function (Faker\Generator $faker) {
    $system = factory('App\IrrigationSystem')->create();
    $location = factory('App\IrrigationControllerLocation')->create();
    return [
        'irrigation_system_id' => $system->id,
        'name' => $faker->word,
        'model' => $faker->word,
        'zones' => $faker->randomDigitNotNull,
        'placement' => $faker->word,
        'irrigation_controller_location_id' => $location->id,
        'property_unit_id' => null,
        'username' => $faker->word,
        'accessible' => $faker->boolean,
        'notes' => $faker->word,
        'password' => $faker->word
    ];
});

$factory->define(App\IrrigationControllerLocation::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\IrrigationSystemOther::class, function (Faker\Generator $faker) {
    $system = factory('App\IrrigationSystem')->create();
    return [
        'irrigation_system_id' => $system->id,
        'name' => $faker->word,
        'value' => $faker->word
    ];
});

$factory->define(App\IrrigationControllerOther::class, function (Faker\Generator $faker) {
    $controller = factory('App\IrrigationController')->create();
    return [
        'irrigation_controller_id' => $controller->id,
        'name' => $faker->word,
        'value' => $faker->word
    ];
});

$factory->define(App\IrrigationZone::class, function (Faker\Generator $faker) {
    $controller = factory('App\IrrigationController')->create();
    return [
        'irrigation_controller_id' => $controller->id,
        'number' => $faker->randomDigitNotNull,
        'name' => $faker->word,
        'plant_type' => $faker->word,
        'head_type' => $faker->word,
        'gallons_per_minute' => $faker->randomDigitNotNull.'.00',
        'application_rate' => $faker->randomDigitNotNull.'.00',
        'heads' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\PropertyAccount::class, function (Faker\Generator $faker) {
    $property = factory('App\Property')->create();
    return [
        'property_id' => $property->id,
        'number' => $faker->word,
        'name' => $faker->word,
        'address' => $faker->word,
        'city' => $faker->word,
        'access_code' => $faker->word,
        'notes' => $faker->word
    ];
});

$factory->define(App\BackflowPicture::class, function (Faker\Generator $faker) {
    $backflow = factory('App\BackflowAssembly')->create();
    return [
        'backflow_assembly_id' => $backflow->id,
        'filename' => $faker->word,
        'original_filename' => $faker->word,
        'notes' => $faker->word
    ];
});

$factory->define(App\ClockIn::class, function (Faker\Generator $faker) {
    $clock_in = $faker->dateTimeBetween('-30 days');
    $clock_out = clone $clock_in;
    $clock_out->modify('+8 hours');
    $contact = factory(App\Contact::class)->create();
    return [
        'contact_id' => $contact->id,
        'clock_in' => $clock_in->format('Y-m-d H:i:s'),
        'clock_out' => $clock_out->format('Y-m-d H:i:s'),
        'notes' => $faker->text,
        'creator_id' => $contact->id,
        'updater_id' => $contact->id
    ];
});

$factory->define(App\OverheadAssignment::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'parent_id' => null,
        'sort_order' => $faker->randomDigitNotNull,
    ];
});

$factory->define(App\OverheadCategory::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'parent_id' => null,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\AssetType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\AssetUsageType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});


$factory->define(App\AssetPart::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'on_hand' => $faker->randomDigitNotNull,
        'notes' => $faker->text
    ];
});

$factory->define(App\AssetServiceType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'notes' => $faker->text,
        'sort_order' => $faker->randomDigitNotNull
    ];
});

$factory->define(App\AssetService::class, function (Faker\Generator $faker) {
    $asset = factory(App\Asset::class)->create();
    $asset_service_type = factory(App\AssetServiceType::class)->create();
    $asset_usage_type = factory(App\AssetUsageType::class)->create();
    return [
        'asset_id' => $asset->id,
        'asset_service_type_id' => $asset_service_type->id,
        'description' => $faker->text,
        'quantity' => $faker->randomDigitNotNull,
        'asset_usage_type_id' => $asset_usage_type->id,
        'usage_interval' => $faker->randomDigitNotNull,
        'part_number' => $faker->word,
        'notes' => $faker->text,
        'time_interval' => ($faker->randomDigitNotNull + 1) . ' mons'
    ];
});

$factory->define(App\AssetFueling::class, function (Faker\Generator $faker) {
    $asset = factory(App\Asset::class)->create();
    $asset_usage_type = factory(App\AssetUsageType::class)->create();
    return [
        'asset_id' => $asset->id,
        'asset_usage_type_id' => $asset_usage_type->id,
        'usage' => $faker->randomDigitNotNull,
        'date' => $faker->date,
        'gallons' => $faker->randomFloat."",
        'amount' => $faker->randomFloat."",
        'notes' => $faker->text
    ];
});

$factory->define(App\Asset::class, function (Faker\Generator $faker) {
    $asset_type = factory(App\AssetType::class)->create();
    $asset_usage_type = factory(App\AssetUsageType::class)->create();
    return [
        'name' => $faker->word,
        'asset_type_id' => $asset_type->id,
        'asset_usage_type_id' => $asset_usage_type->id,
        'year' => $faker->randomDigitNotNull,
        'make' => $faker->word,
        'model' => $faker->word,
        'trim' => $faker->word,
        'vin' => $faker->word,
        'parent_asset_id' => $faker->randomDigitNotNull,
        'notes' => $faker->text
    ];
});

$factory->define(App\AssetRepair::class, function (Faker\Generator $faker) {
    $asset = factory(App\Asset::class)->create();
    $asset_usage_type = factory(App\AssetUsageType::class)->create();
    return [
        'asset_id' => $asset->id,
        'asset_usage_type_id' => $asset_usage_type->id,
        'usage' => $faker->randomDigitNotNull,
        'repair' => $faker->word,
        'date' => $faker->date,
        'amount' => $faker->randomFloat."",
        'where' => $faker->word,
        'notes' => $faker->text
    ];
});

$factory->define(App\AssetMaintenance::class, function (Faker\Generator $faker) {
    $asset_service = factory(App\AssetService::class)->create();
    $asset_usage_type = factory(App\AssetUsageType::class)->create();
    return [
        'asset_service_id' => $asset_service->id,
        'asset_usage_type_id' => $asset_usage_type->id,
        'usage' => $faker->randomDigitNotNull,
        'date' => $faker->date,
        'amount' => $faker->randomFloat."",
        'where' => $faker->word,
        'notes' => $faker->text
    ];
});
