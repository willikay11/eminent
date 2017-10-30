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

    Route::get('/api/role/{id}/members', [
        'uses' => 'RoleController@getMembers'
    ]);

    Route::get('/api/role/{id}/permissions', [
        'uses' => 'RoleController@getPermissions'
    ]);

    Route::get('/roles/permissions/{id}', [
        'uses' => 'RoleController@permissions'
    ]);

    Route::post('/roles/permissions/{id}', [
        'as' => 'roles.permissions',
        'uses' => 'RoleController@updatePermissions'
    ]);

    Route::get('/roles/revoke/{id}', [
        'as' => 'roles.revoke',
        'uses' => 'RoleController@revoke'
    ]);

    Route::get('/permission/revoke/role/{role}/{permission}', [
        'as' => 'roles.permission_revoke',
        'uses' => 'RoleController@permissionRevoke'
    ]);

    /*
     * Designation Routes
     */
    Route::get('/api/designations', [
        'uses' => 'DesignationController@getDesignations'
    ]);

    Route::get('/designations', [
        'uses' => 'DesignationController@index'
    ]);

    Route::post('/designations/save', [
        'as' => 'designations.save',
        'uses' => 'DesignationController@storeDesignation'
    ]);

    /*
     * User Routes
     */
    Route::get('/api/users', [
        'uses' => 'UserController@getUsers'
    ]);

    Route::get('/users', [
        'uses' => 'UserController@index'
    ]);

    Route::get('info/users', [
        'uses' => 'UserController@getInformation'
    ]);

    Route::post('/users/save', [
        'uses' => 'UserController@storeUser'
    ]);

    Route::get('/users/activation/userId/{id}/code/{code}', [
        'as' => 'users.activation',
        'uses' => 'UserController@activation'
    ]);

    Route::get('/users/create_password/{id}', [
        'as' => 'users.create_password',
        'uses' => 'UserController@createPassword'
    ]);

    Route::post('/users/create_password/{id}', [
        'as' => 'users.create_password',
        'uses' => 'UserController@savePassword'
    ]);
    /*
     * Profession Routes
     */
    Route::get('/api/professions', [
        'uses' => 'ProfessionController@getProfessions'
    ]);

    Route::get('/professions', [
        'uses' => 'ProfessionController@index'
    ]);

    Route::post('/professions/save', [
        'as' => 'professions.save',
        'uses' => 'ProfessionController@storeProfession'
    ]);

    /*
     * Sources Routes
     */
    Route::get('/sources', [
        'uses' => 'SourceController@index'
    ]);

    Route::get('/api/sources', [
        'uses' => 'SourceController@getAllSources'
    ]);

    Route::post('/sources/save', [
        'as' => 'sources.save',
        'uses' => 'SourceController@storeSource'
    ]);

    /*
     * Departments Routes
     */
    Route::get('/departments', [
        'uses' => 'DepartmentController@index'
    ]);

    Route::get('/api/departments', [
        'uses' => 'DepartmentController@getDepartments'
    ]);

    Route::post('/departments/save', [
        'as' => 'departments.save',
        'uses' => 'DepartmentController@store'
    ]);

    /*
     * Contacts Routes
     */
    Route::get('/api/contacts/user', [
        'uses' => 'ContactController@getUserClients'
    ]);

    Route::get('/contacts/user', [
        'uses' =>'ContactController@index'
    ]);

    Route::get('/contacts/info', [
        'uses' => 'ContactController@getInfo'
    ]);

    Route::post('/contacts/save', [
        'as' => 'contacts.save',
        'uses' => 'ContactController@store'
    ]);

    Route::get('/contact/details/{id}', [
        'uses' => 'ContactController@details'
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
