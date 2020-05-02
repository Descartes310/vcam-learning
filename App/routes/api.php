<?php

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

Route::group(['prefix' => 'auth'], function() {
    Route::post('login', 'AuthController@login');
    Route::delete('logout', 'AuthController@logout')->middleware('auth:api');
});

Route::group(['prefix' => 'users', 'middleware' => ['auth:api']], function() {
    Route::post('/', 'UserController@add');
    Route::get('/', 'UserController@get');
    Route::get('/{id}', 'UserController@find');
    Route::delete('/{id}', 'UserController@delete');
    Route::match(['put', 'post'],'/{id}', 'UserController@update');
});

Route::group(['prefix' => 'roles', 'middleware' => ['auth:api']], function() {
    Route::post('/', 'RoleController@add');
    Route::post('/{id_role}/user/{id_user}', 'RoleController@addUserRole');
    Route::delete('/{id_role}/user/{id_user}', 'RoleController@deleteUserRole');
    Route::get('/', 'RoleController@get');
    Route::get('/{id}', 'RoleController@find');
    Route::delete('/{id}', 'RoleController@delete');
    Route::match(['put', 'post'],'/{id}', 'RoleController@update');
});

Route::group(['prefix' => 'groups', 'middleware' => ['auth:api']], function() {
    Route::post('/', 'GroupController@add');
    Route::post('/{id_group}/user/{id_user}/admin/{id_admin}', 'GroupController@inviteUser');
    Route::delete('/{id_group}/user/{id_user}', 'GroupController@deleteUserGroup');
    Route::put('/{id_group}/user/{id_user}/admin', 'GroupController@setAsAdmin');
    Route::delete('/{id_group}/user/{id_user}/admin', 'GroupController@removeAsAdmin');
    Route::get('/', 'GroupController@get');
    Route::get('/invitation/{hash}', 'GroupController@addUserGroup');
    Route::get('/{id}', 'GroupController@find');
    Route::delete('/{id}', 'GroupController@delete');
    Route::match(['put', 'post'],'/{id}', 'GroupController@update');
});
