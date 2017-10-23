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
        return view('dashboard.index');
    });

    Route::get('/logout', [
        'as' => 'auth.logout',
        'uses' => 'LoginController@destroy'
    ]);
});


Route::group(['middleware' => 'guest'],function() {

    Route::get('/login', [
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
});
