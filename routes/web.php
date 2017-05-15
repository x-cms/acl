<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your Module. Just tell Your app the URIs it should respond to
| using a Closure or controller method. Build something great!
|
*/

use Illuminate\Routing\Router;

Route::group(['prefix' => 'admin'], function (Router $router) {
    $router->get('login', 'AuthController@showLoginForm')->name('admin.login');
    $router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout')->name('admin.logout');

    $router->resource('users', 'AdminUserController');
    $router->post('users/ajax', 'AdminUserController@ajax')->name('admin.users.ajax');
    $router->post('users/update-status/{id}/{status}', 'AdminUserController@updateStatus')->name('users.update-status');

    $router->group(['prefix' => 'roles'], function (Router $router) {
        $router->get('', 'AdminRoleController@index')
            ->name('admin.roles.index')
            ->middleware('has-permission:view-roles');
        $router->get('/create', 'AdminRoleController@create')
            ->name('admin.roles.create')
            ->middleware('has-permission:create-roles');

    });
    $router->post('roles/ajax', 'AdminRoleController@ajax')->name('admin.roles.ajax');

    $router->resource('permissions', 'AdminPermissionController');
    $router->post('permissions/ajax', 'AdminPermissionController@ajax')->name('admin.permissions.ajax');
});