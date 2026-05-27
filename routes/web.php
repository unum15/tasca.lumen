<?php

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
Route::get('/activity_level/{id}', 'ActivityLevelController@read');
Route::patch('/activity_level/{id}', 'ActivityLevelController@update');
Route::delete('/activity_level/{id}', 'ActivityLevelController@delete');

Route::get('/client_types', 'ClientTypeController@index');
Route::post('/client_type', 'ClientTypeController@create');
Route::get('/client_type/{id}', 'ClientTypeController@read');
Route::patch('/client_type/{id}', 'ClientTypeController@update');
Route::delete('/client_type/{id}', 'ClientTypeController@delete');

Route::get('/contact_methods', 'ContactMethodController@index');
Route::post('/contact_method', 'ContactMethodController@create');
Route::get('/contact_method/{id}', 'ContactMethodController@read');
Route::patch('/contact_method/{id}', 'ContactMethodController@update');
Route::delete('/contact_method/{id}', 'ContactMethodController@delete');

Route::get('/contact_types', 'ContactTypeController@index');
Route::post('/contact_type', 'ContactTypeController@create');
Route::get('/contact_type/{id}', 'ContactTypeController@read');
Route::patch('/contact_type/{id}', 'ContactTypeController@update');
Route::delete('/contact_type/{id}', 'ContactTypeController@delete');

Route::get('/crews', 'CrewController@index');
Route::post('/crew', 'CrewController@create');
Route::get('/crew/{id}', 'CrewController@read');
Route::patch('/crew/{id}', 'CrewController@update');
Route::delete('/crew/{id}', 'CrewController@delete');

Route::get('/email_types', 'EmailTypeController@index');
Route::post('/email_type', 'EmailTypeController@create');
Route::get('/email_type/{id}', 'EmailTypeController@read');
Route::patch('/email_type/{id}', 'EmailTypeController@update');
Route::delete('/email_type/{id}', 'EmailTypeController@delete');

Route::get('/phone_number_types', 'PhoneNumberTypeController@index');
Route::post('/phone_number_type', 'PhoneNumberTypeController@create');
Route::get('/phone_number_type/{id}', 'PhoneNumberTypeController@read');
Route::patch('/phone_number_type/{id}', 'PhoneNumberTypeController@update');
Route::delete('/phone_number_type/{id}', 'PhoneNumberTypeController@delete');

Route::get('/property_types', 'PropertyTypeController@index');
Route::post('/property_type', 'PropertyTypeController@create');
Route::get('/property_type/{id}', 'PropertyTypeController@read');
Route::patch('/property_type/{id}', 'PropertyTypeController@update');
Route::delete('/property_type/{id}', 'PropertyTypeController@delete');

Route::get('/order_actions', 'OrderActionController@index');
Route::post('/order_action', 'OrderActionController@create');
Route::get('/order_action/{id}', 'OrderActionController@read');
Route::patch('/order_action/{id}', 'OrderActionController@update');
Route::delete('/order_action/{id}', 'OrderActionController@delete');

Route::get('/order_priorities', 'OrderPriorityController@index');
Route::post('/order_priority', 'OrderPriorityController@create');
Route::get('/order_priority/{id}', 'OrderPriorityController@read');
Route::patch('/order_priority/{id}', 'OrderPriorityController@update');
Route::delete('/order_priority/{id}', 'OrderPriorityController@delete');

Route::get('/order_categories', 'OrderCategoryController@index');
Route::post('/order_category', 'OrderCategoryController@create');
Route::get('/order_category/{id}', 'OrderCategoryController@read');
Route::patch('/order_category/{id}', 'OrderCategoryController@update');
Route::delete('/order_category/{id}', 'OrderCategoryController@delete');

Route::get('/order_statuses', 'OrderStatusController@index');
Route::post('/order_status', 'OrderStatusController@create');
Route::get('/order_status/{id}', 'OrderStatusController@read');
Route::patch('/order_status/{id}', 'OrderStatusController@update');
Route::delete('/order_status/{id}', 'OrderStatusController@delete');

Route::get('/order_status_types', 'OrderStatusTypeController@index');
Route::post('/order_status_type', 'OrderStatusTypeController@create');
Route::get('/order_status_type/{id}', 'OrderStatusTypeController@read');
Route::patch('/order_status_type/{id}', 'OrderStatusTypeController@update');
Route::delete('/order_status_type/{id}', 'OrderStatusTypeController@delete');

Route::get('/order_types', 'OrderTypeController@index');
Route::post('/order_type', 'OrderTypeController@create');
Route::get('/order_type/{id}', 'OrderTypeController@read');
Route::patch('/order_type/{id}', 'OrderTypeController@update');
Route::delete('/order_type/{id}', 'OrderTypeController@delete');

Route::get('/task_statuses', 'TaskStatusController@index');
Route::post('/task_status', 'TaskStatusController@create');
Route::get('/task_status/{id}', 'TaskStatusController@read');
Route::patch('/task_status/{id}', 'TaskStatusController@update');
Route::delete('/task_status/{id}', 'TaskStatusController@delete');

Route::get('/appointment_statuses', 'AppointmentStatusController@index');
Route::post('/appointment_status', 'AppointmentStatusController@create');
Route::get('/appointment_status/{id}', 'AppointmentStatusController@read');
Route::patch('/appointment_status/{id}', 'AppointmentStatusController@update');
Route::delete('/appointment_status/{id}', 'AppointmentStatusController@delete');

Route::get('/clients', 'ClientController@index');
Route::post('/client', 'ClientController@create');
Route::get('/client/{id}', 'ClientController@read');
Route::patch('/client/{id}', 'ClientController@update');
Route::delete('/client/{id}', 'ClientController@delete');
Route::get('/clients/unique/{field:\w+}', ['uses' => 'ClientController@unique', 'as' => 'client.unique']);
Route::post('/client/{id}/properties', 'ClientController@addProperty');
Route::delete('/client/{id}/property/{property_id}', 'ClientController@deleteProperty');

Route::get('/contacts', 'ContactController@index');
Route::post('/contact', 'ContactController@create');
Route::get('/contact/{id}', 'ContactController@read');
Route::patch('/contact/{id}', 'ContactController@update');
Route::post('/contact/{id}/account', 'ContactController@createAccount');
Route::put('/contact/{id}/roles', 'ContactController@updateRoles');
Route::delete('/contact/{id}', 'ContactController@delete');

Route::get('/emails', 'EmailController@index');
Route::post('/email', 'EmailController@create');
Route::get('/email/{id}', 'EmailController@read');
Route::patch('/email/{id}', 'EmailController@update');
Route::delete('/email/{id}', 'EmailController@delete');

Route::get('/phone_numbers', 'PhoneNumberController@index');
Route::post('/phone_number', 'PhoneNumberController@create');
Route::get('/phone_number/{id}', 'PhoneNumberController@read');
Route::patch('/phone_number/{id}', 'PhoneNumberController@update');
Route::delete('/phone_number/{id}', 'PhoneNumberController@delete');

Route::get('/projects', 'ProjectController@index');
Route::post('/project', 'ProjectController@create');
Route::get('/project/{id}', 'ProjectController@read');
Route::patch('/project/{id}', 'ProjectController@update');
Route::delete('/project/{id}', 'ProjectController@delete');
Route::get('/projects/unique/{field:\w+}', ['uses' => 'ProjectController@unique', 'as' => 'project.unique']);

Route::get('/properties', 'PropertyController@index');
Route::post('/property', 'PropertyController@create');
Route::get('/property/{id}', 'PropertyController@read');
Route::patch('/property/{id}', 'PropertyController@update');
Route::delete('/property/{id}', 'PropertyController@delete');

Route::get('/orders', 'OrderController@index');
Route::post('/order', 'OrderController@create');
Route::post('/order/convert/{id}', 'OrderController@convert');
Route::get('/order/{id}', 'OrderController@read');
Route::patch('/order/{id}', 'OrderController@update');
Route::delete('/order/{id}', 'OrderController@delete');
Route::get('/orders/closable', 'OrderController@closable');
Route::get('/orders/unique/{field:\w+}', ['uses' => 'OrderController@unique', 'as' => 'order.unique']);

Route::get('/tasks', 'TaskController@index');
Route::post('/task', 'TaskController@create');
Route::get('/task/{id}', 'TaskController@read');
Route::patch('/task/{id}', 'TaskController@update');
Route::delete('/task/{id}', 'TaskController@delete');
Route::get('/tasks/unique/{field:\w+}', ['uses' => 'TaskController@unique', 'as' => 'task.unique']);

Route::get('/settings', 'SettingController@index');
Route::post('/settings', 'SettingController@create');
Route::patch('/settings', 'SettingController@update');

Route::get('/calendar/status', 'GoogleCalendarController@status');
Route::get('/calendar/url', 'GoogleCalendarController@url');
Route::post('/calendar/callback', 'GoogleCalendarController@callback');

Route::get('/google/status', 'GoogleController@status');
Route::get('/google/url', 'GoogleController@url');
Route::post('/google/callback', 'GoogleController@callback');


Route::get('/backflow_valve_parts', ['uses' => 'BackflowValvePartController@index', 'as' => 'backflow_valve_part.index']);
Route::post('/backflow_valve_part', ['uses' => 'BackflowValvePartController@create', 'as' => 'backflow_valve_part.create']);
Route::get('/backflow_valve_part/{id}', ['uses' => 'BackflowValvePartController@read', 'as' => 'backflow_valve_part.read']);
Route::patch('/backflow_valve_part/{id}', ['uses' => 'BackflowValvePartController@update', 'as' => 'backflow_valve_part.update']);
Route::delete('/backflow_valve_part/{id}', ['uses' => 'BackflowValvePartController@delete', 'as' => 'backflow_valve_part.delete']);

Route::get('/backflow_water_systems', ['uses' => 'BackflowWaterSystemController@index', 'as' => 'backflow_water_system.index']);
Route::post('/backflow_water_system', ['uses' => 'BackflowWaterSystemController@create', 'as' => 'backflow_water_system.create']);
Route::get('/backflow_water_system/{id}', ['uses' => 'BackflowWaterSystemController@read', 'as' => 'backflow_water_system.read']);
Route::patch('/backflow_water_system/{id}', ['uses' => 'BackflowWaterSystemController@update', 'as' => 'backflow_water_system.update']);
Route::delete('/backflow_water_system/{id}', ['uses' => 'BackflowWaterSystemController@delete', 'as' => 'backflow_water_system.delete']);

Route::get('/backflow_manufacturers', ['uses' => 'BackflowManufacturerController@index', 'as' => 'backflow_manufacturer.index']);
Route::post('/backflow_manufacturer', ['uses' => 'BackflowManufacturerController@create', 'as' => 'backflow_manufacturer.create']);
Route::get('/backflow_manufacturer/{id}', ['uses' => 'BackflowManufacturerController@read', 'as' => 'backflow_manufacturer.read']);
Route::patch('/backflow_manufacturer/{id}', ['uses' => 'BackflowManufacturerController@update', 'as' => 'backflow_manufacturer.update']);
Route::delete('/backflow_manufacturer/{id}', ['uses' => 'BackflowManufacturerController@delete', 'as' => 'backflow_manufacturer.delete']);

Route::get('/backflow_models', ['uses' => 'BackflowModelController@index', 'as' => 'backflow_model.index']);
Route::post('/backflow_model', ['uses' => 'BackflowModelController@create', 'as' => 'backflow_model.create']);
Route::get('/backflow_model/{id}', ['uses' => 'BackflowModelController@read', 'as' => 'backflow_model.read']);
Route::patch('/backflow_model/{id}', ['uses' => 'BackflowModelController@update', 'as' => 'backflow_model.update']);
Route::delete('/backflow_model/{id}', ['uses' => 'BackflowModelController@delete', 'as' => 'backflow_model.delete']);

Route::get('/backflow_types', ['uses' => 'BackflowTypeController@index', 'as' => 'backflow_type.index']);
Route::post('/backflow_type', ['uses' => 'BackflowTypeController@create', 'as' => 'backflow_type.create']);
Route::get('/backflow_type/{id}', ['uses' => 'BackflowTypeController@read', 'as' => 'backflow_type.read']);
Route::patch('/backflow_type/{id}', ['uses' => 'BackflowTypeController@update', 'as' => 'backflow_type.update']);
Route::delete('/backflow_type/{id}', ['uses' => 'BackflowTypeController@delete', 'as' => 'backflow_type.delete']);

Route::get('/backflow_assemblies', ['uses' => 'BackflowAssemblyController@index', 'as' => 'backflow_assembly.index']);
Route::post('/backflow_assembly', ['uses' => 'BackflowAssemblyController@create', 'as' => 'backflow_assembly.create']);
Route::get('/backflow_assembly/{id}', ['uses' => 'BackflowAssemblyController@read', 'as' => 'backflow_assembly.read']);
Route::patch('/backflow_assembly/{id}', ['uses' => 'BackflowAssemblyController@update', 'as' => 'backflow_assembly.update']);
Route::delete('/backflow_assembly/{id}', ['uses' => 'BackflowAssemblyController@delete', 'as' => 'backflow_assembly.delete']);
Route::get('/backflow_assembly/unique/{field:\w+}', ['uses' => 'BackflowAssemblyController@unique', 'as' => 'backflow_assembly.unique']);
Route::get('/backflow_assemblies/tags/pdf', ['uses' => 'BackflowAssemblyController@tagsPdf', 'as' => 'backflow_assembly.tags_pdf']);

Route::get('/backflow_sizes', ['uses' => 'BackflowSizeController@index', 'as' => 'backflow_size.index']);
Route::post('/backflow_size', ['uses' => 'BackflowSizeController@create', 'as' => 'backflow_size.create']);
Route::get('/backflow_size/{id}', ['uses' => 'BackflowSizeController@read', 'as' => 'backflow_size.read']);
Route::patch('/backflow_size/{id}', ['uses' => 'BackflowSizeController@update', 'as' => 'backflow_size.update']);
Route::delete('/backflow_size/{id}', ['uses' => 'BackflowSizeController@delete', 'as' => 'backflow_size.delete']);

Route::get('/backflow_old', ['uses' => 'BackflowOldController@index', 'as' => 'backflow_old.index']);
Route::post('/backflow_old', ['uses' => 'BackflowOldController@create', 'as' => 'backflow_old.create']);
Route::get('/backflow_old/{id}', ['uses' => 'BackflowOldController@read', 'as' => 'backflow_old.read']);
Route::patch('/backflow_old/{id}', ['uses' => 'BackflowOldController@update', 'as' => 'backflow_old.update']);
Route::delete('/backflow_old/{id}', ['uses' => 'BackflowOldController@delete', 'as' => 'backflow_old.delete']);
Route::get('/backflow_old/zips', ['uses' => 'BackflowOldController@zips', 'as' => 'backflow_old.zips']);
Route::get('/backflow_old/groups', ['uses' => 'BackflowOldController@groups', 'as' => 'backflow_old.groups']);
Route::post('/backflow_old/export/{id}', ['uses' => 'BackflowOldController@export', 'as' => 'backflow_old.export']);
Route::post('/backflow_old/export/client/{id}', ['uses' => 'BackflowOldController@exportClient', 'as' => 'backflow_old.export_client']);
Route::post('/backflow_old/export/property/{id}', ['uses' => 'BackflowOldController@exportProperty', 'as' => 'backflow_old.export_property']);

Route::get('/backflow_models', ['uses' => 'BackflowModelController@index', 'as' => 'backflow_model.index']);
Route::post('/backflow_model', ['uses' => 'BackflowModelController@create', 'as' => 'backflow_model.create']);
Route::get('/backflow_model/{id}', ['uses' => 'BackflowModelController@read', 'as' => 'backflow_model.read']);
Route::patch('/backflow_model/{id}', ['uses' => 'BackflowModelController@update', 'as' => 'backflow_model.update']);
Route::delete('/backflow_model/{id}', ['uses' => 'BackflowModelController@delete', 'as' => 'backflow_model.delete']);

Route::get('/backflow_test_reports', ['uses' => 'BackflowTestReportController@index', 'as' => 'backflow_test_report.index']);
Route::post('/backflow_test_report', ['uses' => 'BackflowTestReportController@create', 'as' => 'backflow_test_report.create']);
Route::get('/backflow_test_report/{id}', ['uses' => 'BackflowTestReportController@read', 'as' => 'backflow_test_report.read']);
Route::patch('/backflow_test_report/{id}', ['uses' => 'BackflowTestReportController@update', 'as' => 'backflow_test_report.update']);
Route::delete('/backflow_test_report/{id}', ['uses' => 'BackflowTestReportController@delete', 'as' => 'backflow_test_report.delete']);
Route::get('/backflow_test_report/{id}/pdf', ['uses' => 'BackflowTestReportController@pdf', 'as' => 'backflow_test_report.pdf']);
Route::get('/backflow_test_report/{id}/html', ['uses' => 'BackflowTestReportController@html', 'as' => 'backflow_test_report.html']);
Route::get('/backflow_test_reports/pdf', ['uses' => 'BackflowTestReportController@pdfs', 'as' => 'backflow_test_report.pdfs']);
Route::get('/backflow_test_reports/html', ['uses' => 'BackflowTestReportController@htmls', 'as' => 'backflow_test_report.htmls']);

Route::put('/backflow_test_report/{id}/repairs', ['uses' => 'BackflowTestReportController@updateRepairs', 'as' => 'backflow_test_report.update_repairs']);
Route::put('/backflow_test_report/{id}/cleanings', ['uses' => 'BackflowTestReportController@updateCleanings', 'as' => 'backflow_test_report.update_cleanings']);

Route::get('/backflow_valves', ['uses' => 'BackflowValveController@index', 'as' => 'backflow_valve.index']);
Route::post('/backflow_valve', ['uses' => 'BackflowValveController@create', 'as' => 'backflow_valve.create']);
Route::get('/backflow_valve/{id}', ['uses' => 'BackflowValveController@read', 'as' => 'backflow_valve.read']);
Route::patch('/backflow_valve/{id}', ['uses' => 'BackflowValveController@update', 'as' => 'backflow_valve.update']);
Route::delete('/backflow_valve/{id}', ['uses' => 'BackflowValveController@delete', 'as' => 'backflow_valve.delete']);

Route::get('/backflow_tests', ['uses' => 'BackflowTestController@index', 'as' => 'backflow_test.index']);
Route::post('/backflow_test', ['uses' => 'BackflowTestController@create', 'as' => 'backflow_test.create']);
Route::get('/backflow_test/{id}', ['uses' => 'BackflowTestController@read', 'as' => 'backflow_test.read']);
Route::patch('/backflow_test/{id}', ['uses' => 'BackflowTestController@update', 'as' => 'backflow_test.update']);
Route::delete('/backflow_test/{id}', ['uses' => 'BackflowTestController@delete', 'as' => 'backflow_test.delete']);

Route::get('/backflow_super_types', ['uses' => 'BackflowSuperTypeController@index', 'as' => 'backflow_super_type.index']);
Route::post('/backflow_super_type', ['uses' => 'BackflowSuperTypeController@create', 'as' => 'backflow_super_type.create']);
Route::get('/backflow_super_type/{id}', ['uses' => 'BackflowSuperTypeController@read', 'as' => 'backflow_super_type.read']);
Route::patch('/backflow_super_type/{id}', ['uses' => 'BackflowSuperTypeController@update', 'as' => 'backflow_super_type.update']);
Route::delete('/backflow_super_type/{id}', ['uses' => 'BackflowSuperTypeController@delete', 'as' => 'backflow_super_type.delete']);

Route::get('/backflow_cleanings', ['uses' => 'BackflowCleaningController@index', 'as' => 'backflow_cleaning.index']);
Route::post('/backflow_cleaning', ['uses' => 'BackflowCleaningController@create', 'as' => 'backflow_cleaning.create']);
Route::get('/backflow_cleaning/{id}', ['uses' => 'BackflowCleaningController@read', 'as' => 'backflow_cleaning.read']);
Route::patch('/backflow_cleaning/{id}', ['uses' => 'BackflowCleaningController@update', 'as' => 'backflow_cleaning.update']);
Route::delete('/backflow_cleaning/{id}', ['uses' => 'BackflowCleaningController@delete', 'as' => 'backflow_cleaning.delete']);

Route::get('/backflow_repairs', ['uses' => 'BackflowRepairController@index', 'as' => 'backflow_repair.index']);
Route::post('/backflow_repair', ['uses' => 'BackflowRepairController@create', 'as' => 'backflow_repair.create']);
Route::get('/backflow_repair/{id}', ['uses' => 'BackflowRepairController@read', 'as' => 'backflow_repair.read']);
Route::patch('/backflow_repair/{id}', ['uses' => 'BackflowRepairController@update', 'as' => 'backflow_repair.update']);
Route::delete('/backflow_repair/{id}', ['uses' => 'BackflowRepairController@delete', 'as' => 'backflow_repair.delete']);

Route::get('/property_units', ['uses' => 'PropertyUnitController@index', 'as' => 'property_unit.index']);
Route::post('/property_unit', ['uses' => 'PropertyUnitController@create', 'as' => 'property_unit.create']);
Route::get('/property_unit/{id}', ['uses' => 'PropertyUnitController@read', 'as' => 'property_unit.read']);
Route::patch('/property_unit/{id}', ['uses' => 'PropertyUnitController@update', 'as' => 'property_unit.update']);
Route::delete('/property_unit/{id}', ['uses' => 'PropertyUnitController@delete', 'as' => 'property_unit.delete']);

Route::get('/phree_books/contacts', 'PhreeBooksController@contacts');
Route::get('/phree_books/addresses', 'PhreeBooksController@addresses');
Route::get('/phree_books/matches', 'PhreeBooksController@matches');
Route::get('/phree_books/tasca', 'PhreeBooksController@tasca');
Route::get('/phree_books/phree_books', 'PhreeBooksController@phreeBooks');

Route::get('/phree_books/clients', 'PhreeBooksController@clients');
Route::post('/phree_books/client/{id}', 'PhreeBooksController@createClient');
Route::patch('/phree_books/client/{id}/match', 'PhreeBooksController@matchClient');
Route::post('/phree_books/contact/{id}', 'PhreeBooksController@createContact');
Route::post('/phree_books/property/{id}', 'PhreeBooksController@createProperty');
Route::put('/phree_books/client/{id}', 'PhreeBooksController@updateClient');
Route::put('/phree_books/contact/{id}', 'PhreeBooksController@updateContact');
Route::put('/phree_books/property/{id}', 'PhreeBooksController@updateProperty');

Route::get('/irrigation_water_types', ['uses' => 'IrrigationWaterTypeController@index', 'as' => 'irrigation_water_type.index']);
Route::post('/irrigation_water_type', ['uses' => 'IrrigationWaterTypeController@create', 'as' => 'irrigation_water_type.create']);
Route::get('/irrigation_water_type/{id}', ['uses' => 'IrrigationWaterTypeController@read', 'as' => 'irrigation_water_type.read']);
Route::patch('/irrigation_water_type/{id}', ['uses' => 'IrrigationWaterTypeController@update', 'as' => 'irrigation_water_type.update']);
Route::delete('/irrigation_water_type/{id}', ['uses' => 'IrrigationWaterTypeController@delete', 'as' => 'irrigation_water_type.delete']);

Route::get('/irrigation_systems', ['uses' => 'IrrigationSystemController@index', 'as' => 'irrigation_system.index']);
Route::post('/irrigation_system', ['uses' => 'IrrigationSystemController@create', 'as' => 'irrigation_system.create']);
Route::get('/irrigation_system/{id}', ['uses' => 'IrrigationSystemController@read', 'as' => 'irrigation_system.read']);
Route::patch('/irrigation_system/{id}', ['uses' => 'IrrigationSystemController@update', 'as' => 'irrigation_system.update']);
Route::delete('/irrigation_system/{id}', ['uses' => 'IrrigationSystemController@delete', 'as' => 'irrigation_system.delete']);

Route::get('/irrigation_controllers', ['uses' => 'IrrigationControllerController@index', 'as' => 'irrigation_controller.index']);
Route::post('/irrigation_controller', ['uses' => 'IrrigationControllerController@create', 'as' => 'irrigation_controller.create']);
Route::get('/irrigation_controller/{id}', ['uses' => 'IrrigationControllerController@read', 'as' => 'irrigation_controller.read']);
Route::patch('/irrigation_controller/{id}', ['uses' => 'IrrigationControllerController@update', 'as' => 'irrigation_controller.update']);
Route::delete('/irrigation_controller/{id}', ['uses' => 'IrrigationControllerController@delete', 'as' => 'irrigation_controller.delete']);

Route::get('/irrigation_controller_locations', ['uses' => 'IrrigationControllerLocationController@index', 'as' => 'irrigation_controller_location.index']);
Route::post('/irrigation_controller_location', ['uses' => 'IrrigationControllerLocationController@create', 'as' => 'irrigation_controller_location.create']);
Route::get('/irrigation_controller_location/{id}', ['uses' => 'IrrigationControllerLocationController@read', 'as' => 'irrigation_controller_location.read']);
Route::patch('/irrigation_controller_location/{id}', ['uses' => 'IrrigationControllerLocationController@update', 'as' => 'irrigation_controller_location.update']);
Route::delete('/irrigation_controller_location/{id}', ['uses' => 'IrrigationControllerLocationController@delete', 'as' => 'irrigation_controller_location.delete']);

Route::get('/irrigation_system_others', ['uses' => 'IrrigationSystemOtherController@index', 'as' => 'irrigation_system_other.index']);
Route::post('/irrigation_system_other', ['uses' => 'IrrigationSystemOtherController@create', 'as' => 'irrigation_system_other.create']);
Route::get('/irrigation_system_other/{id}', ['uses' => 'IrrigationSystemOtherController@read', 'as' => 'irrigation_system_other.read']);
Route::patch('/irrigation_system_other/{id}', ['uses' => 'IrrigationSystemOtherController@update', 'as' => 'irrigation_system_other.update']);
Route::delete('/irrigation_system_other/{id}', ['uses' => 'IrrigationSystemOtherController@delete', 'as' => 'irrigation_system_other.delete']);

Route::get('/irrigation_controller_others', ['uses' => 'IrrigationControllerOtherController@index', 'as' => 'irrigation_controller_other.index']);
Route::post('/irrigation_controller_other', ['uses' => 'IrrigationControllerOtherController@create', 'as' => 'irrigation_controller_other.create']);
Route::get('/irrigation_controller_other/{id}', ['uses' => 'IrrigationControllerOtherController@read', 'as' => 'irrigation_controller_other.read']);
Route::patch('/irrigation_controller_other/{id}', ['uses' => 'IrrigationControllerOtherController@update', 'as' => 'irrigation_controller_other.update']);
Route::delete('/irrigation_controller_other/{id}', ['uses' => 'IrrigationControllerOtherController@delete', 'as' => 'irrigation_controller_other.delete']);

Route::get('/irrigation_zones', ['uses' => 'IrrigationZoneController@index', 'as' => 'irrigation_zone.index']);
Route::post('/irrigation_zone', ['uses' => 'IrrigationZoneController@create', 'as' => 'irrigation_zone.create']);
Route::get('/irrigation_zone/{id}', ['uses' => 'IrrigationZoneController@read', 'as' => 'irrigation_zone.read']);
Route::patch('/irrigation_zone/{id}', ['uses' => 'IrrigationZoneController@update', 'as' => 'irrigation_zone.update']);
Route::delete('/irrigation_zone/{id}', ['uses' => 'IrrigationZoneController@delete', 'as' => 'irrigation_zone.delete']);

Route::get('/property_accounts', ['uses' => 'PropertyAccountController@index', 'as' => 'property_account.index']);
Route::post('/property_account', ['uses' => 'PropertyAccountController@create', 'as' => 'property_account.create']);
Route::get('/property_account/{id}', ['uses' => 'PropertyAccountController@read', 'as' => 'property_account.read']);
Route::patch('/property_account/{id}', ['uses' => 'PropertyAccountController@update', 'as' => 'property_account.update']);
Route::delete('/property_account/{id}', ['uses' => 'PropertyAccountController@delete', 'as' => 'property_account.delete']);

Route::get('/backflow_pictures', ['uses' => 'BackflowPictureController@index', 'as' => 'backflow_picture.index']);
Route::post('/backflow_picture', ['uses' => 'BackflowPictureController@create', 'as' => 'backflow_picture.create']);
Route::get('/backflow_picture/{id}', ['uses' => 'BackflowPictureController@read', 'as' => 'backflow_picture.read']);
Route::patch('/backflow_picture/{id}', ['uses' => 'BackflowPictureController@update', 'as' => 'backflow_picture.update']);
Route::delete('/backflow_picture/{id}', ['uses' => 'BackflowPictureController@delete', 'as' => 'backflow_picture.delete']);

Route::get('/clock_ins', ['uses' => 'ClockInController@index', 'as' => 'clock_in.index']);
Route::post('/clock_in', ['uses' => 'ClockInController@create', 'as' => 'clock_in.create']);
Route::get('/clock_in/{id}', ['uses' => 'ClockInController@read', 'as' => 'clock_in.read']);
Route::patch('/clock_in/{id}', ['uses' => 'ClockInController@update', 'as' => 'clock_in.update']);
Route::delete('/clock_in/{id}', ['uses' => 'ClockInController@delete', 'as' => 'clock_in.delete']);
Route::get('/clock_in/current', ['uses' => 'ClockInController@current', 'as' => 'clock_in.current']);
Route::get('/clock_ins/by_employee', 'ClockInController@by_employee');
Route::post('/clock_in/assigned', ['uses' => 'ClockInController@createAssigned', 'as' => 'clock_in.create_assigned']);
Route::patch('/clock_out/assigned/{id}', ['uses' => 'ClockInController@clockOutAssigned', 'as' => 'clock_in.update_assigned']);

Route::get('/asset_usage_types', ['uses' => 'AssetUsageTypeController@index', 'as' => 'asset_usage_type.index']);
Route::post('/asset_usage_type', ['uses' => 'AssetUsageTypeController@create', 'as' => 'asset_usage_type.create']);
Route::get('/asset_usage_type/{id}', ['uses' => 'AssetUsageTypeController@read', 'as' => 'asset_usage_type.read']);
Route::patch('/asset_usage_type/{id}', ['uses' => 'AssetUsageTypeController@update', 'as' => 'asset_usage_type.update']);
Route::delete('/asset_usage_type/{id}', ['uses' => 'AssetUsageTypeController@delete', 'as' => 'asset_usage_type.delete']);

Route::get('/assets', ['uses' => 'AssetController@index', 'as' => 'asset.index']);
Route::post('/asset', ['uses' => 'AssetController@create', 'as' => 'asset.create']);
Route::get('/asset/{id}', ['uses' => 'AssetController@read', 'as' => 'asset.read']);
Route::get('/asset/number/{number:[0-9A-Z]+}', ['uses' => 'AssetController@readNumber', 'as' => 'asset.read_number']);
Route::patch('/asset/{id}', ['uses' => 'AssetController@update', 'as' => 'asset.update']);
Route::delete('/asset/{id}', ['uses' => 'AssetController@delete', 'as' => 'asset.delete']);
Route::post('/asset/{id}/export', ['uses' => 'AssetController@createExport', 'as' => 'asset.create.export']);
Route::get('/assets/unique/{field:\w+}', ['uses' => 'AssetController@unique', 'as' => 'asset.unique']);

Route::get('/asset_fuelings', ['uses' => 'AssetFuelingController@index', 'as' => 'asset_fueling.index']);
Route::post('/asset_fueling', ['uses' => 'AssetFuelingController@create', 'as' => 'asset_fueling.create']);
Route::get('/asset_fueling/{id}', ['uses' => 'AssetFuelingController@read', 'as' => 'asset_fueling.read']);
Route::get('/asset_fueling/last', ['uses' => 'AssetFuelingController@last', 'as' => 'asset_fueling.last']);
Route::patch('/asset_fueling/{id}', ['uses' => 'AssetFuelingController@update', 'as' => 'asset_fueling.update']);
Route::delete('/asset_fueling/{id}', ['uses' => 'AssetFuelingController@delete', 'as' => 'asset_fueling.delete']);

Route::get('/asset_parts', ['uses' => 'AssetPartController@index', 'as' => 'asset_part.index']);
Route::post('/asset_part', ['uses' => 'AssetPartController@create', 'as' => 'asset_part.create']);
Route::get('/asset_part/{id}', ['uses' => 'AssetPartController@read', 'as' => 'asset_part.read']);
Route::patch('/asset_part/{id}', ['uses' => 'AssetPartController@update', 'as' => 'asset_part.update']);
Route::delete('/asset_part/{id}', ['uses' => 'AssetPartController@delete', 'as' => 'asset_part.delete']);

Route::get('/asset_repairs', ['uses' => 'AssetRepairController@index', 'as' => 'asset_repair.index']);
Route::post('/asset_repair', ['uses' => 'AssetRepairController@create', 'as' => 'asset_repair.create']);
Route::get('/asset_repair/{id}', ['uses' => 'AssetRepairController@read', 'as' => 'asset_repair.read']);
Route::patch('/asset_repair/{id}', ['uses' => 'AssetRepairController@update', 'as' => 'asset_repair.update']);
Route::delete('/asset_repair/{id}', ['uses' => 'AssetRepairController@delete', 'as' => 'asset_repair.delete']);
Route::get('/asset_repairs/unique/{field:\w+}', ['uses' => 'AssetRepairController@unique', 'as' => 'asset_repair.unique']);

Route::get('/asset_service_types', ['uses' => 'AssetServiceTypeController@index', 'as' => 'asset_service_type.index']);
Route::post('/asset_service_type', ['uses' => 'AssetServiceTypeController@create', 'as' => 'asset_service_type.create']);
Route::get('/asset_service_type/{id}', ['uses' => 'AssetServiceTypeController@read', 'as' => 'asset_service_type.read']);
Route::patch('/asset_service_type/{id}', ['uses' => 'AssetServiceTypeController@update', 'as' => 'asset_service_type.update']);
Route::delete('/asset_service_type/{id}', ['uses' => 'AssetServiceTypeController@delete', 'as' => 'asset_service_type.delete']);

Route::get('/asset_services', ['uses' => 'AssetServiceController@index', 'as' => 'asset_service.index']);
Route::post('/asset_service', ['uses' => 'AssetServiceController@create', 'as' => 'asset_service.create']);
Route::get('/asset_service/{id}', ['uses' => 'AssetServiceController@read', 'as' => 'asset_service.read']);
Route::patch('/asset_service/{id}', ['uses' => 'AssetServiceController@update', 'as' => 'asset_service.update']);
Route::delete('/asset_service/{id}', ['uses' => 'AssetServiceController@delete', 'as' => 'asset_service.delete']);

Route::get('/asset_maintenances', ['uses' => 'AssetMaintenanceController@index', 'as' => 'asset_maintenance.index']);
Route::post('/asset_maintenance', ['uses' => 'AssetMaintenanceController@create', 'as' => 'asset_maintenance.create']);
Route::get('/asset_maintenance/{id}', ['uses' => 'AssetMaintenanceController@read', 'as' => 'asset_maintenance.read']);
Route::get('/asset_maintenance/last/', ['uses' => 'AssetMaintenanceController@last', 'as' => 'asset_maintenance.last']);
Route::patch('/asset_maintenance/{id}', ['uses' => 'AssetMaintenanceController@update', 'as' => 'asset_maintenance.update']);
Route::delete('/asset_maintenance/{id}', ['uses' => 'AssetMaintenanceController@delete', 'as' => 'asset_maintenance.delete']);
Route::get('/asset_maintenances/unique/{field:\w+}', ['uses' => 'AssetMaintenanceController@unique', 'as' => 'asset_maintenance.unique']);

Route::get('/asset_units', ['uses' => 'AssetUnitController@index', 'as' => 'asset_unit.index']);
Route::post('/asset_unit', ['uses' => 'AssetUnitController@create', 'as' => 'asset_unit.create']);
Route::get('/asset_unit/{id}', ['uses' => 'AssetUnitController@read', 'as' => 'asset_unit.read']);
Route::patch('/asset_unit/{id}', ['uses' => 'AssetUnitController@update', 'as' => 'asset_unit.update']);
Route::delete('/asset_unit/{id}', ['uses' => 'AssetUnitController@delete', 'as' => 'asset_unit.delete']);

Route::get('/roles', ['uses' => 'RoleController@index', 'as' => 'role.index']);
Route::post('/role', ['uses' => 'RoleController@create', 'as' => 'role.create']);
Route::get('/role/{id}', ['uses' => 'RoleController@read', 'as' => 'role.read']);
Route::patch('/role/{id}', ['uses' => 'RoleController@update', 'as' => 'role.update']);
Route::delete('/role/{id}', ['uses' => 'RoleController@delete', 'as' => 'role.delete']);
Route::put('/role/{id}/permissions', ['uses' => 'RoleController@updatePermissions', 'as' => 'role.update.permissions']);

Route::get('/asset_time_units', ['uses' => 'AssetTimeUnitController@index', 'as' => 'asset_time_unit.index']);
Route::post('/asset_time_unit', ['uses' => 'AssetTimeUnitController@create', 'as' => 'asset_time_unit.create']);
Route::get('/asset_time_unit/{id}', ['uses' => 'AssetTimeUnitController@read', 'as' => 'asset_time_unit.read']);
Route::patch('/asset_time_unit/{id}', ['uses' => 'AssetTimeUnitController@update', 'as' => 'asset_time_unit.update']);
Route::delete('/asset_time_unit/{id}', ['uses' => 'AssetTimeUnitController@delete', 'as' => 'asset_time_unit.delete']);

Route::get('/asset_time_units', ['uses' => 'AssetTimeUnitController@index', 'as' => 'asset_time_unit.index']);
Route::post('/asset_time_unit', ['uses' => 'AssetTimeUnitController@create', 'as' => 'asset_time_unit.create']);
Route::get('/asset_time_unit/{id}', ['uses' => 'AssetTimeUnitController@read', 'as' => 'asset_time_unit.read']);
Route::patch('/asset_time_unit/{id}', ['uses' => 'AssetTimeUnitController@update', 'as' => 'asset_time_unit.update']);
Route::delete('/asset_time_unit/{id}', ['uses' => 'AssetTimeUnitController@delete', 'as' => 'asset_time_unit.delete']);

Route::get('/asset_homes', ['uses' => 'AssetHomeController@index', 'as' => 'asset_home.index']);
Route::post('/asset_home', ['uses' => 'AssetHomeController@create', 'as' => 'asset_home.create']);
Route::get('/asset_home/{id}', ['uses' => 'AssetHomeController@read', 'as' => 'asset_home.read']);
Route::patch('/asset_home/{id}', ['uses' => 'AssetHomeController@update', 'as' => 'asset_home.update']);
Route::delete('/asset_home/{id}', ['uses' => 'AssetHomeController@delete', 'as' => 'asset_home.delete']);

Route::get('/asset_pictures', ['uses' => 'AssetPictureController@index', 'as' => 'asset_picture.index']);
Route::post('/asset_picture', ['uses' => 'AssetPictureController@create', 'as' => 'asset_picture.create']);
Route::get('/asset_picture/{id}', ['uses' => 'AssetPictureController@read', 'as' => 'asset_picture.read']);
Route::patch('/asset_picture/{id}', ['uses' => 'AssetPictureController@update', 'as' => 'asset_picture.update']);
Route::delete('/asset_picture/{id}', ['uses' => 'AssetPictureController@delete', 'as' => 'asset_picture.delete']);

Route::get('/asset_appraisals', ['uses' => 'AssetAppraisalController@index', 'as' => 'asset_appraisal.index']);
Route::post('/asset_appraisal', ['uses' => 'AssetAppraisalController@create', 'as' => 'asset_appraisal.create']);
Route::get('/asset_appraisal/{id}', ['uses' => 'AssetAppraisalController@read', 'as' => 'asset_appraisal.read']);
Route::patch('/asset_appraisal/{id}', ['uses' => 'AssetAppraisalController@update', 'as' => 'asset_appraisal.update']);
Route::delete('/asset_appraisal/{id}', ['uses' => 'AssetAppraisalController@delete', 'as' => 'asset_appraisal.delete']);

Route::get('/asset_improvements', ['uses' => 'AssetImprovementController@index', 'as' => 'asset_improvement.index']);
Route::post('/asset_improvement', ['uses' => 'AssetImprovementController@create', 'as' => 'asset_improvement.create']);
Route::get('/asset_improvement/{id}', ['uses' => 'AssetImprovementController@read', 'as' => 'asset_improvement.read']);
Route::patch('/asset_improvement/{id}', ['uses' => 'AssetImprovementController@update', 'as' => 'asset_improvement.update']);
Route::delete('/asset_improvement/{id}', ['uses' => 'AssetImprovementController@delete', 'as' => 'asset_improvement.delete']);

Route::get('/permissions', ['uses' => 'PermissionController@index', 'as' => 'permission.index']);
Route::post('/permission', ['uses' => 'PermissionController@create', 'as' => 'permission.create']);
Route::get('/permission/{id}', ['uses' => 'PermissionController@read', 'as' => 'permission.read']);
Route::patch('/permission/{id}', ['uses' => 'PermissionController@update', 'as' => 'permission.update']);
Route::delete('/permission/{id}', ['uses' => 'PermissionController@delete', 'as' => 'permission.delete']);

Route::get('/appointments', ['uses' => 'AppointmentController@index', 'as' => 'appointment.index']);
Route::post('/appointment', ['uses' => 'AppointmentController@create', 'as' => 'appointment.create']);
Route::get('/appointment/{id}', ['uses' => 'AppointmentController@read', 'as' => 'appointment.read']);
Route::patch('/appointment/{id}', ['uses' => 'AppointmentController@update', 'as' => 'appointment.update']);
Route::delete('/appointment/{id}', ['uses' => 'AppointmentController@delete', 'as' => 'appointment.delete']);
Route::get('/schedule', 'AppointmentController@schedule');

Route::get('/labor_types', ['uses' => 'LaborTypeController@index', 'as' => 'labor_type.index']);
Route::post('/labor_type', ['uses' => 'LaborTypeController@create', 'as' => 'labor_type.create']);
Route::get('/labor_type/{id}', ['uses' => 'LaborTypeController@read', 'as' => 'labor_type.read']);
Route::patch('/labor_type/{id}', ['uses' => 'LaborTypeController@update', 'as' => 'labor_type.update']);
Route::delete('/labor_type/{id}', ['uses' => 'LaborTypeController@delete', 'as' => 'labor_type.delete']);

Route::get('/labor_activities', ['uses' => 'LaborActivityController@index', 'as' => 'labor_activity.index']);
Route::post('/labor_activity', ['uses' => 'LaborActivityController@create', 'as' => 'labor_activity.create']);
Route::get('/labor_activity/{id}', ['uses' => 'LaborActivityController@read', 'as' => 'labor_activity.read']);
Route::patch('/labor_activity/{id}', ['uses' => 'LaborActivityController@update', 'as' => 'labor_activity.update']);
Route::delete('/labor_activity/{id}', ['uses' => 'LaborActivityController@delete', 'as' => 'labor_activity.delete']);

Route::get('/labor_assignments', ['uses' => 'LaborAssignmentController@index', 'as' => 'labor_assignment.index']);
Route::post('/labor_assignment', ['uses' => 'LaborAssignmentController@create', 'as' => 'labor_assignment.create']);
Route::get('/labor_assignment/{id}', ['uses' => 'LaborAssignmentController@read', 'as' => 'labor_assignment.read']);
Route::patch('/labor_assignment/{id}', ['uses' => 'LaborAssignmentController@update', 'as' => 'labor_assignment.update']);
Route::delete('/labor_assignment/{id}', ['uses' => 'LaborAssignmentController@delete', 'as' => 'labor_assignment.delete']);
Route::put('/labor_assignment/{id}/labor_activities', ['uses' => 'LaborAssignmentController@updateLaborActivities', 'as' => 'labor_assignment.update.labor_activities']);

Route::get('/task_actions', ['uses' => 'TaskActionController@index', 'as' => 'task_action.index']);
Route::post('/task_action', ['uses' => 'TaskActionController@create', 'as' => 'task_action.create']);
Route::get('/task_action/{id}', ['uses' => 'TaskActionController@read', 'as' => 'task_action.read']);
Route::patch('/task_action/{id}', ['uses' => 'TaskActionController@update', 'as' => 'task_action.update']);
Route::delete('/task_action/{id}', ['uses' => 'TaskActionController@delete', 'as' => 'task_action.delete']);

Route::get('/task_types', ['uses' => 'TaskTypeController@index', 'as' => 'task_type.index']);
Route::post('/task_type', ['uses' => 'TaskTypeController@create', 'as' => 'task_type.create']);
Route::get('/task_type/{id}', ['uses' => 'TaskTypeController@read', 'as' => 'task_type.read']);
Route::patch('/task_type/{id}', ['uses' => 'TaskTypeController@update', 'as' => 'task_type.update']);
Route::delete('/task_type/{id}', ['uses' => 'TaskTypeController@delete', 'as' => 'task_type.delete']);

Route::get('/asset_categories', ['uses' => 'AssetCategoryController@index', 'as' => 'asset_category.index']);
Route::post('/asset_category', ['uses' => 'AssetCategoryController@create', 'as' => 'asset_category.create']);
Route::get('/asset_category/{id}', ['uses' => 'AssetCategoryController@read', 'as' => 'asset_category.read']);
Route::patch('/asset_category/{id}', ['uses' => 'AssetCategoryController@update', 'as' => 'asset_category.update']);
Route::delete('/asset_category/{id}', ['uses' => 'AssetCategoryController@delete', 'as' => 'asset_category.delete']);

Route::get('/asset_brands', ['uses' => 'AssetBrandController@index', 'as' => 'asset_brand.index']);
Route::post('/asset_brand', ['uses' => 'AssetBrandController@create', 'as' => 'asset_brand.create']);
Route::get('/asset_brand/{id}', ['uses' => 'AssetBrandController@read', 'as' => 'asset_brand.read']);
Route::patch('/asset_brand/{id}', ['uses' => 'AssetBrandController@update', 'as' => 'asset_brand.update']);
Route::delete('/asset_brand/{id}', ['uses' => 'AssetBrandController@delete', 'as' => 'asset_brand.delete']);

Route::get('/asset_types', ['uses' => 'AssetTypeController@index', 'as' => 'asset_type.index']);
Route::post('/asset_type', ['uses' => 'AssetTypeController@create', 'as' => 'asset_type.create']);
Route::get('/asset_type/{id}', ['uses' => 'AssetTypeController@read', 'as' => 'asset_type.read']);
Route::patch('/asset_type/{id}', ['uses' => 'AssetTypeController@update', 'as' => 'asset_type.update']);
Route::delete('/asset_type/{id}', ['uses' => 'AssetTypeController@delete', 'as' => 'asset_type.delete']);

Route::get('/asset_groups', ['uses' => 'AssetGroupController@index', 'as' => 'asset_group.index']);
Route::post('/asset_group', ['uses' => 'AssetGroupController@create', 'as' => 'asset_group.create']);
Route::get('/asset_group/{id}', ['uses' => 'AssetGroupController@read', 'as' => 'asset_group.read']);
Route::patch('/asset_group/{id}', ['uses' => 'AssetGroupController@update', 'as' => 'asset_group.update']);
Route::delete('/asset_group/{id}', ['uses' => 'AssetGroupController@delete', 'as' => 'asset_group.delete']);

Route::get('/asset_subs', ['uses' => 'AssetSubController@index', 'as' => 'asset_sub.index']);
Route::post('/asset_sub', ['uses' => 'AssetSubController@create', 'as' => 'asset_sub.create']);
Route::get('/asset_sub/{id}', ['uses' => 'AssetSubController@read', 'as' => 'asset_sub.read']);
Route::patch('/asset_sub/{id}', ['uses' => 'AssetSubController@update', 'as' => 'asset_sub.update']);
Route::delete('/asset_sub/{id}', ['uses' => 'AssetSubController@delete', 'as' => 'asset_sub.delete']);

Route::get('/asset_accessories', ['uses' => 'AssetAccessoryController@index', 'as' => 'asset_accessory.index']);
Route::post('/asset_accessory', ['uses' => 'AssetAccessoryController@create', 'as' => 'asset_accessory.create']);
Route::get('/asset_accessory/{id}', ['uses' => 'AssetAccessoryController@read', 'as' => 'asset_accessory.read']);
Route::patch('/asset_accessory/{id}', ['uses' => 'AssetAccessoryController@update', 'as' => 'asset_accessory.update']);
Route::delete('/asset_accessory/{id}', ['uses' => 'AssetAccessoryController@delete', 'as' => 'asset_accessory.delete']);

Route::get('/stock_text_messages', ['uses' => 'StockTextMessageController@index', 'as' => 'stock_text_message.index']);
Route::post('/stock_text_message', ['uses' => 'StockTextMessageController@create', 'as' => 'stock_text_message.create']);
Route::get('/stock_text_message/{id}', ['uses' => 'StockTextMessageController@read', 'as' => 'stock_text_message.read']);
Route::patch('/stock_text_message/{id}', ['uses' => 'StockTextMessageController@update', 'as' => 'stock_text_message.update']);
Route::delete('/stock_text_message/{id}', ['uses' => 'StockTextMessageController@delete', 'as' => 'stock_text_message.delete']);

Route::get('/sms_message_types', ['uses' => 'SmsMessageTypeController@index', 'as' => 'sms_message_type.index']);
Route::post('/sms_message_type', ['uses' => 'SmsMessageTypeController@create', 'as' => 'sms_message_type.create']);
Route::get('/sms_message_type/{id}', ['uses' => 'SmsMessageTypeController@read', 'as' => 'sms_message_type.read']);
Route::patch('/sms_message_type/{id}', ['uses' => 'SmsMessageTypeController@update', 'as' => 'sms_message_type.update']);
Route::delete('/sms_message_type/{id}', ['uses' => 'SmsMessageTypeController@delete', 'as' => 'sms_message_type.delete']);

Route::get('/partial_text_message_types', ['uses' => 'PartialTextMessageTypeController@index', 'as' => 'partial_text_message_type.index']);
Route::post('/partial_text_message_type', ['uses' => 'PartialTextMessageTypeController@create', 'as' => 'partial_text_message_type.create']);
Route::get('/partial_text_message_type/{id}', ['uses' => 'PartialTextMessageTypeController@read', 'as' => 'partial_text_message_type.read']);
Route::patch('/partial_text_message_type/{id}', ['uses' => 'PartialTextMessageTypeController@update', 'as' => 'partial_text_message_type.update']);
Route::delete('/partial_text_message_type/{id}', ['uses' => 'PartialTextMessageTypeController@delete', 'as' => 'partial_text_message_type.delete']);

Route::get('/partial_text_messages', ['uses' => 'PartialTextMessageController@index', 'as' => 'partial_text_message.index']);
Route::post('/partial_text_message', ['uses' => 'PartialTextMessageController@create', 'as' => 'partial_text_message.create']);
Route::get('/partial_text_message/{id}', ['uses' => 'PartialTextMessageController@read', 'as' => 'partial_text_message.read']);
Route::patch('/partial_text_message/{id}', ['uses' => 'PartialTextMessageController@update', 'as' => 'partial_text_message.update']);
Route::delete('/partial_text_message/{id}', ['uses' => 'PartialTextMessageController@delete', 'as' => 'partial_text_message.delete']);