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

Route::group(['middleware' => 'auth'], function (){

    Route::get('/', function () {
        return view('dashboard.dashboard');
    });

    Route::get('/logout', [
        'as' => 'auth.logout',
        'uses' => 'LoginController@destroy'
    ]);

    /*
     * Permissions Routes
     */
    Route::get('/api/permissions', [
        'uses' => 'PermissionController@getAllPermissions'
    ]);

    Route::get('/permissions', [
        'as' => 'permissions',
        'uses' => 'PermissionController@index'
    ]);


    /*
     * Roles Routes
     */
    Route::get('/api/roles', [
        'uses' => 'RoleController@getAllRoles'
    ]);

    Route::get('/roles', [
        'as' => 'roles',
        'uses' => 'RoleController@index'
    ]);

    Route::get('/roles/details/{id}', [
        'uses' => 'RoleController@details'
    ]);

    Route::post('/roles/save', [
        'as' => 'roles.save',
        'uses' => 'RoleController@store',
    ]);
});


Route::group(['middleware' => 'guest'], function() {

    Route::get('/login', [
        'as' => 'login',
        'uses' => 'LoginController@index'
    ]);

    Route::post('/login/auth', [
        'as' => 'login.auth',
        'uses' => 'LoginController@authenticate'
    ]);

    Route::get('login/confirm/{work_email}', 'LoginController@confirmAuthentication');

    Route::post('/login/confirm/{email}', [
        'as' => 'login.confirm',
        'uses' => 'LoginController@confirmAuthentication'
    ]);

    Route::get('/password/remind', [
        'as' => 'password.remind',
        'uses' => 'RemindersController@index'
    ]);

    Route::post('/password/remind', [
        'as' => 'login.remind',
        'uses' => 'RemindersController@authenticateReminder'
    ]);

    Route::get('/password/remind/user/{id}/token/{token}', [
        'as' => 'auth.reset',
        'uses' => 'RemindersController@authenticateResetLink'
    ]);

    Route::post('/password/reset/user/{id}', [
        'as' => 'login.reset',
        'uses' => 'RemindersController@savePassword'
    ]);
});
