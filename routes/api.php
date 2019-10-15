<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->name('api.')->group(function () {

    Route::get('/address-lookup/{postcode}', 'AddressController@lookup')->name('address.lookup');

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/search', 'ProductController@search')->name('search');
        Route::get('/categories', 'ProductController@categories')->name('categories');
        Route::get('/cost-types', 'ProductController@cost_types')->name('cost.types');
        Route::post('/store', 'ProductController@store')->name('store');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', 'UserController@index')->name('list');
        Route::get('/staff', 'UserController@staff')->name('staff');
        Route::post('/store', 'UserController@store')->name('store');
        Route::get('/titles', 'UserController@titles')->name('titles');
        Route::get('/roles', 'UserController@roles')->name('roles');
        Route::get('/{id}', 'UserController@show')->name('single');
        Route::post('/{id}/update', 'UserController@update')->name('update');
        Route::get('/{id}/avatar', 'UserController@avatar')->name('avatar');
        Route::post('/{user_id}/address/store', 'UserController@store_address')->name('store.address');
        Route::put('/{user_id}/address/{address_id}/update', 'UserController@update_address')->name('update.address');
        Route::get('/{user_id}/events', 'UserController@events')->name('events');
        Route::post('/search', 'UserController@search')->name('search');
    });

    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/', 'ClientController@index')->name('list');
        Route::post('/store', 'ClientController@store')->name('store');
        Route::put('/{id}/update', 'ClientController@update')->name('update');
        Route::get('/types', 'ClientController@types')->name('types');
        Route::get('/{id}', 'ClientController@show')->name('single');
        Route::get('/{id}/projects', 'ClientController@projects')->name('project.list');
        Route::get('/{id}/contacts', 'ClientController@contacts')->name('contacts');
        Route::post('/contact/store', 'ClientController@store_contact')->name('store.contact');
        Route::post('{client_id}/contact/{contact_id}/update', 'ClientController@update_contact')->name('update.contact');
        Route::post('/address/store', 'ClientController@store_address')->name('store.address');
        Route::put('/{client_id}/address/{address_id}/update', 'ClientController@update_address')->name('update.address');
        Route::post('{client_id}/password/create', 'ClientController@store_password')->name('store.password');
        Route::post('/password/delete', 'ClientController@delete_password')->name('delete.password');
        Route::post('/password/{id}/update', 'ClientController@update_password')->name('update.password');
    });

    Route::prefix('event')->name('event.')->group(function () {
        Route::get('/', 'EventController@index')->name('list');
        Route::post('/store', 'EventController@store')->name('store');
    });

    Route::prefix('venue')->name('venue.')->group(function () {
        Route::get('/', 'VenueController@index')->name('list');
        Route::post('/store', 'VenueController@store')->name('store');
        Route::get('/car-park-types', 'VenueController@car_park_types')->name('car.park.types');
        Route::post('/search', 'VenueController@search')->name('search');
    });

    Route::prefix('department')->name('department.')->group(function () {
        Route::get('/', 'DepartmentController@index')->name('list');
    });

    Route::prefix('project')->name('project.')->group(function () {
        Route::get('/', 'ProjectController@index')->name('list');
        Route::get('/types', 'ProjectController@types')->name('types');
        Route::get('/statuses', 'ProjectController@statuses')->name('statuses');
        Route::post('/store', 'ProjectController@store')->name('store');
        Route::get('/{id}', 'ProjectController@show')->name('single');
        Route::get('/{project_id}/all-artwork/', 'ProjectController@all_project_artwork')->name('all.artwork');
        Route::get('/{project_id}/site-survey/', 'ProjectController@site_survey_artwork')->name('site.survey.artwork');
        Route::get('/{project_id}/concept-artwork/', 'ProjectController@concept_artwork')->name('concept.artwork');
        Route::get('/{project_id}/artwork/', 'ProjectController@artwork')->name('artwork');
        Route::get('/{project_id}/artwork/print', 'ProjectController@ready_to_print_artwork')->name('ready.to.print.artwork');
        Route::post('/{project_id}/artwork/artwork-type/{artwork_type}/store/', 'ProjectController@store_artwork')->name('store.artwork');
        Route::post('/{artwork_id}/artwork/amend-request/{amend_request_id}/amend/store/', 'ProjectController@store_artwork_amend')->name('store.artwork.amend');
        Route::get('/{project_id}/department/{department_id}/tasks', 'ProjectController@department_tasks')->name('department.tasks');
        Route::post('/{project_id}/user/remove', 'ProjectController@remove_user')->name('remove.user');
        Route::post('/{project_id}/user/create', 'ProjectController@add_user')->name('add.user');
        Route::get('/{project_id}/department/{department_id}/users', 'ProjectController@department_users')->name('department.users');
        Route::get('/{project_id}/user/available', 'ProjectController@available_users')->name('available.users');
        Route::get('/{project_id}/task-completion', 'ProjectController@task_completion')->name('task.completion');
        Route::get('/{project_id}/task-time-spent', 'ProjectController@task_time_spent')->name('task.time.spent');
        Route::put('/{project_id}/update', 'ProjectController@update')->name('update');
        Route::put('/update-artwork/{artwork_id}', 'ProjectController@update_artwork')->name('update.artwork');
        Route::put('/update-amend/{amend_id}', 'ProjectController@update_amend')->name('update.amend');
        Route::post('/store-amend-request/{artwork_id}', 'ProjectController@store_artwork_amend_request')->name('store.artwork.amend.request');
        Route::get('/user/{user_id}', 'ProjectController@user_projects')->name('user.projects');
        Route::get('/{project_id}/accommodation', 'ProjectController@accommodation')->name('accommodation.list');
        Route::post('/store-accommodation', 'ProjectController@store_accommodation')->name('store.accommodation');
        Route::post('{accommodation_id}/store-accommodation-attachments', 'ProjectController@store_accommodation_attachments')->name('store.accommodation.attachments');
        Route::get('/{project_id}/transport', 'ProjectController@transport')->name('transport.list');
        Route::post('/store/transport', 'ProjectController@store_transport')->name('store.transport');
        Route::get('/transport/vehicle-types', 'ProjectController@vehicle_types')->name('transport.vehicle.types');
        Route::get('/{project_id}/labour', 'ProjectController@labour')->name('labour.list');
        Route::post('/store/labour', 'ProjectController@store_labour')->name('store.labour');
    });

    Route::prefix('task')->name('task.')->group(function () {
        Route::get('/project/{project_id}/department/task-categories', 'TaskController@project_department_task_categories')->name('project.department.task.categories');
        Route::get('/project/{project_id}/department/{department_id}', 'TaskController@project_department_tasks')->name('project.department.tasks');
        Route::get('/project/{project_id}/task-category/{task_category_id}', 'TaskController@project_task_category_tasks')->name('project.task-category.tasks');
        Route::get('/project/{project_id}/custom-task-category/{custom_task_category_id}', 'TaskController@project_custom_task_category_tasks')->name('project.custom-task-category.tasks');
        Route::put('/update-tasks-order', 'TaskController@update_tasks_order')->name('update.tasks.order');
        Route::get('/user/{user_id}', 'TaskController@user_tasks')->name('user.list');
        Route::post('/store', 'TaskController@store')->name('store');
        Route::put('/{id}/update', 'TaskController@update')->name('update');
        Route::put('/mark-complete', 'TaskController@mark_complete')->name('mark.complete');
        Route::get('/{task_id}/subtasks', 'TaskController@subtasks')->name('subtasks');
        Route::post('/subtask/store', 'TaskController@store_subtask')->name('store.subtask');
        Route::post('/subtask/mark-complete', 'TaskController@mark_subtask_complete')->name('subtask.mark.complete');
        Route::get('/{id}/timelogs', 'TaskController@timelogs')->name('timelog.list');
        Route::post('/timelog/store', 'TaskController@store_timelog')->name('timelog.store');
        Route::post('/delete', 'TaskController@delete')->name('delete');
        Route::post('/{task_id}/add-files', 'TaskController@add_files')->name('add.files');
        Route::post('/project/task-category/store', 'TaskController@store_project_task_category')->name('store.project.task.category');
    });

    Route::prefix('file')->name('file.')->group(function () {
        Route::post('/validate', 'FileController@validate_files')->name('validate');
        Route::get('/{folder_name}/{item_id}/files/list', 'FileController@files_list')->name('list');
        Route::post('/{folder_name}/{item_id}/files/add-directory', 'FileController@add_directory')->name('add.directory');
        Route::post('/{folder_name}/{item_id}/files/add-file', 'FileController@add_file')->name('add.file');
        Route::post('/{folder_name}/{item_id}/files/assign-file', 'FileController@assign_file')->name('assign.file');
    });
});
