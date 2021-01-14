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
$router->get('/auth/password/reset', ['uses' => 'AuthController@passwordReset', 'as' => 'password.reset']);
$router->post('/auth/password/email', 'AuthController@sendResetLinkEmail');
$router->post('/auth/password/reset', 'AuthController@reset');

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
$router->post('/contact/{id:[0-9]+}/account', 'ContactController@createAccount');
$router->put('/contact/{id:[0-9]+}/roles', 'ContactController@updateRoles');
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
$router->get('/orders/closable', 'OrderController@closable');

$router->get('/tasks', 'TaskController@index');
$router->post('/task', 'TaskController@create');
$router->get('/task/{id:[0-9]+}', 'TaskController@read');
$router->patch('/task/{id:[0-9]+}', 'TaskController@update');
$router->delete('/task/{id:[0-9]+}', 'TaskController@delete');

$router->get('/settings', 'SettingController@index');
$router->patch('/settings', 'SettingController@update');

$router->get('/calendar/status', 'GoogleCalendarController@status');
$router->get('/calendar/url', 'GoogleCalendarController@url');
$router->post('/calendar/callback', 'GoogleCalendarController@callback');

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

$router->get('/irrigation_water_types', ['uses' => 'IrrigationWaterTypeController@index', 'as' => 'irrigation_water_type.index']);
$router->post('/irrigation_water_type', ['uses' => 'IrrigationWaterTypeController@create', 'as' => 'irrigation_water_type.create']);
$router->get('/irrigation_water_type/{id:[0-9]+}', ['uses' => 'IrrigationWaterTypeController@read', 'as' => 'irrigation_water_type.read']);
$router->patch('/irrigation_water_type/{id:[0-9]+}', ['uses' => 'IrrigationWaterTypeController@update', 'as' => 'irrigation_water_type.update']);
$router->delete('/irrigation_water_type/{id:[0-9]+}', ['uses' => 'IrrigationWaterTypeController@delete', 'as' => 'irrigation_water_type.delete']);

$router->get('/irrigation_systems', ['uses' => 'IrrigationSystemController@index', 'as' => 'irrigation_system.index']);
$router->post('/irrigation_system', ['uses' => 'IrrigationSystemController@create', 'as' => 'irrigation_system.create']);
$router->get('/irrigation_system/{id:[0-9]+}', ['uses' => 'IrrigationSystemController@read', 'as' => 'irrigation_system.read']);
$router->patch('/irrigation_system/{id:[0-9]+}', ['uses' => 'IrrigationSystemController@update', 'as' => 'irrigation_system.update']);
$router->delete('/irrigation_system/{id:[0-9]+}', ['uses' => 'IrrigationSystemController@delete', 'as' => 'irrigation_system.delete']);

$router->get('/irrigation_controllers', ['uses' => 'IrrigationControllerController@index', 'as' => 'irrigation_controller.index']);
$router->post('/irrigation_controller', ['uses' => 'IrrigationControllerController@create', 'as' => 'irrigation_controller.create']);
$router->get('/irrigation_controller/{id:[0-9]+}', ['uses' => 'IrrigationControllerController@read', 'as' => 'irrigation_controller.read']);
$router->patch('/irrigation_controller/{id:[0-9]+}', ['uses' => 'IrrigationControllerController@update', 'as' => 'irrigation_controller.update']);
$router->delete('/irrigation_controller/{id:[0-9]+}', ['uses' => 'IrrigationControllerController@delete', 'as' => 'irrigation_controller.delete']);

$router->get('/irrigation_controller_locations', ['uses' => 'IrrigationControllerLocationController@index', 'as' => 'irrigation_controller_location.index']);
$router->post('/irrigation_controller_location', ['uses' => 'IrrigationControllerLocationController@create', 'as' => 'irrigation_controller_location.create']);
$router->get('/irrigation_controller_location/{id:[0-9]+}', ['uses' => 'IrrigationControllerLocationController@read', 'as' => 'irrigation_controller_location.read']);
$router->patch('/irrigation_controller_location/{id:[0-9]+}', ['uses' => 'IrrigationControllerLocationController@update', 'as' => 'irrigation_controller_location.update']);
$router->delete('/irrigation_controller_location/{id:[0-9]+}', ['uses' => 'IrrigationControllerLocationController@delete', 'as' => 'irrigation_controller_location.delete']);

$router->get('/irrigation_system_others', ['uses' => 'IrrigationSystemOtherController@index', 'as' => 'irrigation_system_other.index']);
$router->post('/irrigation_system_other', ['uses' => 'IrrigationSystemOtherController@create', 'as' => 'irrigation_system_other.create']);
$router->get('/irrigation_system_other/{id:[0-9]+}', ['uses' => 'IrrigationSystemOtherController@read', 'as' => 'irrigation_system_other.read']);
$router->patch('/irrigation_system_other/{id:[0-9]+}', ['uses' => 'IrrigationSystemOtherController@update', 'as' => 'irrigation_system_other.update']);
$router->delete('/irrigation_system_other/{id:[0-9]+}', ['uses' => 'IrrigationSystemOtherController@delete', 'as' => 'irrigation_system_other.delete']);

$router->get('/irrigation_controller_others', ['uses' => 'IrrigationControllerOtherController@index', 'as' => 'irrigation_controller_other.index']);
$router->post('/irrigation_controller_other', ['uses' => 'IrrigationControllerOtherController@create', 'as' => 'irrigation_controller_other.create']);
$router->get('/irrigation_controller_other/{id:[0-9]+}', ['uses' => 'IrrigationControllerOtherController@read', 'as' => 'irrigation_controller_other.read']);
$router->patch('/irrigation_controller_other/{id:[0-9]+}', ['uses' => 'IrrigationControllerOtherController@update', 'as' => 'irrigation_controller_other.update']);
$router->delete('/irrigation_controller_other/{id:[0-9]+}', ['uses' => 'IrrigationControllerOtherController@delete', 'as' => 'irrigation_controller_other.delete']);

$router->get('/irrigation_zones', ['uses' => 'IrrigationZoneController@index', 'as' => 'irrigation_zone.index']);
$router->post('/irrigation_zone', ['uses' => 'IrrigationZoneController@create', 'as' => 'irrigation_zone.create']);
$router->get('/irrigation_zone/{id:[0-9]+}', ['uses' => 'IrrigationZoneController@read', 'as' => 'irrigation_zone.read']);
$router->patch('/irrigation_zone/{id:[0-9]+}', ['uses' => 'IrrigationZoneController@update', 'as' => 'irrigation_zone.update']);
$router->delete('/irrigation_zone/{id:[0-9]+}', ['uses' => 'IrrigationZoneController@delete', 'as' => 'irrigation_zone.delete']);

$router->get('/property_accounts', ['uses' => 'PropertyAccountController@index', 'as' => 'property_account.index']);
$router->post('/property_account', ['uses' => 'PropertyAccountController@create', 'as' => 'property_account.create']);
$router->get('/property_account/{id:[0-9]+}', ['uses' => 'PropertyAccountController@read', 'as' => 'property_account.read']);
$router->patch('/property_account/{id:[0-9]+}', ['uses' => 'PropertyAccountController@update', 'as' => 'property_account.update']);
$router->delete('/property_account/{id:[0-9]+}', ['uses' => 'PropertyAccountController@delete', 'as' => 'property_account.delete']);

$router->get('/backflow_pictures', ['uses' => 'BackflowPictureController@index', 'as' => 'backflow_picture.index']);
$router->post('/backflow_picture', ['uses' => 'BackflowPictureController@create', 'as' => 'backflow_picture.create']);
$router->get('/backflow_picture/{id:[0-9]+}', ['uses' => 'BackflowPictureController@read', 'as' => 'backflow_picture.read']);
$router->patch('/backflow_picture/{id:[0-9]+}', ['uses' => 'BackflowPictureController@update', 'as' => 'backflow_picture.update']);
$router->delete('/backflow_picture/{id:[0-9]+}', ['uses' => 'BackflowPictureController@delete', 'as' => 'backflow_picture.delete']);

$router->get('/clock_ins', ['uses' => 'ClockInController@index', 'as' => 'clock_in.index']);
$router->post('/clock_in', ['uses' => 'ClockInController@create', 'as' => 'clock_in.create']);
$router->get('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@read', 'as' => 'clock_in.read']);
$router->patch('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@update', 'as' => 'clock_in.update']);
$router->delete('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@delete', 'as' => 'clock_in.delete']);
$router->get('/clock_in/current', ['uses' => 'ClockInController@current', 'as' => 'clock_in.current']);
$router->get('/clock_ins/by_employee', 'ClockInController@by_employee');

$router->get('/overhead_assignments', ['uses' => 'OverheadAssignmentController@index', 'as' => 'overhead_assignment.index']);
$router->post('/overhead_assignment', ['uses' => 'OverheadAssignmentController@create', 'as' => 'overhead_assignment.create']);
$router->get('/overhead_assignment/{id:[0-9]+}', ['uses' => 'OverheadAssignmentController@read', 'as' => 'overhead_assignment.read']);
$router->patch('/overhead_assignment/{id:[0-9]+}', ['uses' => 'OverheadAssignmentController@update', 'as' => 'overhead_assignment.update']);
$router->delete('/overhead_assignment/{id:[0-9]+}', ['uses' => 'OverheadAssignmentController@delete', 'as' => 'overhead_assignment.delete']);
$router->put('/overhead_assignment/{id:[0-9]+}/overhead_categories', ['uses' => 'OverheadAssignmentController@categories', 'as' => 'overhead_assignment.update']);

$router->get('/overhead_categories', ['uses' => 'OverheadCategoryController@index', 'as' => 'overhead_category.index']);
$router->post('/overhead_category', ['uses' => 'OverheadCategoryController@create', 'as' => 'overhead_category.create']);
$router->get('/overhead_category/{id:[0-9]+}', ['uses' => 'OverheadCategoryController@read', 'as' => 'overhead_category.read']);
$router->patch('/overhead_category/{id:[0-9]+}', ['uses' => 'OverheadCategoryController@update', 'as' => 'overhead_category.update']);
$router->delete('/overhead_category/{id:[0-9]+}', ['uses' => 'OverheadCategoryController@delete', 'as' => 'overhead_category.delete']);

$router->get('/asset_types', ['uses' => 'AssetTypeController@index', 'as' => 'asset_type.index']);
$router->post('/asset_type', ['uses' => 'AssetTypeController@create', 'as' => 'asset_type.create']);
$router->get('/asset_type/{id:[0-9]+}', ['uses' => 'AssetTypeController@read', 'as' => 'asset_type.read']);
$router->patch('/asset_type/{id:[0-9]+}', ['uses' => 'AssetTypeController@update', 'as' => 'asset_type.update']);
$router->delete('/asset_type/{id:[0-9]+}', ['uses' => 'AssetTypeController@delete', 'as' => 'asset_type.delete']);

$router->get('/asset_usage_types', ['uses' => 'AssetUsageTypeController@index', 'as' => 'asset_usage_type.index']);
$router->post('/asset_usage_type', ['uses' => 'AssetUsageTypeController@create', 'as' => 'asset_usage_type.create']);
$router->get('/asset_usage_type/{id:[0-9]+}', ['uses' => 'AssetUsageTypeController@read', 'as' => 'asset_usage_type.read']);
$router->patch('/asset_usage_type/{id:[0-9]+}', ['uses' => 'AssetUsageTypeController@update', 'as' => 'asset_usage_type.update']);
$router->delete('/asset_usage_type/{id:[0-9]+}', ['uses' => 'AssetUsageTypeController@delete', 'as' => 'asset_usage_type.delete']);

$router->get('/assets', ['uses' => 'AssetController@index', 'as' => 'asset.index']);
$router->post('/asset', ['uses' => 'AssetController@create', 'as' => 'asset.create']);
$router->get('/asset/{id:[0-9]+}', ['uses' => 'AssetController@read', 'as' => 'asset.read']);
$router->patch('/asset/{id:[0-9]+}', ['uses' => 'AssetController@update', 'as' => 'asset.update']);
$router->delete('/asset/{id:[0-9]+}', ['uses' => 'AssetController@delete', 'as' => 'asset.delete']);

$router->get('/asset_fuelings', ['uses' => 'AssetFuelingController@index', 'as' => 'asset_fueling.index']);
$router->post('/asset_fueling', ['uses' => 'AssetFuelingController@create', 'as' => 'asset_fueling.create']);
$router->get('/asset_fueling/{id:[0-9]+}', ['uses' => 'AssetFuelingController@read', 'as' => 'asset_fueling.read']);
$router->get('/asset_fueling/last', ['uses' => 'AssetFuelingController@last', 'as' => 'asset_fueling.last']);
$router->patch('/asset_fueling/{id:[0-9]+}', ['uses' => 'AssetFuelingController@update', 'as' => 'asset_fueling.update']);
$router->delete('/asset_fueling/{id:[0-9]+}', ['uses' => 'AssetFuelingController@delete', 'as' => 'asset_fueling.delete']);

$router->get('/asset_parts', ['uses' => 'AssetPartController@index', 'as' => 'asset_part.index']);
$router->post('/asset_part', ['uses' => 'AssetPartController@create', 'as' => 'asset_part.create']);
$router->get('/asset_part/{id:[0-9]+}', ['uses' => 'AssetPartController@read', 'as' => 'asset_part.read']);
$router->patch('/asset_part/{id:[0-9]+}', ['uses' => 'AssetPartController@update', 'as' => 'asset_part.update']);
$router->delete('/asset_part/{id:[0-9]+}', ['uses' => 'AssetPartController@delete', 'as' => 'asset_part.delete']);

$router->get('/asset_repairs', ['uses' => 'AssetRepairController@index', 'as' => 'asset_repair.index']);
$router->post('/asset_repair', ['uses' => 'AssetRepairController@create', 'as' => 'asset_repair.create']);
$router->get('/asset_repair/{id:[0-9]+}', ['uses' => 'AssetRepairController@read', 'as' => 'asset_repair.read']);
$router->patch('/asset_repair/{id:[0-9]+}', ['uses' => 'AssetRepairController@update', 'as' => 'asset_repair.update']);
$router->delete('/asset_repair/{id:[0-9]+}', ['uses' => 'AssetRepairController@delete', 'as' => 'asset_repair.delete']);
$router->get('/asset_repairs/unique/{field:\w+}', ['uses' => 'AssetRepairController@unique', 'as' => 'asset_repair.unique']);

$router->get('/asset_service_types', ['uses' => 'AssetServiceTypeController@index', 'as' => 'asset_service_type.index']);
$router->post('/asset_service_type', ['uses' => 'AssetServiceTypeController@create', 'as' => 'asset_service_type.create']);
$router->get('/asset_service_type/{id:[0-9]+}', ['uses' => 'AssetServiceTypeController@read', 'as' => 'asset_service_type.read']);
$router->patch('/asset_service_type/{id:[0-9]+}', ['uses' => 'AssetServiceTypeController@update', 'as' => 'asset_service_type.update']);
$router->delete('/asset_service_type/{id:[0-9]+}', ['uses' => 'AssetServiceTypeController@delete', 'as' => 'asset_service_type.delete']);

$router->get('/asset_services', ['uses' => 'AssetServiceController@index', 'as' => 'asset_service.index']);
$router->post('/asset_service', ['uses' => 'AssetServiceController@create', 'as' => 'asset_service.create']);
$router->get('/asset_service/{id:[0-9]+}', ['uses' => 'AssetServiceController@read', 'as' => 'asset_service.read']);
$router->patch('/asset_service/{id:[0-9]+}', ['uses' => 'AssetServiceController@update', 'as' => 'asset_service.update']);
$router->delete('/asset_service/{id:[0-9]+}', ['uses' => 'AssetServiceController@delete', 'as' => 'asset_service.delete']);

$router->get('/asset_maintenances', ['uses' => 'AssetMaintenanceController@index', 'as' => 'asset_maintenance.index']);
$router->post('/asset_maintenance', ['uses' => 'AssetMaintenanceController@create', 'as' => 'asset_maintenance.create']);
$router->get('/asset_maintenance/{id:[0-9]+}', ['uses' => 'AssetMaintenanceController@read', 'as' => 'asset_maintenance.read']);
$router->get('/asset_maintenance/last/', ['uses' => 'AssetMaintenanceController@last', 'as' => 'asset_maintenance.last']);
$router->patch('/asset_maintenance/{id:[0-9]+}', ['uses' => 'AssetMaintenanceController@update', 'as' => 'asset_maintenance.update']);
$router->delete('/asset_maintenance/{id:[0-9]+}', ['uses' => 'AssetMaintenanceController@delete', 'as' => 'asset_maintenance.delete']);
$router->get('/asset_maintenances/unique/{field:\w+}', ['uses' => 'AssetMaintenanceController@unique', 'as' => 'asset_maintenance.unique']);

$router->get('/asset_units', ['uses' => 'AssetUnitController@index', 'as' => 'asset_unit.index']);
$router->post('/asset_unit', ['uses' => 'AssetUnitController@create', 'as' => 'asset_unit.create']);
$router->get('/asset_unit/{id:[0-9]+}', ['uses' => 'AssetUnitController@read', 'as' => 'asset_unit.read']);
$router->patch('/asset_unit/{id:[0-9]+}', ['uses' => 'AssetUnitController@update', 'as' => 'asset_unit.update']);
$router->delete('/asset_unit/{id:[0-9]+}', ['uses' => 'AssetUnitController@delete', 'as' => 'asset_unit.delete']);

$router->get('/roles', ['uses' => 'RoleController@index', 'as' => 'role.index']);
$router->post('/role', ['uses' => 'RoleController@create', 'as' => 'role.create']);
$router->get('/role/{id:[0-9]+}', ['uses' => 'RoleController@read', 'as' => 'role.read']);
$router->patch('/role/{id:[0-9]+}', ['uses' => 'RoleController@update', 'as' => 'role.update']);
$router->delete('/role/{id:[0-9]+}', ['uses' => 'RoleController@delete', 'as' => 'role.delete']);
$router->put('/role/{id:[0-9]+}/permissions', ['uses' => 'RoleController@updatePermissions', 'as' => 'role.update.permissions']);

$router->get('/asset_time_units', ['uses' => 'AssetTimeUnitController@index', 'as' => 'asset_time_unit.index']);
$router->post('/asset_time_unit', ['uses' => 'AssetTimeUnitController@create', 'as' => 'asset_time_unit.create']);
$router->get('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@read', 'as' => 'asset_time_unit.read']);
$router->patch('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@update', 'as' => 'asset_time_unit.update']);
$router->delete('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@delete', 'as' => 'asset_time_unit.delete']);

$router->get('/asset_time_units', ['uses' => 'AssetTimeUnitController@index', 'as' => 'asset_time_unit.index']);
$router->post('/asset_time_unit', ['uses' => 'AssetTimeUnitController@create', 'as' => 'asset_time_unit.create']);
$router->get('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@read', 'as' => 'asset_time_unit.read']);
$router->patch('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@update', 'as' => 'asset_time_unit.update']);
$router->delete('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@delete', 'as' => 'asset_time_unit.delete']);

$router->get('/asset_locations', ['uses' => 'AssetLocationController@index', 'as' => 'asset_location.index']);
$router->post('/asset_location', ['uses' => 'AssetLocationController@create', 'as' => 'asset_location.create']);
$router->get('/asset_location/{id:[0-9]+}', ['uses' => 'AssetLocationController@read', 'as' => 'asset_location.read']);
$router->patch('/asset_location/{id:[0-9]+}', ['uses' => 'AssetLocationController@update', 'as' => 'asset_location.update']);
$router->delete('/asset_location/{id:[0-9]+}', ['uses' => 'AssetLocationController@delete', 'as' => 'asset_location.delete']);

$router->get('/asset_pictures', ['uses' => 'AssetPictureController@index', 'as' => 'asset_picture.index']);
$router->post('/asset_picture', ['uses' => 'AssetPictureController@create', 'as' => 'asset_picture.create']);
$router->get('/asset_picture/{id:[0-9]+}', ['uses' => 'AssetPictureController@read', 'as' => 'asset_picture.read']);
$router->patch('/asset_picture/{id:[0-9]+}', ['uses' => 'AssetPictureController@update', 'as' => 'asset_picture.update']);
$router->delete('/asset_picture/{id:[0-9]+}', ['uses' => 'AssetPictureController@delete', 'as' => 'asset_picture.delete']);

$router->get('/asset_appraisals', ['uses' => 'AssetAppraisalController@index', 'as' => 'asset_appraisal.index']);
$router->post('/asset_appraisal', ['uses' => 'AssetAppraisalController@create', 'as' => 'asset_appraisal.create']);
$router->get('/asset_appraisal/{id:[0-9]+}', ['uses' => 'AssetAppraisalController@read', 'as' => 'asset_appraisal.read']);
$router->patch('/asset_appraisal/{id:[0-9]+}', ['uses' => 'AssetAppraisalController@update', 'as' => 'asset_appraisal.update']);
$router->delete('/asset_appraisal/{id:[0-9]+}', ['uses' => 'AssetAppraisalController@delete', 'as' => 'asset_appraisal.delete']);

$router->get('/asset_improvements', ['uses' => 'AssetImprovementController@index', 'as' => 'asset_improvement.index']);
$router->post('/asset_improvement', ['uses' => 'AssetImprovementController@create', 'as' => 'asset_improvement.create']);
$router->get('/asset_improvement/{id:[0-9]+}', ['uses' => 'AssetImprovementController@read', 'as' => 'asset_improvement.read']);
$router->patch('/asset_improvement/{id:[0-9]+}', ['uses' => 'AssetImprovementController@update', 'as' => 'asset_improvement.update']);
$router->delete('/asset_improvement/{id:[0-9]+}', ['uses' => 'AssetImprovementController@delete', 'as' => 'asset_improvement.delete']);

$router->get('/permissions', ['uses' => 'PermissionController@index', 'as' => 'permission.index']);
$router->post('/permission', ['uses' => 'PermissionController@create', 'as' => 'permission.create']);
$router->get('/permission/{id:[0-9]+}', ['uses' => 'PermissionController@read', 'as' => 'permission.read']);
$router->patch('/permission/{id:[0-9]+}', ['uses' => 'PermissionController@update', 'as' => 'permission.update']);
$router->delete('/permission/{id:[0-9]+}', ['uses' => 'PermissionController@delete', 'as' => 'permission.delete']);

$router->get('/appointments', ['uses' => 'AppointmentController@index', 'as' => 'appointment.index']);
$router->post('/appointment', ['uses' => 'AppointmentController@create', 'as' => 'appointment.create']);
$router->get('/appointment/{id:[0-9]+}', ['uses' => 'AppointmentController@read', 'as' => 'appointment.read']);
$router->patch('/appointment/{id:[0-9]+}', ['uses' => 'AppointmentController@update', 'as' => 'appointment.update']);
$router->delete('/appointment/{id:[0-9]+}', ['uses' => 'AppointmentController@delete', 'as' => 'appointment.delete']);
$router->get('/schedule', 'AppointmentController@schedule');

$router->get('/labor_types', ['uses' => 'LaborTypeController@index', 'as' => 'labor_type.index']);
$router->post('/labor_type', ['uses' => 'LaborTypeController@create', 'as' => 'labor_type.create']);
$router->get('/labor_type/{id:[0-9]+}', ['uses' => 'LaborTypeController@read', 'as' => 'labor_type.read']);
$router->patch('/labor_type/{id:[0-9]+}', ['uses' => 'LaborTypeController@update', 'as' => 'labor_type.update']);
$router->delete('/labor_type/{id:[0-9]+}', ['uses' => 'LaborTypeController@delete', 'as' => 'labor_type.delete']);

$router->get('/labor_activities', ['uses' => 'LaborActivityController@index', 'as' => 'labor_activity.index']);
$router->post('/labor_activity', ['uses' => 'LaborActivityController@create', 'as' => 'labor_activity.create']);
$router->get('/labor_activity/{id:[0-9]+}', ['uses' => 'LaborActivityController@read', 'as' => 'labor_activity.read']);
$router->patch('/labor_activity/{id:[0-9]+}', ['uses' => 'LaborActivityController@update', 'as' => 'labor_activity.update']);
$router->delete('/labor_activity/{id:[0-9]+}', ['uses' => 'LaborActivityController@delete', 'as' => 'labor_activity.delete']);

$router->get('/labor_assignments', ['uses' => 'LaborAssignmentController@index', 'as' => 'labor_assignment.index']);
$router->post('/labor_assignment', ['uses' => 'LaborAssignmentController@create', 'as' => 'labor_assignment.create']);
$router->get('/labor_assignment/{id:[0-9]+}', ['uses' => 'LaborAssignmentController@read', 'as' => 'labor_assignment.read']);
$router->patch('/labor_assignment/{id:[0-9]+}', ['uses' => 'LaborAssignmentController@update', 'as' => 'labor_assignment.update']);
$router->delete('/labor_assignment/{id:[0-9]+}', ['uses' => 'LaborAssignmentController@delete', 'as' => 'labor_assignment.delete']);

$router->get('/task_actions', ['uses' => 'TaskActionController@index', 'as' => 'task_action.index']);
$router->post('/task_action', ['uses' => 'TaskActionController@create', 'as' => 'task_action.create']);
$router->get('/task_action/{id:[0-9]+}', ['uses' => 'TaskActionController@read', 'as' => 'task_action.read']);
$router->patch('/task_action/{id:[0-9]+}', ['uses' => 'TaskActionController@update', 'as' => 'task_action.update']);
$router->delete('/task_action/{id:[0-9]+}', ['uses' => 'TaskActionController@delete', 'as' => 'task_action.delete']);