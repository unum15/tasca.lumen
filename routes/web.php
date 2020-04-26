<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return 'Tasca API 1.0';
});

$router->post('/auth', 'AuthController@auth');
$router->post('/unauth', 'AuthController@unauth');
$router->get('/status', 'AuthController@status');

$router->get('/activity_levels', 'ActivityLevelController@index');
$router->post('/activity_level', 'ActivityLevelController@create');
$router->get('/activity_level/{id:[0-9]+}', 'ActivityLevelController@read');
$router->patch('/activity_level/{id:[0-9]+}', 'ActivityLevelController@update');
$router->delete('/activity_level/{id:[0-9]+}', 'ActivityLevelController@delete');

$router->get('/client_types', 'ClientTypeController@index');
$router->post('/client_type', 'ClientTypeController@create');
$router->get('/client_type/{id:[0-9]+}', 'ClientTypeController@read');
$router->patch('/client_type/{id:[0-9]+}', 'ClientTypeController@update');
$router->delete('/client_type/{id:[0-9]+}', 'ClientTypeController@delete');

$router->get('/contact_methods', 'ContactMethodController@index');
$router->post('/contact_method', 'ContactMethodController@create');
$router->get('/contact_method/{id:[0-9]+}', 'ContactMethodController@read');
$router->patch('/contact_method/{id:[0-9]+}', 'ContactMethodController@update');
$router->delete('/contact_method/{id:[0-9]+}', 'ContactMethodController@delete');

$router->get('/contact_types', 'ContactTypeController@index');
$router->post('/contact_type', 'ContactTypeController@create');
$router->get('/contact_type/{id:[0-9]+}', 'ContactTypeController@read');
$router->patch('/contact_type/{id:[0-9]+}', 'ContactTypeController@update');
$router->delete('/contact_type/{id:[0-9]+}', 'ContactTypeController@delete');

$router->get('/crews', 'CrewController@index');
$router->post('/crew', 'CrewController@create');
$router->get('/crew/{id:[0-9]+}', 'CrewController@read');
$router->patch('/crew/{id:[0-9]+}', 'CrewController@update');
$router->delete('/crew/{id:[0-9]+}', 'CrewController@delete');

$router->get('/email_types', 'EmailTypeController@index');
$router->post('/email_type', 'EmailTypeController@create');
$router->get('/email_type/{id:[0-9]+}', 'EmailTypeController@read');
$router->patch('/email_type/{id:[0-9]+}', 'EmailTypeController@update');
$router->delete('/email_type/{id:[0-9]+}', 'EmailTypeController@delete');

$router->get('/phone_number_types', 'PhoneNumberTypeController@index');
$router->post('/phone_number_type', 'PhoneNumberTypeController@create');
$router->get('/phone_number_type/{id:[0-9]+}', 'PhoneNumberTypeController@read');
$router->patch('/phone_number_type/{id:[0-9]+}', 'PhoneNumberTypeController@update');
$router->delete('/phone_number_type/{id:[0-9]+}', 'PhoneNumberTypeController@delete');

$router->get('/property_types', 'PropertyTypeController@index');
$router->post('/property_type', 'PropertyTypeController@create');
$router->get('/property_type/{id:[0-9]+}', 'PropertyTypeController@read');
$router->patch('/property_type/{id:[0-9]+}', 'PropertyTypeController@update');
$router->delete('/property_type/{id:[0-9]+}', 'PropertyTypeController@delete');

$router->get('/order_actions', 'OrderActionController@index');
$router->post('/order_action', 'OrderActionController@create');
$router->get('/order_action/{id:[0-9]+}', 'OrderActionController@read');
$router->patch('/order_action/{id:[0-9]+}', 'OrderActionController@update');
$router->delete('/order_action/{id:[0-9]+}', 'OrderActionController@delete');

$router->get('/order_priorities', 'OrderPriorityController@index');
$router->post('/order_priority', 'OrderPriorityController@create');
$router->get('/order_priority/{id:[0-9]+}', 'OrderPriorityController@read');
$router->patch('/order_priority/{id:[0-9]+}', 'OrderPriorityController@update');
$router->delete('/order_priority/{id:[0-9]+}', 'OrderPriorityController@delete');

$router->get('/order_categories', 'OrderCategoryController@index');
$router->post('/order_category', 'OrderCategoryController@create');
$router->get('/order_category/{id:[0-9]+}', 'OrderCategoryController@read');
$router->patch('/order_category/{id:[0-9]+}', 'OrderCategoryController@update');
$router->delete('/order_category/{id:[0-9]+}', 'OrderCategoryController@delete');

$router->get('/order_statuses', 'OrderStatusController@index');
$router->post('/order_status', 'OrderStatusController@create');
$router->get('/order_status/{id:[0-9]+}', 'OrderStatusController@read');
$router->patch('/order_status/{id:[0-9]+}', 'OrderStatusController@update');
$router->delete('/order_status/{id:[0-9]+}', 'OrderStatusController@delete');

$router->get('/order_status_types', 'OrderStatusTypeController@index');
$router->post('/order_status_type', 'OrderStatusTypeController@create');
$router->get('/order_status_type/{id:[0-9]+}', 'OrderStatusTypeController@read');
$router->patch('/order_status_type/{id:[0-9]+}', 'OrderStatusTypeController@update');
$router->delete('/order_status_type/{id:[0-9]+}', 'OrderStatusTypeController@delete');

$router->get('/order_types', 'OrderTypeController@index');
$router->post('/order_type', 'OrderTypeController@create');
$router->get('/order_type/{id:[0-9]+}', 'OrderTypeController@read');
$router->patch('/order_type/{id:[0-9]+}', 'OrderTypeController@update');
$router->delete('/order_type/{id:[0-9]+}', 'OrderTypeController@delete');

$router->get('/task_actions', 'TaskActionController@index');
$router->post('/task_action', 'TaskActionController@create');
$router->get('/task_action/{id:[0-9]+}', 'TaskActionController@read');
$router->patch('/task_action/{id:[0-9]+}', 'TaskActionController@update');
$router->delete('/task_action/{id:[0-9]+}', 'TaskActionController@delete');

$router->get('/task_statuses', 'TaskStatusController@index');
$router->post('/task_status', 'TaskStatusController@create');
$router->get('/task_status/{id:[0-9]+}', 'TaskStatusController@read');
$router->patch('/task_status/{id:[0-9]+}', 'TaskStatusController@update');
$router->delete('/task_status/{id:[0-9]+}', 'TaskStatusController@delete');

$router->get('/appointment_statuses', 'AppointmentStatusController@index');
$router->post('/appointment_status', 'AppointmentStatusController@create');
$router->get('/appointment_status/{id:[0-9]+}', 'AppointmentStatusController@read');
$router->patch('/appointment_status/{id:[0-9]+}', 'AppointmentStatusController@update');
$router->delete('/appointment_status/{id:[0-9]+}', 'AppointmentStatusController@delete');

$router->get('/task_categories', 'TaskCategoryController@index');
$router->post('/task_category', 'TaskCategoryController@create');
$router->get('/task_category/{id:[0-9]+}', 'TaskCategoryController@read');
$router->patch('/task_category/{id:[0-9]+}', 'TaskCategoryController@update');
$router->delete('/task_category/{id:[0-9]+}', 'TaskCategoryController@delete');

$router->get('/task_types', 'TaskTypeController@index');
$router->post('/task_type', 'TaskTypeController@create');
$router->get('/task_type/{id:[0-9]+}', 'TaskTypeController@read');
$router->patch('/task_type/{id:[0-9]+}', 'TaskTypeController@update');
$router->delete('/task_type/{id:[0-9]+}', 'TaskTypeController@delete');

$router->get('/work_types', 'WorkTypeController@index');
$router->post('/work_type', 'WorkTypeController@create');
$router->get('/work_type/{id:[0-9]+}', 'WorkTypeController@read');
$router->patch('/work_type/{id:[0-9]+}', 'WorkTypeController@update');
$router->delete('/work_type/{id:[0-9]+}', 'WorkTypeController@delete');

$router->get('/clients', 'ClientController@index');
$router->post('/client', 'ClientController@create');
$router->get('/client/{id:[0-9]+}', 'ClientController@read');
$router->patch('/client/{id:[0-9]+}', 'ClientController@update');
$router->delete('/client/{id:[0-9]+}', 'ClientController@delete');

$router->get('/contacts', 'ContactController@index');
$router->post('/contact', 'ContactController@create');
$router->get('/contact/{id:[0-9]+}', 'ContactController@read');
$router->patch('/contact/{id:[0-9]+}', 'ContactController@update');
$router->delete('/contact/{id:[0-9]+}', 'ContactController@delete');

$router->get('/emails', 'EmailController@index');
$router->post('/email', 'EmailController@create');
$router->get('/email/{id:[0-9]+}', 'EmailController@read');
$router->patch('/email/{id:[0-9]+}', 'EmailController@update');
$router->delete('/email/{id:[0-9]+}', 'EmailController@delete');

$router->get('/phone_numbers', 'PhoneNumberController@index');
$router->post('/phone_number', 'PhoneNumberController@create');
$router->get('/phone_number/{id:[0-9]+}', 'PhoneNumberController@read');
$router->patch('/phone_number/{id:[0-9]+}', 'PhoneNumberController@update');
$router->delete('/phone_number/{id:[0-9]+}', 'PhoneNumberController@delete');

$router->get('/projects', 'ProjectController@index');
$router->post('/project', 'ProjectController@create');
$router->get('/project/{id:[0-9]+}', 'ProjectController@read');
$router->patch('/project/{id:[0-9]+}', 'ProjectController@update');
$router->delete('/project/{id:[0-9]+}', 'ProjectController@delete');

$router->get('/properties', 'PropertyController@index');
$router->post('/property', 'PropertyController@create');
$router->get('/property/{id:[0-9]+}', 'PropertyController@read');
$router->patch('/property/{id:[0-9]+}', 'PropertyController@update');
$router->delete('/property/{id:[0-9]+}', 'PropertyController@delete');

$router->get('/orders', 'OrderController@index');
$router->post('/order', 'OrderController@create');
$router->post('/order/convert/{id:[0-9]+}', 'OrderController@convert');
$router->get('/order/{id:[0-9]+}', 'OrderController@read');
$router->patch('/order/{id:[0-9]+}', 'OrderController@update');
$router->delete('/order/{id:[0-9]+}', 'OrderController@delete');

$router->get('/tasks', 'TaskController@index');
$router->post('/task', 'TaskController@create');
$router->get('/task/{id:[0-9]+}', 'TaskController@read');
$router->patch('/task/{id:[0-9]+}', 'TaskController@update');
$router->delete('/task/{id:[0-9]+}', 'TaskController@delete');

$router->get('/task_dates', 'TaskDateController@index');
$router->get('/schedule', 'TaskDateController@schedule');
$router->post('/task_date', 'TaskDateController@create');
$router->get('/task_date/{id:[0-9]+}', 'TaskDateController@read');
$router->patch('/task_date/{id:[0-9]+}', 'TaskDateController@update');
$router->delete('/task_date/{id:[0-9]+}', 'TaskDateController@delete');

$router->get('/sign_ins', 'SignInController@index');
$router->get('/sign_ins/by_employee', 'SignInController@by_employee');
$router->post('/sign_in', 'SignInController@create');
$router->get('/sign_in/{id:[0-9]+}', 'SignInController@read');
$router->patch('/sign_in/{id:[0-9]+}', 'SignInController@update');
$router->delete('/sign_in/{id:[0-9]+}', 'SignInController@delete');


$router->get('/settings', 'SettingController@index');
$router->patch('/settings', 'SettingController@update');

$router->get('/calendar/status', 'GoogleCalendarController@status');
$router->get('/calendar/url', 'GoogleCalendarController@url');
$router->post('/calendar/callback', 'GoogleCalendarController@callback');


$router->get('/vehicles', ['uses' => 'VehicleController@index', 'as' => 'vehicle.index']);
$router->post('/vehicle', ['uses' => 'VehicleController@create', 'as' => 'vehicle.create']);
$router->get('/vehicle/{id:[0-9]+}', ['uses' => 'VehicleController@read', 'as' => 'vehicle.read']);
$router->patch('/vehicle/{id:[0-9]+}', ['uses' => 'VehicleController@update', 'as' => 'vehicle.update']);
$router->delete('/vehicle/{id:[0-9]+}', ['uses' => 'VehicleController@delete', 'as' => 'vehicle.delete']);

$router->get('/vehicle_types', ['uses' => 'VehicleTypeController@index', 'as' => 'vehicle_type.index']);
$router->post('/vehicle_type', ['uses' => 'VehicleTypeController@create', 'as' => 'vehicle_type.create']);
$router->get('/vehicle_type/{id:[0-9]+}', ['uses' => 'VehicleTypeController@read', 'as' => 'vehicle_type.read']);
$router->patch('/vehicle_type/{id:[0-9]+}', ['uses' => 'VehicleTypeController@update', 'as' => 'vehicle_type.update']);
$router->delete('/vehicle_type/{id:[0-9]+}', ['uses' => 'VehicleTypeController@delete', 'as' => 'vehicle_type.delete']);

$router->get('/fuelings', ['uses' => 'FuelingController@index', 'as' => 'fueling.index']);
$router->post('/fueling', ['uses' => 'FuelingController@create', 'as' => 'fueling.create']);
$router->get('/fueling/{id:[0-9]+}', ['uses' => 'FuelingController@read', 'as' => 'fueling.read']);
$router->patch('/fueling/{id:[0-9]+}', ['uses' => 'FuelingController@update', 'as' => 'fueling.update']);
$router->delete('/fueling/{id:[0-9]+}', ['uses' => 'FuelingController@delete', 'as' => 'fueling.delete']);

$router->get('/parts', ['uses' => 'PartController@index', 'as' => 'part.index']);
$router->post('/part', ['uses' => 'PartController@create', 'as' => 'part.create']);
$router->get('/part/{id:[0-9]+}', ['uses' => 'PartController@read', 'as' => 'part.read']);
$router->patch('/part/{id:[0-9]+}', ['uses' => 'PartController@update', 'as' => 'part.update']);
$router->delete('/part/{id:[0-9]+}', ['uses' => 'PartController@delete', 'as' => 'part.delete']);

$router->get('/repairs', ['uses' => 'RepairController@index', 'as' => 'repair.index']);
$router->post('/repair', ['uses' => 'RepairController@create', 'as' => 'repair.create']);
$router->get('/repair/{id:[0-9]+}', ['uses' => 'RepairController@read', 'as' => 'repair.read']);
$router->patch('/repair/{id:[0-9]+}', ['uses' => 'RepairController@update', 'as' => 'repair.update']);
$router->delete('/repair/{id:[0-9]+}', ['uses' => 'RepairController@delete', 'as' => 'repair.delete']);

$router->get('/service_types', ['uses' => 'ServiceTypeController@index', 'as' => 'service_type.index']);
$router->post('/service_type', ['uses' => 'ServiceTypeController@create', 'as' => 'service_type.create']);
$router->get('/service_type/{id:[0-9]+}', ['uses' => 'ServiceTypeController@read', 'as' => 'service_type.read']);
$router->patch('/service_type/{id:[0-9]+}', ['uses' => 'ServiceTypeController@update', 'as' => 'service_type.update']);
$router->delete('/service_type/{id:[0-9]+}', ['uses' => 'ServiceTypeController@delete', 'as' => 'service_type.delete']);

$router->get('/services', ['uses' => 'ServiceController@index', 'as' => 'service.index']);
$router->post('/service', ['uses' => 'ServiceController@create', 'as' => 'service.create']);
$router->get('/service/{id:[0-9]+}', ['uses' => 'ServiceController@read', 'as' => 'service.read']);
$router->patch('/service/{id:[0-9]+}', ['uses' => 'ServiceController@update', 'as' => 'service.update']);
$router->delete('/service/{id:[0-9]+}', ['uses' => 'ServiceController@delete', 'as' => 'service.delete']);

$router->get('/usage_types', ['uses' => 'UsageTypeController@index', 'as' => 'usage_type.index']);
$router->post('/usage_type', ['uses' => 'UsageTypeController@create', 'as' => 'usage_type.create']);
$router->get('/usage_type/{id:[0-9]+}', ['uses' => 'UsageTypeController@read', 'as' => 'usage_type.read']);
$router->patch('/usage_type/{id:[0-9]+}', ['uses' => 'UsageTypeController@update', 'as' => 'usage_type.update']);
$router->delete('/usage_type/{id:[0-9]+}', ['uses' => 'UsageTypeController@delete', 'as' => 'usage_type.delete']);

$router->get('/maintenances', ['uses' => 'MaintenanceController@index', 'as' => 'maintenance.index']);
$router->post('/maintenance', ['uses' => 'MaintenanceController@create', 'as' => 'maintenance.create']);
$router->get('/maintenance/{id:[0-9]+}', ['uses' => 'MaintenanceController@read', 'as' => 'maintenance.read']);
$router->patch('/maintenance/{id:[0-9]+}', ['uses' => 'MaintenanceController@update', 'as' => 'maintenance.update']);
$router->delete('/maintenance/{id:[0-9]+}', ['uses' => 'MaintenanceController@delete', 'as' => 'maintenance.delete']);

$router->get('/backflow_valve_parts', ['uses' => 'BackflowValvePartController@index', 'as' => 'backflow_valve_part.index']);
$router->post('/backflow_valve_part', ['uses' => 'BackflowValvePartController@create', 'as' => 'backflow_valve_part.create']);
$router->get('/backflow_valve_part/{id:[0-9]+}', ['uses' => 'BackflowValvePartController@read', 'as' => 'backflow_valve_part.read']);
$router->patch('/backflow_valve_part/{id:[0-9]+}', ['uses' => 'BackflowValvePartController@update', 'as' => 'backflow_valve_part.update']);
$router->delete('/backflow_valve_part/{id:[0-9]+}', ['uses' => 'BackflowValvePartController@delete', 'as' => 'backflow_valve_part.delete']);

$router->get('/backflow_water_systems', ['uses' => 'BackflowWaterSystemController@index', 'as' => 'backflow_water_system.index']);
$router->post('/backflow_water_system', ['uses' => 'BackflowWaterSystemController@create', 'as' => 'backflow_water_system.create']);
$router->get('/backflow_water_system/{id:[0-9]+}', ['uses' => 'BackflowWaterSystemController@read', 'as' => 'backflow_water_system.read']);
$router->patch('/backflow_water_system/{id:[0-9]+}', ['uses' => 'BackflowWaterSystemController@update', 'as' => 'backflow_water_system.update']);
$router->delete('/backflow_water_system/{id:[0-9]+}', ['uses' => 'BackflowWaterSystemController@delete', 'as' => 'backflow_water_system.delete']);

$router->get('/backflow_manufacturers', ['uses' => 'BackflowManufacturerController@index', 'as' => 'backflow_manufacturer.index']);
$router->post('/backflow_manufacturer', ['uses' => 'BackflowManufacturerController@create', 'as' => 'backflow_manufacturer.create']);
$router->get('/backflow_manufacturer/{id:[0-9]+}', ['uses' => 'BackflowManufacturerController@read', 'as' => 'backflow_manufacturer.read']);
$router->patch('/backflow_manufacturer/{id:[0-9]+}', ['uses' => 'BackflowManufacturerController@update', 'as' => 'backflow_manufacturer.update']);
$router->delete('/backflow_manufacturer/{id:[0-9]+}', ['uses' => 'BackflowManufacturerController@delete', 'as' => 'backflow_manufacturer.delete']);

$router->get('/backflow_models', ['uses' => 'BackflowModelController@index', 'as' => 'backflow_model.index']);
$router->post('/backflow_model', ['uses' => 'BackflowModelController@create', 'as' => 'backflow_model.create']);
$router->get('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@read', 'as' => 'backflow_model.read']);
$router->patch('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@update', 'as' => 'backflow_model.update']);
$router->delete('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@delete', 'as' => 'backflow_model.delete']);

$router->get('/backflow_types', ['uses' => 'BackflowTypeController@index', 'as' => 'backflow_type.index']);
$router->post('/backflow_type', ['uses' => 'BackflowTypeController@create', 'as' => 'backflow_type.create']);
$router->get('/backflow_type/{id:[0-9]+}', ['uses' => 'BackflowTypeController@read', 'as' => 'backflow_type.read']);
$router->patch('/backflow_type/{id:[0-9]+}', ['uses' => 'BackflowTypeController@update', 'as' => 'backflow_type.update']);
$router->delete('/backflow_type/{id:[0-9]+}', ['uses' => 'BackflowTypeController@delete', 'as' => 'backflow_type.delete']);

$router->get('/backflow_assemblies', ['uses' => 'BackflowAssemblyController@index', 'as' => 'backflow_assembly.index']);
$router->post('/backflow_assembly', ['uses' => 'BackflowAssemblyController@create', 'as' => 'backflow_assembly.create']);
$router->get('/backflow_assembly/{id:[0-9]+}', ['uses' => 'BackflowAssemblyController@read', 'as' => 'backflow_assembly.read']);
$router->patch('/backflow_assembly/{id:[0-9]+}', ['uses' => 'BackflowAssemblyController@update', 'as' => 'backflow_assembly.update']);
$router->delete('/backflow_assembly/{id:[0-9]+}', ['uses' => 'BackflowAssemblyController@delete', 'as' => 'backflow_assembly.delete']);
$router->get('/backflow_assembly/unique/{field:\w+}', ['uses' => 'BackflowAssemblyController@unique', 'as' => 'backflow_assembly.unique']);
$router->get('/backflow_assemblies/tags/pdf', ['uses' => 'BackflowAssemblyController@tagsPdf', 'as' => 'backflow_assembly.tags_pdf']);

$router->get('/backflow_sizes', ['uses' => 'BackflowSizeController@index', 'as' => 'backflow_size.index']);
$router->post('/backflow_size', ['uses' => 'BackflowSizeController@create', 'as' => 'backflow_size.create']);
$router->get('/backflow_size/{id:[0-9]+}', ['uses' => 'BackflowSizeController@read', 'as' => 'backflow_size.read']);
$router->patch('/backflow_size/{id:[0-9]+}', ['uses' => 'BackflowSizeController@update', 'as' => 'backflow_size.update']);
$router->delete('/backflow_size/{id:[0-9]+}', ['uses' => 'BackflowSizeController@delete', 'as' => 'backflow_size.delete']);

$router->get('/backflow_old', ['uses' => 'BackflowOldController@index', 'as' => 'backflow_old.index']);
$router->post('/backflow_old', ['uses' => 'BackflowOldController@create', 'as' => 'backflow_old.create']);
$router->get('/backflow_old/{id:[0-9]+}', ['uses' => 'BackflowOldController@read', 'as' => 'backflow_old.read']);
$router->patch('/backflow_old/{id:[0-9]+}', ['uses' => 'BackflowOldController@update', 'as' => 'backflow_old.update']);
$router->delete('/backflow_old/{id:[0-9]+}', ['uses' => 'BackflowOldController@delete', 'as' => 'backflow_old.delete']);
$router->get('/backflow_old/zips', ['uses' => 'BackflowOldController@zips', 'as' => 'backflow_old.zips']);
$router->get('/backflow_old/groups', ['uses' => 'BackflowOldController@groups', 'as' => 'backflow_old.groups']);
$router->post('/backflow_old/export/{id:[0-9]+}', ['uses' => 'BackflowOldController@export', 'as' => 'backflow_old.export']);
$router->post('/backflow_old/export/client/{id:[0-9]+}', ['uses' => 'BackflowOldController@exportClient', 'as' => 'backflow_old.export_client']);
$router->post('/backflow_old/export/property/{id:[0-9]+}', ['uses' => 'BackflowOldController@exportProperty', 'as' => 'backflow_old.export_property']);

$router->get('/backflow_models', ['uses' => 'BackflowModelController@index', 'as' => 'backflow_model.index']);
$router->post('/backflow_model', ['uses' => 'BackflowModelController@create', 'as' => 'backflow_model.create']);
$router->get('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@read', 'as' => 'backflow_model.read']);
$router->patch('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@update', 'as' => 'backflow_model.update']);
$router->delete('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@delete', 'as' => 'backflow_model.delete']);

$router->get('/backflow_test_reports', ['uses' => 'BackflowTestReportController@index', 'as' => 'backflow_test_report.index']);
$router->post('/backflow_test_report', ['uses' => 'BackflowTestReportController@create', 'as' => 'backflow_test_report.create']);
$router->get('/backflow_test_report/{id:[0-9]+}', ['uses' => 'BackflowTestReportController@read', 'as' => 'backflow_test_report.read']);
$router->patch('/backflow_test_report/{id:[0-9]+}', ['uses' => 'BackflowTestReportController@update', 'as' => 'backflow_test_report.update']);
$router->delete('/backflow_test_report/{id:[0-9]+}', ['uses' => 'BackflowTestReportController@delete', 'as' => 'backflow_test_report.delete']);
$router->get('/backflow_test_report/{id:[0-9]+}/pdf', ['uses' => 'BackflowTestReportController@pdf', 'as' => 'backflow_test_report.pdf']);
$router->get('/backflow_test_report/{id:[0-9]+}/html', ['uses' => 'BackflowTestReportController@html', 'as' => 'backflow_test_report.html']);
$router->get('/backflow_test_reports/pdf', ['uses' => 'BackflowTestReportController@pdfs', 'as' => 'backflow_test_report.pdfs']);
$router->get('/backflow_test_reports/html', ['uses' => 'BackflowTestReportController@htmls', 'as' => 'backflow_test_report.htmls']);

$router->put('/backflow_test_report/{id:[0-9]+}/repairs', ['uses' => 'BackflowTestReportController@updateRepairs', 'as' => 'backflow_test_report.update_repairs']);
$router->put('/backflow_test_report/{id:[0-9]+}/cleanings', ['uses' => 'BackflowTestReportController@updateCleanings', 'as' => 'backflow_test_report.update_cleanings']);

$router->get('/backflow_valves', ['uses' => 'BackflowValveController@index', 'as' => 'backflow_valve.index']);
$router->post('/backflow_valve', ['uses' => 'BackflowValveController@create', 'as' => 'backflow_valve.create']);
$router->get('/backflow_valve/{id:[0-9]+}', ['uses' => 'BackflowValveController@read', 'as' => 'backflow_valve.read']);
$router->patch('/backflow_valve/{id:[0-9]+}', ['uses' => 'BackflowValveController@update', 'as' => 'backflow_valve.update']);
$router->delete('/backflow_valve/{id:[0-9]+}', ['uses' => 'BackflowValveController@delete', 'as' => 'backflow_valve.delete']);

$router->get('/backflow_tests', ['uses' => 'BackflowTestController@index', 'as' => 'backflow_test.index']);
$router->post('/backflow_test', ['uses' => 'BackflowTestController@create', 'as' => 'backflow_test.create']);
$router->get('/backflow_test/{id:[0-9]+}', ['uses' => 'BackflowTestController@read', 'as' => 'backflow_test.read']);
$router->patch('/backflow_test/{id:[0-9]+}', ['uses' => 'BackflowTestController@update', 'as' => 'backflow_test.update']);
$router->delete('/backflow_test/{id:[0-9]+}', ['uses' => 'BackflowTestController@delete', 'as' => 'backflow_test.delete']);

$router->get('/backflow_super_types', ['uses' => 'BackflowSuperTypeController@index', 'as' => 'backflow_super_type.index']);
$router->post('/backflow_super_type', ['uses' => 'BackflowSuperTypeController@create', 'as' => 'backflow_super_type.create']);
$router->get('/backflow_super_type/{id:[0-9]+}', ['uses' => 'BackflowSuperTypeController@read', 'as' => 'backflow_super_type.read']);
$router->patch('/backflow_super_type/{id:[0-9]+}', ['uses' => 'BackflowSuperTypeController@update', 'as' => 'backflow_super_type.update']);
$router->delete('/backflow_super_type/{id:[0-9]+}', ['uses' => 'BackflowSuperTypeController@delete', 'as' => 'backflow_super_type.delete']);

$router->get('/backflow_cleanings', ['uses' => 'BackflowCleaningController@index', 'as' => 'backflow_cleaning.index']);
$router->post('/backflow_cleaning', ['uses' => 'BackflowCleaningController@create', 'as' => 'backflow_cleaning.create']);
$router->get('/backflow_cleaning/{id:[0-9]+}', ['uses' => 'BackflowCleaningController@read', 'as' => 'backflow_cleaning.read']);
$router->patch('/backflow_cleaning/{id:[0-9]+}', ['uses' => 'BackflowCleaningController@update', 'as' => 'backflow_cleaning.update']);
$router->delete('/backflow_cleaning/{id:[0-9]+}', ['uses' => 'BackflowCleaningController@delete', 'as' => 'backflow_cleaning.delete']);

$router->get('/backflow_repairs', ['uses' => 'BackflowRepairController@index', 'as' => 'backflow_repair.index']);
$router->post('/backflow_repair', ['uses' => 'BackflowRepairController@create', 'as' => 'backflow_repair.create']);
$router->get('/backflow_repair/{id:[0-9]+}', ['uses' => 'BackflowRepairController@read', 'as' => 'backflow_repair.read']);
$router->patch('/backflow_repair/{id:[0-9]+}', ['uses' => 'BackflowRepairController@update', 'as' => 'backflow_repair.update']);
$router->delete('/backflow_repair/{id:[0-9]+}', ['uses' => 'BackflowRepairController@delete', 'as' => 'backflow_repair.delete']);

$router->get('/property_units', ['uses' => 'PropertyUnitController@index', 'as' => 'property_unit.index']);
$router->post('/property_unit', ['uses' => 'PropertyUnitController@create', 'as' => 'property_unit.create']);
$router->get('/property_unit/{id:[0-9]+}', ['uses' => 'PropertyUnitController@read', 'as' => 'property_unit.read']);
$router->patch('/property_unit/{id:[0-9]+}', ['uses' => 'PropertyUnitController@update', 'as' => 'property_unit.update']);
$router->delete('/property_unit/{id:[0-9]+}', ['uses' => 'PropertyUnitController@delete', 'as' => 'property_unit.delete']);

$router->get('/phree_books/contacts', 'PhreeBooksController@contacts');
$router->get('/phree_books/addresses', 'PhreeBooksController@addresses');
$router->get('/phree_books/matches', 'PhreeBooksController@matches');
$router->get('/phree_books/tasca', 'PhreeBooksController@tasca');
$router->get('/phree_books/phree_books', 'PhreeBooksController@phreeBooks');

$router->get('/phree_books/clients', 'PhreeBooksController@clients');
$router->post('/phree_books/client/{id:[0-9]+}', 'PhreeBooksController@createClient');
$router->patch('/phree_books/client/{id:[0-9]+}/match', 'PhreeBooksController@matchClient');
$router->post('/phree_books/contact/{id:[0-9]+}', 'PhreeBooksController@createContact');
$router->post('/phree_books/property/{id:[0-9]+}', 'PhreeBooksController@createProperty');
$router->put('/phree_books/client/{id:[0-9]+}', 'PhreeBooksController@updateClient');
$router->put('/phree_books/contact/{id:[0-9]+}', 'PhreeBooksController@updateContact');
$router->put('/phree_books/property/{id:[0-9]+}', 'PhreeBooksController@updateProperty');


$router->get('/clock_ins', ['uses' => 'ClockInController@index', 'as' => 'clock_in.index']);
$router->post('/clock_in', ['uses' => 'ClockInController@create', 'as' => 'clock_in.create']);
$router->get('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@read', 'as' => 'clock_in.read']);
$router->patch('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@update', 'as' => 'clock_in.update']);
$router->delete('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@delete', 'as' => 'clock_in.delete']);