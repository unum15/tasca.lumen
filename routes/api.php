<?php

use Illuminate\Support\Facades\Route;
        
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return 'Tasca API 1.0';
});

Route::post('/auth', 'AuthController@auth');
Route::post('/unauth', 'AuthController@unauth');
Route::get('/status', 'AuthController@status');
Route::get('/auth/password/reset', ['uses' => 'AuthController@passwordReset', 'as' => 'password.reset']);
Route::post('/auth/password/email', 'AuthController@sendResetLinkEmail');
Route::post('/auth/password/reset', 'AuthController@reset');

Route::get('/activity_levels', 'ActivityLevelController@index');
Route::post('/activity_level', 'ActivityLevelController@create');
Route::get('/activity_level/{id:[0-9]+}', 'ActivityLevelController@read');
Route::patch('/activity_level/{id:[0-9]+}', 'ActivityLevelController@update');
Route::delete('/activity_level/{id:[0-9]+}', 'ActivityLevelController@delete');

Route::get('/client_types', 'ClientTypeController@index');
Route::post('/client_type', 'ClientTypeController@create');
Route::get('/client_type/{id:[0-9]+}', 'ClientTypeController@read');
Route::patch('/client_type/{id:[0-9]+}', 'ClientTypeController@update');
Route::delete('/client_type/{id:[0-9]+}', 'ClientTypeController@delete');

Route::get('/contact_methods', 'ContactMethodController@index');
Route::post('/contact_method', 'ContactMethodController@create');
Route::get('/contact_method/{id:[0-9]+}', 'ContactMethodController@read');
Route::patch('/contact_method/{id:[0-9]+}', 'ContactMethodController@update');
Route::delete('/contact_method/{id:[0-9]+}', 'ContactMethodController@delete');

Route::get('/contact_types', 'ContactTypeController@index');
Route::post('/contact_type', 'ContactTypeController@create');
Route::get('/contact_type/{id:[0-9]+}', 'ContactTypeController@read');
Route::patch('/contact_type/{id:[0-9]+}', 'ContactTypeController@update');
Route::delete('/contact_type/{id:[0-9]+}', 'ContactTypeController@delete');

Route::get('/crews', 'CrewController@index');
Route::post('/crew', 'CrewController@create');
Route::get('/crew/{id:[0-9]+}', 'CrewController@read');
Route::patch('/crew/{id:[0-9]+}', 'CrewController@update');
Route::delete('/crew/{id:[0-9]+}', 'CrewController@delete');

Route::get('/email_types', 'EmailTypeController@index');
Route::post('/email_type', 'EmailTypeController@create');
Route::get('/email_type/{id:[0-9]+}', 'EmailTypeController@read');
Route::patch('/email_type/{id:[0-9]+}', 'EmailTypeController@update');
Route::delete('/email_type/{id:[0-9]+}', 'EmailTypeController@delete');

Route::get('/phone_number_types', 'PhoneNumberTypeController@index');
Route::post('/phone_number_type', 'PhoneNumberTypeController@create');
Route::get('/phone_number_type/{id:[0-9]+}', 'PhoneNumberTypeController@read');
Route::patch('/phone_number_type/{id:[0-9]+}', 'PhoneNumberTypeController@update');
Route::delete('/phone_number_type/{id:[0-9]+}', 'PhoneNumberTypeController@delete');

Route::get('/property_types', 'PropertyTypeController@index');
Route::post('/property_type', 'PropertyTypeController@create');
Route::get('/property_type/{id:[0-9]+}', 'PropertyTypeController@read');
Route::patch('/property_type/{id:[0-9]+}', 'PropertyTypeController@update');
Route::delete('/property_type/{id:[0-9]+}', 'PropertyTypeController@delete');

Route::get('/order_actions', 'OrderActionController@index');
Route::post('/order_action', 'OrderActionController@create');
Route::get('/order_action/{id:[0-9]+}', 'OrderActionController@read');
Route::patch('/order_action/{id:[0-9]+}', 'OrderActionController@update');
Route::delete('/order_action/{id:[0-9]+}', 'OrderActionController@delete');

Route::get('/order_priorities', 'OrderPriorityController@index');
Route::post('/order_priority', 'OrderPriorityController@create');
Route::get('/order_priority/{id:[0-9]+}', 'OrderPriorityController@read');
Route::patch('/order_priority/{id:[0-9]+}', 'OrderPriorityController@update');
Route::delete('/order_priority/{id:[0-9]+}', 'OrderPriorityController@delete');

Route::get('/order_categories', 'OrderCategoryController@index');
Route::post('/order_category', 'OrderCategoryController@create');
Route::get('/order_category/{id:[0-9]+}', 'OrderCategoryController@read');
Route::patch('/order_category/{id:[0-9]+}', 'OrderCategoryController@update');
Route::delete('/order_category/{id:[0-9]+}', 'OrderCategoryController@delete');

Route::get('/order_statuses', 'OrderStatusController@index');
Route::post('/order_status', 'OrderStatusController@create');
Route::get('/order_status/{id:[0-9]+}', 'OrderStatusController@read');
Route::patch('/order_status/{id:[0-9]+}', 'OrderStatusController@update');
Route::delete('/order_status/{id:[0-9]+}', 'OrderStatusController@delete');

Route::get('/order_status_types', 'OrderStatusTypeController@index');
Route::post('/order_status_type', 'OrderStatusTypeController@create');
Route::get('/order_status_type/{id:[0-9]+}', 'OrderStatusTypeController@read');
Route::patch('/order_status_type/{id:[0-9]+}', 'OrderStatusTypeController@update');
Route::delete('/order_status_type/{id:[0-9]+}', 'OrderStatusTypeController@delete');

Route::get('/order_types', 'OrderTypeController@index');
Route::post('/order_type', 'OrderTypeController@create');
Route::get('/order_type/{id:[0-9]+}', 'OrderTypeController@read');
Route::patch('/order_type/{id:[0-9]+}', 'OrderTypeController@update');
Route::delete('/order_type/{id:[0-9]+}', 'OrderTypeController@delete');

Route::get('/task_statuses', 'TaskStatusController@index');
Route::post('/task_status', 'TaskStatusController@create');
Route::get('/task_status/{id:[0-9]+}', 'TaskStatusController@read');
Route::patch('/task_status/{id:[0-9]+}', 'TaskStatusController@update');
Route::delete('/task_status/{id:[0-9]+}', 'TaskStatusController@delete');

Route::get('/appointment_statuses', 'AppointmentStatusController@index');
Route::post('/appointment_status', 'AppointmentStatusController@create');
Route::get('/appointment_status/{id:[0-9]+}', 'AppointmentStatusController@read');
Route::patch('/appointment_status/{id:[0-9]+}', 'AppointmentStatusController@update');
Route::delete('/appointment_status/{id:[0-9]+}', 'AppointmentStatusController@delete');

Route::get('/clients', 'ClientController@index');
Route::post('/client', 'ClientController@create');
Route::get('/client/{id:[0-9]+}', 'ClientController@read');
Route::patch('/client/{id:[0-9]+}', 'ClientController@update');
Route::delete('/client/{id:[0-9]+}', 'ClientController@delete');
Route::get('/clients/unique/{field:\w+}', ['uses' => 'ClientController@unique', 'as' => 'client.unique']);
Route::post('/client/{id:[0-9]+}/properties', 'ClientController@addProperty');
Route::delete('/client/{id}/property/{property_id}', 'ClientController@deleteProperty');

Route::get('/contacts', 'ContactController@index');
Route::post('/contact', 'ContactController@create');
Route::get('/contact/{id:[0-9]+}', 'ContactController@read');
Route::patch('/contact/{id:[0-9]+}', 'ContactController@update');
Route::post('/contact/{id:[0-9]+}/account', 'ContactController@createAccount');
Route::put('/contact/{id:[0-9]+}/roles', 'ContactController@updateRoles');
Route::delete('/contact/{id:[0-9]+}', 'ContactController@delete');

Route::get('/emails', 'EmailController@index');
Route::post('/email', 'EmailController@create');
Route::get('/email/{id:[0-9]+}', 'EmailController@read');
Route::patch('/email/{id:[0-9]+}', 'EmailController@update');
Route::delete('/email/{id:[0-9]+}', 'EmailController@delete');

Route::get('/phone_numbers', 'PhoneNumberController@index');
Route::post('/phone_number', 'PhoneNumberController@create');
Route::get('/phone_number/{id:[0-9]+}', 'PhoneNumberController@read');
Route::patch('/phone_number/{id:[0-9]+}', 'PhoneNumberController@update');
Route::delete('/phone_number/{id:[0-9]+}', 'PhoneNumberController@delete');

Route::get('/projects', 'ProjectController@index');
Route::post('/project', 'ProjectController@create');
Route::get('/project/{id:[0-9]+}', 'ProjectController@read');
Route::patch('/project/{id:[0-9]+}', 'ProjectController@update');
Route::delete('/project/{id:[0-9]+}', 'ProjectController@delete');
Route::get('/projects/unique/{field:\w+}', ['uses' => 'ProjectController@unique', 'as' => 'project.unique']);

Route::get('/properties', 'PropertyController@index');
Route::post('/property', 'PropertyController@create');
Route::get('/property/{id:[0-9]+}', 'PropertyController@read');
Route::patch('/property/{id:[0-9]+}', 'PropertyController@update');
Route::delete('/property/{id:[0-9]+}', 'PropertyController@delete');

Route::get('/orders', 'OrderController@index');
Route::post('/order', 'OrderController@create');
Route::post('/order/convert/{id:[0-9]+}', 'OrderController@convert');
Route::get('/order/{id:[0-9]+}', 'OrderController@read');
Route::patch('/order/{id:[0-9]+}', 'OrderController@update');
Route::delete('/order/{id:[0-9]+}', 'OrderController@delete');
Route::get('/orders/closable', 'OrderController@closable');
Route::get('/orders/unique/{field:\w+}', ['uses' => 'OrderController@unique', 'as' => 'order.unique']);

Route::get('/tasks', 'TaskController@index');
Route::post('/task', 'TaskController@create');
Route::get('/task/{id:[0-9]+}', 'TaskController@read');
Route::patch('/task/{id:[0-9]+}', 'TaskController@update');
Route::delete('/task/{id:[0-9]+}', 'TaskController@delete');
Route::get('/tasks/unique/{field:\w+}', ['uses' => 'TaskController@unique', 'as' => 'task.unique']);

Route::get('/settings', 'SettingController@index');
Route::patch('/settings', 'SettingController@update');

Route::get('/calendar/status', 'GoogleCalendarController@status');
Route::get('/calendar/url', 'GoogleCalendarController@url');
Route::post('/calendar/callback', 'GoogleCalendarController@callback');

Route::get('/google/status', 'GoogleController@status');
Route::get('/google/url', 'GoogleController@url');
Route::post('/google/callback', 'GoogleController@callback');

Route::get('/backflow_valve_parts', ['uses' => 'BackflowValvePartController@index', 'as' => 'backflow_valve_part.index']);
Route::post('/backflow_valve_part', ['uses' => 'BackflowValvePartController@create', 'as' => 'backflow_valve_part.create']);
Route::get('/backflow_valve_part/{id:[0-9]+}', ['uses' => 'BackflowValvePartController@read', 'as' => 'backflow_valve_part.read']);
Route::patch('/backflow_valve_part/{id:[0-9]+}', ['uses' => 'BackflowValvePartController@update', 'as' => 'backflow_valve_part.update']);
Route::delete('/backflow_valve_part/{id:[0-9]+}', ['uses' => 'BackflowValvePartController@delete', 'as' => 'backflow_valve_part.delete']);

Route::get('/backflow_water_systems', ['uses' => 'BackflowWaterSystemController@index', 'as' => 'backflow_water_system.index']);
Route::post('/backflow_water_system', ['uses' => 'BackflowWaterSystemController@create', 'as' => 'backflow_water_system.create']);
Route::get('/backflow_water_system/{id:[0-9]+}', ['uses' => 'BackflowWaterSystemController@read', 'as' => 'backflow_water_system.read']);
Route::patch('/backflow_water_system/{id:[0-9]+}', ['uses' => 'BackflowWaterSystemController@update', 'as' => 'backflow_water_system.update']);
Route::delete('/backflow_water_system/{id:[0-9]+}', ['uses' => 'BackflowWaterSystemController@delete', 'as' => 'backflow_water_system.delete']);

Route::get('/backflow_manufacturers', ['uses' => 'BackflowManufacturerController@index', 'as' => 'backflow_manufacturer.index']);
Route::post('/backflow_manufacturer', ['uses' => 'BackflowManufacturerController@create', 'as' => 'backflow_manufacturer.create']);
Route::get('/backflow_manufacturer/{id:[0-9]+}', ['uses' => 'BackflowManufacturerController@read', 'as' => 'backflow_manufacturer.read']);
Route::patch('/backflow_manufacturer/{id:[0-9]+}', ['uses' => 'BackflowManufacturerController@update', 'as' => 'backflow_manufacturer.update']);
Route::delete('/backflow_manufacturer/{id:[0-9]+}', ['uses' => 'BackflowManufacturerController@delete', 'as' => 'backflow_manufacturer.delete']);

Route::get('/backflow_models', ['uses' => 'BackflowModelController@index', 'as' => 'backflow_model.index']);
Route::post('/backflow_model', ['uses' => 'BackflowModelController@create', 'as' => 'backflow_model.create']);
Route::get('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@read', 'as' => 'backflow_model.read']);
Route::patch('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@update', 'as' => 'backflow_model.update']);
Route::delete('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@delete', 'as' => 'backflow_model.delete']);

Route::get('/backflow_types', ['uses' => 'BackflowTypeController@index', 'as' => 'backflow_type.index']);
Route::post('/backflow_type', ['uses' => 'BackflowTypeController@create', 'as' => 'backflow_type.create']);
Route::get('/backflow_type/{id:[0-9]+}', ['uses' => 'BackflowTypeController@read', 'as' => 'backflow_type.read']);
Route::patch('/backflow_type/{id:[0-9]+}', ['uses' => 'BackflowTypeController@update', 'as' => 'backflow_type.update']);
Route::delete('/backflow_type/{id:[0-9]+}', ['uses' => 'BackflowTypeController@delete', 'as' => 'backflow_type.delete']);

Route::get('/backflow_assemblies', ['uses' => 'BackflowAssemblyController@index', 'as' => 'backflow_assembly.index']);
Route::post('/backflow_assembly', ['uses' => 'BackflowAssemblyController@create', 'as' => 'backflow_assembly.create']);
Route::get('/backflow_assembly/{id:[0-9]+}', ['uses' => 'BackflowAssemblyController@read', 'as' => 'backflow_assembly.read']);
Route::patch('/backflow_assembly/{id:[0-9]+}', ['uses' => 'BackflowAssemblyController@update', 'as' => 'backflow_assembly.update']);
Route::delete('/backflow_assembly/{id:[0-9]+}', ['uses' => 'BackflowAssemblyController@delete', 'as' => 'backflow_assembly.delete']);
Route::get('/backflow_assembly/unique/{field:\w+}', ['uses' => 'BackflowAssemblyController@unique', 'as' => 'backflow_assembly.unique']);
Route::get('/backflow_assemblies/tags/pdf', ['uses' => 'BackflowAssemblyController@tagsPdf', 'as' => 'backflow_assembly.tags_pdf']);

Route::get('/backflow_sizes', ['uses' => 'BackflowSizeController@index', 'as' => 'backflow_size.index']);
Route::post('/backflow_size', ['uses' => 'BackflowSizeController@create', 'as' => 'backflow_size.create']);
Route::get('/backflow_size/{id:[0-9]+}', ['uses' => 'BackflowSizeController@read', 'as' => 'backflow_size.read']);
Route::patch('/backflow_size/{id:[0-9]+}', ['uses' => 'BackflowSizeController@update', 'as' => 'backflow_size.update']);
Route::delete('/backflow_size/{id:[0-9]+}', ['uses' => 'BackflowSizeController@delete', 'as' => 'backflow_size.delete']);

Route::get('/backflow_old', ['uses' => 'BackflowOldController@index', 'as' => 'backflow_old.index']);
Route::post('/backflow_old', ['uses' => 'BackflowOldController@create', 'as' => 'backflow_old.create']);
Route::get('/backflow_old/{id:[0-9]+}', ['uses' => 'BackflowOldController@read', 'as' => 'backflow_old.read']);
Route::patch('/backflow_old/{id:[0-9]+}', ['uses' => 'BackflowOldController@update', 'as' => 'backflow_old.update']);
Route::delete('/backflow_old/{id:[0-9]+}', ['uses' => 'BackflowOldController@delete', 'as' => 'backflow_old.delete']);
Route::get('/backflow_old/zips', ['uses' => 'BackflowOldController@zips', 'as' => 'backflow_old.zips']);
Route::get('/backflow_old/groups', ['uses' => 'BackflowOldController@groups', 'as' => 'backflow_old.groups']);
Route::post('/backflow_old/export/{id:[0-9]+}', ['uses' => 'BackflowOldController@export', 'as' => 'backflow_old.export']);
Route::post('/backflow_old/export/client/{id:[0-9]+}', ['uses' => 'BackflowOldController@exportClient', 'as' => 'backflow_old.export_client']);
Route::post('/backflow_old/export/property/{id:[0-9]+}', ['uses' => 'BackflowOldController@exportProperty', 'as' => 'backflow_old.export_property']);

Route::get('/backflow_models', ['uses' => 'BackflowModelController@index', 'as' => 'backflow_model.index']);
Route::post('/backflow_model', ['uses' => 'BackflowModelController@create', 'as' => 'backflow_model.create']);
Route::get('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@read', 'as' => 'backflow_model.read']);
Route::patch('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@update', 'as' => 'backflow_model.update']);
Route::delete('/backflow_model/{id:[0-9]+}', ['uses' => 'BackflowModelController@delete', 'as' => 'backflow_model.delete']);

Route::get('/backflow_test_reports', ['uses' => 'BackflowTestReportController@index', 'as' => 'backflow_test_report.index']);
Route::post('/backflow_test_report', ['uses' => 'BackflowTestReportController@create', 'as' => 'backflow_test_report.create']);
Route::get('/backflow_test_report/{id:[0-9]+}', ['uses' => 'BackflowTestReportController@read', 'as' => 'backflow_test_report.read']);
Route::patch('/backflow_test_report/{id:[0-9]+}', ['uses' => 'BackflowTestReportController@update', 'as' => 'backflow_test_report.update']);
Route::delete('/backflow_test_report/{id:[0-9]+}', ['uses' => 'BackflowTestReportController@delete', 'as' => 'backflow_test_report.delete']);
Route::get('/backflow_test_report/{id:[0-9]+}/pdf', ['uses' => 'BackflowTestReportController@pdf', 'as' => 'backflow_test_report.pdf']);
Route::get('/backflow_test_report/{id:[0-9]+}/html', ['uses' => 'BackflowTestReportController@html', 'as' => 'backflow_test_report.html']);
Route::get('/backflow_test_reports/pdf', ['uses' => 'BackflowTestReportController@pdfs', 'as' => 'backflow_test_report.pdfs']);
Route::get('/backflow_test_reports/html', ['uses' => 'BackflowTestReportController@htmls', 'as' => 'backflow_test_report.htmls']);

Route::put('/backflow_test_report/{id:[0-9]+}/repairs', ['uses' => 'BackflowTestReportController@updateRepairs', 'as' => 'backflow_test_report.update_repairs']);
Route::put('/backflow_test_report/{id:[0-9]+}/cleanings', ['uses' => 'BackflowTestReportController@updateCleanings', 'as' => 'backflow_test_report.update_cleanings']);

Route::get('/backflow_valves', ['uses' => 'BackflowValveController@index', 'as' => 'backflow_valve.index']);
Route::post('/backflow_valve', ['uses' => 'BackflowValveController@create', 'as' => 'backflow_valve.create']);
Route::get('/backflow_valve/{id:[0-9]+}', ['uses' => 'BackflowValveController@read', 'as' => 'backflow_valve.read']);
Route::patch('/backflow_valve/{id:[0-9]+}', ['uses' => 'BackflowValveController@update', 'as' => 'backflow_valve.update']);
Route::delete('/backflow_valve/{id:[0-9]+}', ['uses' => 'BackflowValveController@delete', 'as' => 'backflow_valve.delete']);

Route::get('/backflow_tests', ['uses' => 'BackflowTestController@index', 'as' => 'backflow_test.index']);
Route::post('/backflow_test', ['uses' => 'BackflowTestController@create', 'as' => 'backflow_test.create']);
Route::get('/backflow_test/{id:[0-9]+}', ['uses' => 'BackflowTestController@read', 'as' => 'backflow_test.read']);
Route::patch('/backflow_test/{id:[0-9]+}', ['uses' => 'BackflowTestController@update', 'as' => 'backflow_test.update']);
Route::delete('/backflow_test/{id:[0-9]+}', ['uses' => 'BackflowTestController@delete', 'as' => 'backflow_test.delete']);

Route::get('/backflow_super_types', ['uses' => 'BackflowSuperTypeController@index', 'as' => 'backflow_super_type.index']);
Route::post('/backflow_super_type', ['uses' => 'BackflowSuperTypeController@create', 'as' => 'backflow_super_type.create']);
Route::get('/backflow_super_type/{id:[0-9]+}', ['uses' => 'BackflowSuperTypeController@read', 'as' => 'backflow_super_type.read']);
Route::patch('/backflow_super_type/{id:[0-9]+}', ['uses' => 'BackflowSuperTypeController@update', 'as' => 'backflow_super_type.update']);
Route::delete('/backflow_super_type/{id:[0-9]+}', ['uses' => 'BackflowSuperTypeController@delete', 'as' => 'backflow_super_type.delete']);

Route::get('/backflow_cleanings', ['uses' => 'BackflowCleaningController@index', 'as' => 'backflow_cleaning.index']);
Route::post('/backflow_cleaning', ['uses' => 'BackflowCleaningController@create', 'as' => 'backflow_cleaning.create']);
Route::get('/backflow_cleaning/{id:[0-9]+}', ['uses' => 'BackflowCleaningController@read', 'as' => 'backflow_cleaning.read']);
Route::patch('/backflow_cleaning/{id:[0-9]+}', ['uses' => 'BackflowCleaningController@update', 'as' => 'backflow_cleaning.update']);
Route::delete('/backflow_cleaning/{id:[0-9]+}', ['uses' => 'BackflowCleaningController@delete', 'as' => 'backflow_cleaning.delete']);

Route::get('/backflow_repairs', ['uses' => 'BackflowRepairController@index', 'as' => 'backflow_repair.index']);
Route::post('/backflow_repair', ['uses' => 'BackflowRepairController@create', 'as' => 'backflow_repair.create']);
Route::get('/backflow_repair/{id:[0-9]+}', ['uses' => 'BackflowRepairController@read', 'as' => 'backflow_repair.read']);
Route::patch('/backflow_repair/{id:[0-9]+}', ['uses' => 'BackflowRepairController@update', 'as' => 'backflow_repair.update']);
Route::delete('/backflow_repair/{id:[0-9]+}', ['uses' => 'BackflowRepairController@delete', 'as' => 'backflow_repair.delete']);

Route::get('/property_units', ['uses' => 'PropertyUnitController@index', 'as' => 'property_unit.index']);
Route::post('/property_unit', ['uses' => 'PropertyUnitController@create', 'as' => 'property_unit.create']);
Route::get('/property_unit/{id:[0-9]+}', ['uses' => 'PropertyUnitController@read', 'as' => 'property_unit.read']);
Route::patch('/property_unit/{id:[0-9]+}', ['uses' => 'PropertyUnitController@update', 'as' => 'property_unit.update']);
Route::delete('/property_unit/{id:[0-9]+}', ['uses' => 'PropertyUnitController@delete', 'as' => 'property_unit.delete']);

Route::get('/phree_books/contacts', 'PhreeBooksController@contacts');
Route::get('/phree_books/addresses', 'PhreeBooksController@addresses');
Route::get('/phree_books/matches', 'PhreeBooksController@matches');
Route::get('/phree_books/tasca', 'PhreeBooksController@tasca');
Route::get('/phree_books/phree_books', 'PhreeBooksController@phreeBooks');

Route::get('/phree_books/clients', 'PhreeBooksController@clients');
Route::post('/phree_books/client/{id:[0-9]+}', 'PhreeBooksController@createClient');
Route::patch('/phree_books/client/{id:[0-9]+}/match', 'PhreeBooksController@matchClient');
Route::post('/phree_books/contact/{id:[0-9]+}', 'PhreeBooksController@createContact');
Route::post('/phree_books/property/{id:[0-9]+}', 'PhreeBooksController@createProperty');
Route::put('/phree_books/client/{id:[0-9]+}', 'PhreeBooksController@updateClient');
Route::put('/phree_books/contact/{id:[0-9]+}', 'PhreeBooksController@updateContact');
Route::put('/phree_books/property/{id:[0-9]+}', 'PhreeBooksController@updateProperty');

Route::get('/irrigation_water_types', ['uses' => 'IrrigationWaterTypeController@index', 'as' => 'irrigation_water_type.index']);
Route::post('/irrigation_water_type', ['uses' => 'IrrigationWaterTypeController@create', 'as' => 'irrigation_water_type.create']);
Route::get('/irrigation_water_type/{id:[0-9]+}', ['uses' => 'IrrigationWaterTypeController@read', 'as' => 'irrigation_water_type.read']);
Route::patch('/irrigation_water_type/{id:[0-9]+}', ['uses' => 'IrrigationWaterTypeController@update', 'as' => 'irrigation_water_type.update']);
Route::delete('/irrigation_water_type/{id:[0-9]+}', ['uses' => 'IrrigationWaterTypeController@delete', 'as' => 'irrigation_water_type.delete']);

Route::get('/irrigation_systems', ['uses' => 'IrrigationSystemController@index', 'as' => 'irrigation_system.index']);
Route::post('/irrigation_system', ['uses' => 'IrrigationSystemController@create', 'as' => 'irrigation_system.create']);
Route::get('/irrigation_system/{id:[0-9]+}', ['uses' => 'IrrigationSystemController@read', 'as' => 'irrigation_system.read']);
Route::patch('/irrigation_system/{id:[0-9]+}', ['uses' => 'IrrigationSystemController@update', 'as' => 'irrigation_system.update']);
Route::delete('/irrigation_system/{id:[0-9]+}', ['uses' => 'IrrigationSystemController@delete', 'as' => 'irrigation_system.delete']);

Route::get('/irrigation_controllers', ['uses' => 'IrrigationControllerController@index', 'as' => 'irrigation_controller.index']);
Route::post('/irrigation_controller', ['uses' => 'IrrigationControllerController@create', 'as' => 'irrigation_controller.create']);
Route::get('/irrigation_controller/{id:[0-9]+}', ['uses' => 'IrrigationControllerController@read', 'as' => 'irrigation_controller.read']);
Route::patch('/irrigation_controller/{id:[0-9]+}', ['uses' => 'IrrigationControllerController@update', 'as' => 'irrigation_controller.update']);
Route::delete('/irrigation_controller/{id:[0-9]+}', ['uses' => 'IrrigationControllerController@delete', 'as' => 'irrigation_controller.delete']);

Route::get('/irrigation_controller_locations', ['uses' => 'IrrigationControllerLocationController@index', 'as' => 'irrigation_controller_location.index']);
Route::post('/irrigation_controller_location', ['uses' => 'IrrigationControllerLocationController@create', 'as' => 'irrigation_controller_location.create']);
Route::get('/irrigation_controller_location/{id:[0-9]+}', ['uses' => 'IrrigationControllerLocationController@read', 'as' => 'irrigation_controller_location.read']);
Route::patch('/irrigation_controller_location/{id:[0-9]+}', ['uses' => 'IrrigationControllerLocationController@update', 'as' => 'irrigation_controller_location.update']);
Route::delete('/irrigation_controller_location/{id:[0-9]+}', ['uses' => 'IrrigationControllerLocationController@delete', 'as' => 'irrigation_controller_location.delete']);

Route::get('/irrigation_system_others', ['uses' => 'IrrigationSystemOtherController@index', 'as' => 'irrigation_system_other.index']);
Route::post('/irrigation_system_other', ['uses' => 'IrrigationSystemOtherController@create', 'as' => 'irrigation_system_other.create']);
Route::get('/irrigation_system_other/{id:[0-9]+}', ['uses' => 'IrrigationSystemOtherController@read', 'as' => 'irrigation_system_other.read']);
Route::patch('/irrigation_system_other/{id:[0-9]+}', ['uses' => 'IrrigationSystemOtherController@update', 'as' => 'irrigation_system_other.update']);
Route::delete('/irrigation_system_other/{id:[0-9]+}', ['uses' => 'IrrigationSystemOtherController@delete', 'as' => 'irrigation_system_other.delete']);

Route::get('/irrigation_controller_others', ['uses' => 'IrrigationControllerOtherController@index', 'as' => 'irrigation_controller_other.index']);
Route::post('/irrigation_controller_other', ['uses' => 'IrrigationControllerOtherController@create', 'as' => 'irrigation_controller_other.create']);
Route::get('/irrigation_controller_other/{id:[0-9]+}', ['uses' => 'IrrigationControllerOtherController@read', 'as' => 'irrigation_controller_other.read']);
Route::patch('/irrigation_controller_other/{id:[0-9]+}', ['uses' => 'IrrigationControllerOtherController@update', 'as' => 'irrigation_controller_other.update']);
Route::delete('/irrigation_controller_other/{id:[0-9]+}', ['uses' => 'IrrigationControllerOtherController@delete', 'as' => 'irrigation_controller_other.delete']);

Route::get('/irrigation_zones', ['uses' => 'IrrigationZoneController@index', 'as' => 'irrigation_zone.index']);
Route::post('/irrigation_zone', ['uses' => 'IrrigationZoneController@create', 'as' => 'irrigation_zone.create']);
Route::get('/irrigation_zone/{id:[0-9]+}', ['uses' => 'IrrigationZoneController@read', 'as' => 'irrigation_zone.read']);
Route::patch('/irrigation_zone/{id:[0-9]+}', ['uses' => 'IrrigationZoneController@update', 'as' => 'irrigation_zone.update']);
Route::delete('/irrigation_zone/{id:[0-9]+}', ['uses' => 'IrrigationZoneController@delete', 'as' => 'irrigation_zone.delete']);

Route::get('/property_accounts', ['uses' => 'PropertyAccountController@index', 'as' => 'property_account.index']);
Route::post('/property_account', ['uses' => 'PropertyAccountController@create', 'as' => 'property_account.create']);
Route::get('/property_account/{id:[0-9]+}', ['uses' => 'PropertyAccountController@read', 'as' => 'property_account.read']);
Route::patch('/property_account/{id:[0-9]+}', ['uses' => 'PropertyAccountController@update', 'as' => 'property_account.update']);
Route::delete('/property_account/{id:[0-9]+}', ['uses' => 'PropertyAccountController@delete', 'as' => 'property_account.delete']);

Route::get('/backflow_pictures', ['uses' => 'BackflowPictureController@index', 'as' => 'backflow_picture.index']);
Route::post('/backflow_picture', ['uses' => 'BackflowPictureController@create', 'as' => 'backflow_picture.create']);
Route::get('/backflow_picture/{id:[0-9]+}', ['uses' => 'BackflowPictureController@read', 'as' => 'backflow_picture.read']);
Route::patch('/backflow_picture/{id:[0-9]+}', ['uses' => 'BackflowPictureController@update', 'as' => 'backflow_picture.update']);
Route::delete('/backflow_picture/{id:[0-9]+}', ['uses' => 'BackflowPictureController@delete', 'as' => 'backflow_picture.delete']);

Route::get('/clock_ins', ['uses' => 'ClockInController@index', 'as' => 'clock_in.index']);
Route::post('/clock_in', ['uses' => 'ClockInController@create', 'as' => 'clock_in.create']);
Route::get('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@read', 'as' => 'clock_in.read']);
Route::patch('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@update', 'as' => 'clock_in.update']);
Route::delete('/clock_in/{id:[0-9]+}', ['uses' => 'ClockInController@delete', 'as' => 'clock_in.delete']);
Route::get('/clock_in/current', ['uses' => 'ClockInController@current', 'as' => 'clock_in.current']);
Route::get('/clock_ins/by_employee', 'ClockInController@by_employee');
Route::post('/clock_in/assigned', ['uses' => 'ClockInController@createAssigned', 'as' => 'clock_in.create_assigned']);
Route::patch('/clock_out/assigned/{id:[0-9]+}', ['uses' => 'ClockInController@clockOutAssigned', 'as' => 'clock_in.update_assigned']);

Route::get('/asset_usage_types', ['uses' => 'AssetUsageTypeController@index', 'as' => 'asset_usage_type.index']);
Route::post('/asset_usage_type', ['uses' => 'AssetUsageTypeController@create', 'as' => 'asset_usage_type.create']);
Route::get('/asset_usage_type/{id:[0-9]+}', ['uses' => 'AssetUsageTypeController@read', 'as' => 'asset_usage_type.read']);
Route::patch('/asset_usage_type/{id:[0-9]+}', ['uses' => 'AssetUsageTypeController@update', 'as' => 'asset_usage_type.update']);
Route::delete('/asset_usage_type/{id:[0-9]+}', ['uses' => 'AssetUsageTypeController@delete', 'as' => 'asset_usage_type.delete']);

Route::get('/assets', ['uses' => 'AssetController@index', 'as' => 'asset.index']);
Route::post('/asset', ['uses' => 'AssetController@create', 'as' => 'asset.create']);
Route::get('/asset/{id:[0-9]+}', ['uses' => 'AssetController@read', 'as' => 'asset.read']);
Route::get('/asset/number/{number:[0-9A-Z]+}', ['uses' => 'AssetController@readNumber', 'as' => 'asset.read_number']);
Route::patch('/asset/{id:[0-9]+}', ['uses' => 'AssetController@update', 'as' => 'asset.update']);
Route::delete('/asset/{id:[0-9]+}', ['uses' => 'AssetController@delete', 'as' => 'asset.delete']);
Route::post('/asset/{id:[0-9]+}/export', ['uses' => 'AssetController@createExport', 'as' => 'asset.create.export']);
Route::get('/assets/unique/{field:\w+}', ['uses' => 'AssetController@unique', 'as' => 'asset.unique']);

Route::get('/asset_fuelings', ['uses' => 'AssetFuelingController@index', 'as' => 'asset_fueling.index']);
Route::post('/asset_fueling', ['uses' => 'AssetFuelingController@create', 'as' => 'asset_fueling.create']);
Route::get('/asset_fueling/{id:[0-9]+}', ['uses' => 'AssetFuelingController@read', 'as' => 'asset_fueling.read']);
Route::get('/asset_fueling/last', ['uses' => 'AssetFuelingController@last', 'as' => 'asset_fueling.last']);
Route::patch('/asset_fueling/{id:[0-9]+}', ['uses' => 'AssetFuelingController@update', 'as' => 'asset_fueling.update']);
Route::delete('/asset_fueling/{id:[0-9]+}', ['uses' => 'AssetFuelingController@delete', 'as' => 'asset_fueling.delete']);

Route::get('/asset_parts', ['uses' => 'AssetPartController@index', 'as' => 'asset_part.index']);
Route::post('/asset_part', ['uses' => 'AssetPartController@create', 'as' => 'asset_part.create']);
Route::get('/asset_part/{id:[0-9]+}', ['uses' => 'AssetPartController@read', 'as' => 'asset_part.read']);
Route::patch('/asset_part/{id:[0-9]+}', ['uses' => 'AssetPartController@update', 'as' => 'asset_part.update']);
Route::delete('/asset_part/{id:[0-9]+}', ['uses' => 'AssetPartController@delete', 'as' => 'asset_part.delete']);

Route::get('/asset_repairs', ['uses' => 'AssetRepairController@index', 'as' => 'asset_repair.index']);
Route::post('/asset_repair', ['uses' => 'AssetRepairController@create', 'as' => 'asset_repair.create']);
Route::get('/asset_repair/{id:[0-9]+}', ['uses' => 'AssetRepairController@read', 'as' => 'asset_repair.read']);
Route::patch('/asset_repair/{id:[0-9]+}', ['uses' => 'AssetRepairController@update', 'as' => 'asset_repair.update']);
Route::delete('/asset_repair/{id:[0-9]+}', ['uses' => 'AssetRepairController@delete', 'as' => 'asset_repair.delete']);
Route::get('/asset_repairs/unique/{field:\w+}', ['uses' => 'AssetRepairController@unique', 'as' => 'asset_repair.unique']);

Route::get('/asset_service_types', ['uses' => 'AssetServiceTypeController@index', 'as' => 'asset_service_type.index']);
Route::post('/asset_service_type', ['uses' => 'AssetServiceTypeController@create', 'as' => 'asset_service_type.create']);
Route::get('/asset_service_type/{id:[0-9]+}', ['uses' => 'AssetServiceTypeController@read', 'as' => 'asset_service_type.read']);
Route::patch('/asset_service_type/{id:[0-9]+}', ['uses' => 'AssetServiceTypeController@update', 'as' => 'asset_service_type.update']);
Route::delete('/asset_service_type/{id:[0-9]+}', ['uses' => 'AssetServiceTypeController@delete', 'as' => 'asset_service_type.delete']);

Route::get('/asset_services', ['uses' => 'AssetServiceController@index', 'as' => 'asset_service.index']);
Route::post('/asset_service', ['uses' => 'AssetServiceController@create', 'as' => 'asset_service.create']);
Route::get('/asset_service/{id:[0-9]+}', ['uses' => 'AssetServiceController@read', 'as' => 'asset_service.read']);
Route::patch('/asset_service/{id:[0-9]+}', ['uses' => 'AssetServiceController@update', 'as' => 'asset_service.update']);
Route::delete('/asset_service/{id:[0-9]+}', ['uses' => 'AssetServiceController@delete', 'as' => 'asset_service.delete']);

Route::get('/asset_maintenances', ['uses' => 'AssetMaintenanceController@index', 'as' => 'asset_maintenance.index']);
Route::post('/asset_maintenance', ['uses' => 'AssetMaintenanceController@create', 'as' => 'asset_maintenance.create']);
Route::get('/asset_maintenance/{id:[0-9]+}', ['uses' => 'AssetMaintenanceController@read', 'as' => 'asset_maintenance.read']);
Route::get('/asset_maintenance/last/', ['uses' => 'AssetMaintenanceController@last', 'as' => 'asset_maintenance.last']);
Route::patch('/asset_maintenance/{id:[0-9]+}', ['uses' => 'AssetMaintenanceController@update', 'as' => 'asset_maintenance.update']);
Route::delete('/asset_maintenance/{id:[0-9]+}', ['uses' => 'AssetMaintenanceController@delete', 'as' => 'asset_maintenance.delete']);
Route::get('/asset_maintenances/unique/{field:\w+}', ['uses' => 'AssetMaintenanceController@unique', 'as' => 'asset_maintenance.unique']);

Route::get('/asset_units', ['uses' => 'AssetUnitController@index', 'as' => 'asset_unit.index']);
Route::post('/asset_unit', ['uses' => 'AssetUnitController@create', 'as' => 'asset_unit.create']);
Route::get('/asset_unit/{id:[0-9]+}', ['uses' => 'AssetUnitController@read', 'as' => 'asset_unit.read']);
Route::patch('/asset_unit/{id:[0-9]+}', ['uses' => 'AssetUnitController@update', 'as' => 'asset_unit.update']);
Route::delete('/asset_unit/{id:[0-9]+}', ['uses' => 'AssetUnitController@delete', 'as' => 'asset_unit.delete']);

Route::get('/roles', ['uses' => 'RoleController@index', 'as' => 'role.index']);
Route::post('/role', ['uses' => 'RoleController@create', 'as' => 'role.create']);
Route::get('/role/{id:[0-9]+}', ['uses' => 'RoleController@read', 'as' => 'role.read']);
Route::patch('/role/{id:[0-9]+}', ['uses' => 'RoleController@update', 'as' => 'role.update']);
Route::delete('/role/{id:[0-9]+}', ['uses' => 'RoleController@delete', 'as' => 'role.delete']);
Route::put('/role/{id:[0-9]+}/permissions', ['uses' => 'RoleController@updatePermissions', 'as' => 'role.update.permissions']);

Route::get('/asset_time_units', ['uses' => 'AssetTimeUnitController@index', 'as' => 'asset_time_unit.index']);
Route::post('/asset_time_unit', ['uses' => 'AssetTimeUnitController@create', 'as' => 'asset_time_unit.create']);
Route::get('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@read', 'as' => 'asset_time_unit.read']);
Route::patch('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@update', 'as' => 'asset_time_unit.update']);
Route::delete('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@delete', 'as' => 'asset_time_unit.delete']);

Route::get('/asset_time_units', ['uses' => 'AssetTimeUnitController@index', 'as' => 'asset_time_unit.index']);
Route::post('/asset_time_unit', ['uses' => 'AssetTimeUnitController@create', 'as' => 'asset_time_unit.create']);
Route::get('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@read', 'as' => 'asset_time_unit.read']);
Route::patch('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@update', 'as' => 'asset_time_unit.update']);
Route::delete('/asset_time_unit/{id:[0-9]+}', ['uses' => 'AssetTimeUnitController@delete', 'as' => 'asset_time_unit.delete']);

Route::get('/asset_homes', ['uses' => 'AssetHomeController@index', 'as' => 'asset_home.index']);
Route::post('/asset_home', ['uses' => 'AssetHomeController@create', 'as' => 'asset_home.create']);
Route::get('/asset_home/{id:[0-9]+}', ['uses' => 'AssetHomeController@read', 'as' => 'asset_home.read']);
Route::patch('/asset_home/{id:[0-9]+}', ['uses' => 'AssetHomeController@update', 'as' => 'asset_home.update']);
Route::delete('/asset_home/{id:[0-9]+}', ['uses' => 'AssetHomeController@delete', 'as' => 'asset_home.delete']);

Route::get('/asset_pictures', ['uses' => 'AssetPictureController@index', 'as' => 'asset_picture.index']);
Route::post('/asset_picture', ['uses' => 'AssetPictureController@create', 'as' => 'asset_picture.create']);
Route::get('/asset_picture/{id:[0-9]+}', ['uses' => 'AssetPictureController@read', 'as' => 'asset_picture.read']);
Route::patch('/asset_picture/{id:[0-9]+}', ['uses' => 'AssetPictureController@update', 'as' => 'asset_picture.update']);
Route::delete('/asset_picture/{id:[0-9]+}', ['uses' => 'AssetPictureController@delete', 'as' => 'asset_picture.delete']);

Route::get('/asset_appraisals', ['uses' => 'AssetAppraisalController@index', 'as' => 'asset_appraisal.index']);
Route::post('/asset_appraisal', ['uses' => 'AssetAppraisalController@create', 'as' => 'asset_appraisal.create']);
Route::get('/asset_appraisal/{id:[0-9]+}', ['uses' => 'AssetAppraisalController@read', 'as' => 'asset_appraisal.read']);
Route::patch('/asset_appraisal/{id:[0-9]+}', ['uses' => 'AssetAppraisalController@update', 'as' => 'asset_appraisal.update']);
Route::delete('/asset_appraisal/{id:[0-9]+}', ['uses' => 'AssetAppraisalController@delete', 'as' => 'asset_appraisal.delete']);

Route::get('/asset_improvements', ['uses' => 'AssetImprovementController@index', 'as' => 'asset_improvement.index']);
Route::post('/asset_improvement', ['uses' => 'AssetImprovementController@create', 'as' => 'asset_improvement.create']);
Route::get('/asset_improvement/{id:[0-9]+}', ['uses' => 'AssetImprovementController@read', 'as' => 'asset_improvement.read']);
Route::patch('/asset_improvement/{id:[0-9]+}', ['uses' => 'AssetImprovementController@update', 'as' => 'asset_improvement.update']);
Route::delete('/asset_improvement/{id:[0-9]+}', ['uses' => 'AssetImprovementController@delete', 'as' => 'asset_improvement.delete']);

Route::get('/permissions', ['uses' => 'PermissionController@index', 'as' => 'permission.index']);
Route::post('/permission', ['uses' => 'PermissionController@create', 'as' => 'permission.create']);
Route::get('/permission/{id:[0-9]+}', ['uses' => 'PermissionController@read', 'as' => 'permission.read']);
Route::patch('/permission/{id:[0-9]+}', ['uses' => 'PermissionController@update', 'as' => 'permission.update']);
Route::delete('/permission/{id:[0-9]+}', ['uses' => 'PermissionController@delete', 'as' => 'permission.delete']);

Route::get('/appointments', ['uses' => 'AppointmentController@index', 'as' => 'appointment.index']);
Route::post('/appointment', ['uses' => 'AppointmentController@create', 'as' => 'appointment.create']);
Route::get('/appointment/{id:[0-9]+}', ['uses' => 'AppointmentController@read', 'as' => 'appointment.read']);
Route::patch('/appointment/{id:[0-9]+}', ['uses' => 'AppointmentController@update', 'as' => 'appointment.update']);
Route::delete('/appointment/{id:[0-9]+}', ['uses' => 'AppointmentController@delete', 'as' => 'appointment.delete']);
Route::get('/schedule', 'AppointmentController@schedule');

Route::get('/labor_types', ['uses' => 'LaborTypeController@index', 'as' => 'labor_type.index']);
Route::post('/labor_type', ['uses' => 'LaborTypeController@create', 'as' => 'labor_type.create']);
Route::get('/labor_type/{id:[0-9]+}', ['uses' => 'LaborTypeController@read', 'as' => 'labor_type.read']);
Route::patch('/labor_type/{id:[0-9]+}', ['uses' => 'LaborTypeController@update', 'as' => 'labor_type.update']);
Route::delete('/labor_type/{id:[0-9]+}', ['uses' => 'LaborTypeController@delete', 'as' => 'labor_type.delete']);

Route::get('/labor_activities', ['uses' => 'LaborActivityController@index', 'as' => 'labor_activity.index']);
Route::post('/labor_activity', ['uses' => 'LaborActivityController@create', 'as' => 'labor_activity.create']);
Route::get('/labor_activity/{id:[0-9]+}', ['uses' => 'LaborActivityController@read', 'as' => 'labor_activity.read']);
Route::patch('/labor_activity/{id:[0-9]+}', ['uses' => 'LaborActivityController@update', 'as' => 'labor_activity.update']);
Route::delete('/labor_activity/{id:[0-9]+}', ['uses' => 'LaborActivityController@delete', 'as' => 'labor_activity.delete']);

Route::get('/labor_assignments', ['uses' => 'LaborAssignmentController@index', 'as' => 'labor_assignment.index']);
Route::post('/labor_assignment', ['uses' => 'LaborAssignmentController@create', 'as' => 'labor_assignment.create']);
Route::get('/labor_assignment/{id:[0-9]+}', ['uses' => 'LaborAssignmentController@read', 'as' => 'labor_assignment.read']);
Route::patch('/labor_assignment/{id:[0-9]+}', ['uses' => 'LaborAssignmentController@update', 'as' => 'labor_assignment.update']);
Route::delete('/labor_assignment/{id:[0-9]+}', ['uses' => 'LaborAssignmentController@delete', 'as' => 'labor_assignment.delete']);
Route::put('/labor_assignment/{id:[0-9]+}/labor_activities', ['uses' => 'LaborAssignmentController@updateLaborActivities', 'as' => 'labor_assignment.update.labor_activities']);

Route::get('/task_actions', ['uses' => 'TaskActionController@index', 'as' => 'task_action.index']);
Route::post('/task_action', ['uses' => 'TaskActionController@create', 'as' => 'task_action.create']);
Route::get('/task_action/{id:[0-9]+}', ['uses' => 'TaskActionController@read', 'as' => 'task_action.read']);
Route::patch('/task_action/{id:[0-9]+}', ['uses' => 'TaskActionController@update', 'as' => 'task_action.update']);
Route::delete('/task_action/{id:[0-9]+}', ['uses' => 'TaskActionController@delete', 'as' => 'task_action.delete']);

Route::get('/asset_categories', ['uses' => 'AssetCategoryController@index', 'as' => 'asset_category.index']);
Route::post('/asset_category', ['uses' => 'AssetCategoryController@create', 'as' => 'asset_category.create']);
Route::get('/asset_category/{id:[0-9]+}', ['uses' => 'AssetCategoryController@read', 'as' => 'asset_category.read']);
Route::patch('/asset_category/{id:[0-9]+}', ['uses' => 'AssetCategoryController@update', 'as' => 'asset_category.update']);
Route::delete('/asset_category/{id:[0-9]+}', ['uses' => 'AssetCategoryController@delete', 'as' => 'asset_category.delete']);

Route::get('/asset_brands', ['uses' => 'AssetBrandController@index', 'as' => 'asset_brand.index']);
Route::post('/asset_brand', ['uses' => 'AssetBrandController@create', 'as' => 'asset_brand.create']);
Route::get('/asset_brand/{id:[0-9]+}', ['uses' => 'AssetBrandController@read', 'as' => 'asset_brand.read']);
Route::patch('/asset_brand/{id:[0-9]+}', ['uses' => 'AssetBrandController@update', 'as' => 'asset_brand.update']);
Route::delete('/asset_brand/{id:[0-9]+}', ['uses' => 'AssetBrandController@delete', 'as' => 'asset_brand.delete']);

Route::get('/asset_types', ['uses' => 'AssetTypeController@index', 'as' => 'asset_type.index']);
Route::post('/asset_type', ['uses' => 'AssetTypeController@create', 'as' => 'asset_type.create']);
Route::get('/asset_type/{id:[0-9]+}', ['uses' => 'AssetTypeController@read', 'as' => 'asset_type.read']);
Route::patch('/asset_type/{id:[0-9]+}', ['uses' => 'AssetTypeController@update', 'as' => 'asset_type.update']);
Route::delete('/asset_type/{id:[0-9]+}', ['uses' => 'AssetTypeController@delete', 'as' => 'asset_type.delete']);

Route::get('/asset_groups', ['uses' => 'AssetGroupController@index', 'as' => 'asset_group.index']);
Route::post('/asset_group', ['uses' => 'AssetGroupController@create', 'as' => 'asset_group.create']);
Route::get('/asset_group/{id:[0-9]+}', ['uses' => 'AssetGroupController@read', 'as' => 'asset_group.read']);
Route::patch('/asset_group/{id:[0-9]+}', ['uses' => 'AssetGroupController@update', 'as' => 'asset_group.update']);
Route::delete('/asset_group/{id:[0-9]+}', ['uses' => 'AssetGroupController@delete', 'as' => 'asset_group.delete']);

Route::get('/asset_subs', ['uses' => 'AssetSubController@index', 'as' => 'asset_sub.index']);
Route::post('/asset_sub', ['uses' => 'AssetSubController@create', 'as' => 'asset_sub.create']);
Route::get('/asset_sub/{id:[0-9]+}', ['uses' => 'AssetSubController@read', 'as' => 'asset_sub.read']);
Route::patch('/asset_sub/{id:[0-9]+}', ['uses' => 'AssetSubController@update', 'as' => 'asset_sub.update']);
Route::delete('/asset_sub/{id:[0-9]+}', ['uses' => 'AssetSubController@delete', 'as' => 'asset_sub.delete']);

Route::get('/asset_accessories', ['uses' => 'AssetAccessoryController@index', 'as' => 'asset_accessory.index']);
Route::post('/asset_accessory', ['uses' => 'AssetAccessoryController@create', 'as' => 'asset_accessory.create']);
Route::get('/asset_accessory/{id:[0-9]+}', ['uses' => 'AssetAccessoryController@read', 'as' => 'asset_accessory.read']);
Route::patch('/asset_accessory/{id:[0-9]+}', ['uses' => 'AssetAccessoryController@update', 'as' => 'asset_accessory.update']);
Route::delete('/asset_accessory/{id:[0-9]+}', ['uses' => 'AssetAccessoryController@delete', 'as' => 'asset_accessory.delete']);

Route::get('/stock_text_messages', ['uses' => 'StockTextMessageController@index', 'as' => 'stock_text_message.index']);
Route::post('/stock_text_message', ['uses' => 'StockTextMessageController@create', 'as' => 'stock_text_message.create']);
Route::get('/stock_text_message/{id:[0-9]+}', ['uses' => 'StockTextMessageController@read', 'as' => 'stock_text_message.read']);
Route::patch('/stock_text_message/{id:[0-9]+}', ['uses' => 'StockTextMessageController@update', 'as' => 'stock_text_message.update']);
Route::delete('/stock_text_message/{id:[0-9]+}', ['uses' => 'StockTextMessageController@delete', 'as' => 'stock_text_message.delete']);

Route::get('/sms_message_types', ['uses' => 'SmsMessageTypeController@index', 'as' => 'sms_message_type.index']);
Route::post('/sms_message_type', ['uses' => 'SmsMessageTypeController@create', 'as' => 'sms_message_type.create']);
Route::get('/sms_message_type/{id:[0-9]+}', ['uses' => 'SmsMessageTypeController@read', 'as' => 'sms_message_type.read']);
Route::patch('/sms_message_type/{id:[0-9]+}', ['uses' => 'SmsMessageTypeController@update', 'as' => 'sms_message_type.update']);
Route::delete('/sms_message_type/{id:[0-9]+}', ['uses' => 'SmsMessageTypeController@delete', 'as' => 'sms_message_type.delete']);

Route::get('/partial_text_message_types', ['uses' => 'PartialTextMessageTypeController@index', 'as' => 'partial_text_message_type.index']);
Route::post('/partial_text_message_type', ['uses' => 'PartialTextMessageTypeController@create', 'as' => 'partial_text_message_type.create']);
Route::get('/partial_text_message_type/{id:[0-9]+}', ['uses' => 'PartialTextMessageTypeController@read', 'as' => 'partial_text_message_type.read']);
Route::patch('/partial_text_message_type/{id:[0-9]+}', ['uses' => 'PartialTextMessageTypeController@update', 'as' => 'partial_text_message_type.update']);
Route::delete('/partial_text_message_type/{id:[0-9]+}', ['uses' => 'PartialTextMessageTypeController@delete', 'as' => 'partial_text_message_type.delete']);

Route::get('/partial_text_messages', ['uses' => 'PartialTextMessageController@index', 'as' => 'partial_text_message.index']);
Route::post('/partial_text_message', ['uses' => 'PartialTextMessageController@create', 'as' => 'partial_text_message.create']);
Route::get('/partial_text_message/{id:[0-9]+}', ['uses' => 'PartialTextMessageController@read', 'as' => 'partial_text_message.read']);
Route::patch('/partial_text_message/{id:[0-9]+}', ['uses' => 'PartialTextMessageController@update', 'as' => 'partial_text_message.update']);
Route::delete('/partial_text_message/{id:[0-9]+}', ['uses' => 'PartialTextMessageController@delete', 'as' => 'partial_text_message.delete']);
