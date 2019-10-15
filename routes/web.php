<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\LogoutController@index'])->name('logout');

Route::middleware(['auth'])->name('client.')->namespace('Roles\Client')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('projects')->name('project.')->group(function () {
        Route::get('/', 'ProjectController@index')->name('list');
        Route::get('/project/{id}','ProjectController@show')->name('edit');
    });
});

Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('login', 'Auth\StaffLoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\StaffLoginController@login')->name('login.submit');
});

Route::middleware(['auth:staff'])->prefix('staff')->name('staff.')->namespace('Roles\Staff')->group(function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('users')->name('user.')->group(function () {
        Route::get('/', 'UserController@index')->name('list');
        Route::get('user/{id}','UserController@edit')->name('edit');
        Route::patch('update/{id}','UserController@update')->name('update');
        Route::get('add', 'UserController@create')->name('add');
        Route::post('store', 'UserController@store')->name('store');
    });

    Route::prefix('clients')->name('client.')->group(function () {
        Route::get('/', 'ClientController@index')->name('list');
        Route::get('/client/{id}','ClientController@edit')->name('edit');
        Route::patch('/update/{id}', 'ClientController@update')->name('update');
        Route::get('/add', 'ClientController@create')->name('add');
        Route::post('/store', 'ClientController@store')->name('store');
    });

    Route::prefix('projects')->name('project.')->group(function () {
        Route::get('/', 'ProjectController@index')->name('list');
        Route::get('/add', 'ProjectController@create')->name('add');
        Route::post('/store', 'ProjectController@store')->name('store');
        Route::get('/project/{id}','ProjectController@show')->name('edit');
        Route::get('/user/{user_id}','ProjectController@user_projects')->name('user.projects');
    });

    Route::prefix('events')->name('event.')->group(function () {
        Route::get('/', 'EventController@index')->name('list');
        Route::get('/event/{id}','EventController@edit')->name('edit');
    });
});


