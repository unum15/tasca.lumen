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
    return $router->app->version();
});

$router->post('/auth', 'AuthController@auth');
$router->post('/unauth', 'AuthController@unauth');

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

$router->get('/service_order_actions', 'ServiceOrderActionController@index');
$router->post('/service_order_action', 'ServiceOrderActionController@create');
$router->get('/service_order_action/{id:[0-9]+}', 'ServiceOrderActionController@read');
$router->patch('/service_order_action/{id:[0-9]+}', 'ServiceOrderActionController@update');
$router->delete('/service_order_action/{id:[0-9]+}', 'ServiceOrderActionController@delete');

$router->get('/service_order_priorities', 'ServiceOrderPriorityController@index');
$router->post('/service_order_priority', 'ServiceOrderPriorityController@create');
$router->get('/service_order_priority/{id:[0-9]+}', 'ServiceOrderPriorityController@read');
$router->patch('/service_order_priority/{id:[0-9]+}', 'ServiceOrderPriorityController@update');
$router->delete('/service_order_priority/{id:[0-9]+}', 'ServiceOrderPriorityController@delete');

$router->get('/service_order_categories', 'ServiceOrderCategoryController@index');
$router->post('/service_order_category', 'ServiceOrderCategoryController@create');
$router->get('/service_order_category/{id:[0-9]+}', 'ServiceOrderCategoryController@read');
$router->patch('/service_order_category/{id:[0-9]+}', 'ServiceOrderCategoryController@update');
$router->delete('/service_order_category/{id:[0-9]+}', 'ServiceOrderCategoryController@delete');

$router->get('/service_order_statuses', 'ServiceOrderStatusController@index');
$router->post('/service_order_status', 'ServiceOrderStatusController@create');
$router->get('/service_order_status/{id:[0-9]+}', 'ServiceOrderStatusController@read');
$router->patch('/service_order_status/{id:[0-9]+}', 'ServiceOrderStatusController@update');
$router->delete('/service_order_status/{id:[0-9]+}', 'ServiceOrderStatusController@delete');

$router->get('/service_order_types', 'ServiceOrderTypeController@index');
$router->post('/service_order_type', 'ServiceOrderTypeController@create');
$router->get('/service_order_type/{id:[0-9]+}', 'ServiceOrderTypeController@read');
$router->patch('/service_order_type/{id:[0-9]+}', 'ServiceOrderTypeController@update');
$router->delete('/service_order_type/{id:[0-9]+}', 'ServiceOrderTypeController@delete');

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

$router->get('/work_orders', 'WorkOrderController@index');
$router->post('/work_order', 'WorkOrderController@create');
$router->get('/work_order/{id:[0-9]+}', 'WorkOrderController@read');
$router->patch('/work_order/{id:[0-9]+}', 'WorkOrderController@update');
$router->delete('/work_order/{id:[0-9]+}', 'WorkOrderController@delete');

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

$router->get('/service_orders', 'ServiceOrderController@index');
$router->post('/service_order', 'ServiceOrderController@create');
$router->get('/service_order/{id:[0-9]+}', 'ServiceOrderController@read');
$router->patch('/service_order/{id:[0-9]+}', 'ServiceOrderController@update');
$router->delete('/service_order/{id:[0-9]+}', 'ServiceOrderController@delete');

$router->get('/tasks', 'TaskController@index');
$router->post('/task', 'TaskController@create');
$router->get('/task/{id:[0-9]+}', 'TaskController@read');
$router->patch('/task/{id:[0-9]+}', 'TaskController@update');
$router->delete('/task/{id:[0-9]+}', 'TaskController@delete');

$router->get('/settings', 'SettingController@index');
