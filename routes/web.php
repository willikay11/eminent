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

    Route::get('/', [
        'uses' => 'DashboardController@index'
    ]);

    Route::get('/api/dashboard/contacts/user/{userId}', [
        'uses' => 'DashboardController@getDashBoardUserClients'
    ]);

    Route::get('/api/dashboard/interactions/{userId}', [
        'uses' => 'DashboardController@getDashBoardInteractions'
    ]);


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

    Route::get('/api/get/user/roles/{userId}', [
        'uses' => 'RoleController@getUserRoles'
    ]);

    Route::get('/user/{userId}/roles', [
        'uses' => 'RoleController@userRoles'
    ]);

    Route::post('/user/{userId}/roles' , [
        'as' => 'user.roles',
        'uses' => 'RoleController@updateUserRoles'
    ]);

    Route::get('/role/{roleId}/user/{userId}/revoke', [
        'uses' => 'RoleController@revokeRoleFromUser'
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

    Route::get('/users/resend/activation/link/{id}', [
        'uses' => 'UserController@resendActivation'
    ]);

    Route::get('/user/{id}/role/', [
        'uses' => 'UserController@userRoles'
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
    Route::get('/api/contacts', [
        'uses' => 'ContactController@getContacts'
    ]);

    Route::get('/api/contacts/user/{userId}', [
        'uses' => 'ContactController@getUserClients'
    ]);

    Route::get('/contacts', [
        'uses' =>'ContactController@contacts'
    ]);

    Route::get('/contacts/user/{userId?}', [
        'uses' =>'ContactController@index'
    ]);

    Route::get('/contacts/info/{userId}', [
        'uses' => 'ContactController@getInfo'
    ]);

    Route::post('/contacts/save', [
        'as' => 'contacts.save',
        'uses' => 'ContactController@store'
    ]);

    Route::get('/contact/details/{id}', [
        'uses' => 'ContactController@details'
    ]);

    Route::get('/api/contact/details/{id}', [
        'uses' => 'ContactController@getDetails'
    ]);

    Route::post('/change/contact/status', [
        'uses' => 'ContactController@changeStatus'
    ]);

    Route::post('/contacts/reassign', [
        'uses' => 'ContactController@reassignContacts'
    ]);

    Route::post('/contacts/search', [
        'uses' => 'ContactController@searchUserClients'
    ]);

    Route::post('/contacts/export', [
        'uses' => 'ContactController@exportContacts'
    ]);

    /*
     * Note Routes
     */
    Route::post('/notes/save', [
        'uses' => 'NoteController@save'
    ]);

    /*
     * Services Routes
     */
    Route::get('/services', [
        'uses' => 'ServiceController@index'
    ]);

    Route::get('/api/services', [
        'uses' => 'ServiceController@getServices'
    ]);

    Route::post('/services/save', [
        'as' => 'services.save',
        'uses' => 'ServiceController@store'
    ]);

    /*
     * Interaction Routes
     */
    Route::post('/interactionSchedule/save', [
        'uses' => 'InteractionController@storeSchedule'
    ]);

    Route::post('/interaction/save', [
        'uses' => 'InteractionController@store'
    ]);

    Route::get('/api/interactions/{userId}', [
        'uses' => 'InteractionController@getInteractions'
    ]);

    Route::get('/interactions/user/{userId?}', [
        'uses' => 'InteractionController@userInteractions'
    ]);

    Route::post('/interactions/search', [
        'uses' => 'InteractionController@searchInteractions'
    ]);

    Route::post('/interactions/export', [
        'uses' => 'InteractionController@exportInteractions'
    ]);
    /*
     * Activities
     */
    Route::get('/activities/{userId?}', [
        'uses' => 'ActivitiesController@index'
    ]);

    Route::get('/info/activities/', [
        'uses' => 'ActivitiesController@getInformation'
    ]);

    Route::post('/activity/save', [
        'uses' => 'ActivitiesController@save'
    ]);

    Route::get('/api/activities/{userId}', [
        'uses' => 'ActivitiesController@getActivities'
    ]);

    Route::post('/update/activities', [
        'uses' => 'ActivitiesController@updateActivityStatus'
    ]);

    Route::post('/activity/comment', [
        'uses' => 'ActivitiesController@createComment'
    ]);

    Route::post('/activity/watch', [
        'uses' => 'ActivitiesController@watchActivity'
    ]);

    Route::post('/activity/search', [
        'uses' => 'ActivitiesController@search'
    ]);

    Route::post('/activity/progress/update', [
        'uses' => 'ActivitiesController@storeProgressUpdate'
    ]);

    Route::get('/api/progress/update/{activityId}', [
        'uses' => 'ActivitiesController@getProgressUpdate'
    ]);
    /*
     * Team
     */
    Route::get('/team', [
        'uses' => 'TeamController@index'
    ]);

    Route::get('/api/teams', [
        'uses' => 'TeamController@getTeams'
    ]);

    Route::get('/teams/info', [
        'uses' => 'TeamController@getInfo'
    ]);

    Route::post('/team/save', [
        'uses' => 'TeamController@store'
    ]);

    /*
     * Team Member
     */
    Route::get('/team/{id}/members', [
        'uses' => 'TeamMemberController@index'
    ]);

    Route::get('/api/team/{id}/members', [
        'uses' => 'TeamMemberController@getTeamMembers'
    ]);
    Route::post('/team/member/save', [
        'uses' => 'TeamMemberController@store'
    ]);

    Route::get('/api/team/{teamId}/member/{userId}/remove', [
        'uses' => 'TeamMemberController@remove'
    ]);

    /*
     * Feedback
     */
    Route::post('/post/feedback', [
        'uses' => 'FeedBackController@store'
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
});
