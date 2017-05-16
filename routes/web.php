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

    $router->group(['prefix' => 'users'], function (Router $router) {
        $router->get('', 'AdminUserController@index')
            ->name('admin.users.index')
            ->middleware('has-permission:view-admin-users');

        $router->post('', 'AdminUserController@index')
            ->name('admin.users.index')
            ->middleware('has-permission:view-admin-users');

        $router->get('create', 'AdminUserController@create')
            ->name('admin.users.create')
            ->middleware('has-permission:create-admin-users');

        $router->post('create', 'AdminUserController@store')
            ->name('admin.users.store')
            ->middleware('has-permission:create-admin-users');

        $router->get('edit/{id}', 'AdminUserController@edit')
            ->name('admin.users.edit')
            ->middleware('has-permission:edit-admin-users');

        $router->post('edit/{id}', 'AdminUserController@update')
            ->name('admin.users.update')
            ->middleware('has-permission:edit-admin-users');

        $router->delete('{role}', 'AdminUserController@destroy')
            ->name('admin.users.destroy')
            ->middleware('has-permission:delete-admin-users');
    });

    $router->group(['prefix' => 'roles'], function (Router $router) {
        $router->get('', 'AdminRoleController@index')
            ->name('admin.roles.index')
            ->middleware('has-permission:view-admin-roles');

        $router->post('', 'AdminRoleController@index')
            ->name('admin.roles.index')
            ->middleware('has-permission:view-admin-roles');

        $router->get('create', 'AdminRoleController@create')
            ->name('admin.roles.create')
            ->middleware('has-permission:create-admin-roles');

        $router->post('create', 'AdminRoleController@store')
            ->name('admin.roles.store')
            ->middleware('has-permission:create-admin-roles');

        $router->get('edit/{id}', 'AdminRoleController@edit')
            ->name('admin.roles.edit')
            ->middleware('has-permission:edit-admin-roles');

        $router->post('edit/{id}', 'AdminRoleController@update')
            ->name('admin.roles.update')
            ->middleware('has-permission:edit-admin-roles');

        $router->delete('{role}', 'AdminRoleController@destroy')
            ->name('admin.roles.destroy')
            ->middleware('has-permission:delete-admin-roles');
    });

    $router->group(['prefix' => 'permissions'], function (Router $router) {
        $router->get('', 'AdminPermissionController@index')
            ->name('admin.permissions.index')
            ->middleware('has-permission:view-admin-permissions');

        $router->post('', 'AdminPermissionController@index')
            ->name('admin.permissions.index')
            ->middleware('has-permission:view-admin-permissions');

        $router->get('create', 'AdminPermissionController@create')
            ->name('admin.permissions.create')
            ->middleware('has-permission:create-admin-permissions');

        $router->post('create', 'AdminPermissionController@store')
            ->name('admin.permissions.store')
            ->middleware('has-permission:create-admin-permissions');

        $router->get('edit/{id}', 'AdminPermissionController@edit')
            ->name('admin.permissions.edit')
            ->middleware('has-permission:edit-admin-permissions');

        $router->post('edit/{id}', 'AdminPermissionController@update')
            ->name('admin.permissions.update')
            ->middleware('has-permission:edit-admin-permissions');

        $router->delete('{role}', 'AdminPermissionController@destroy')
            ->name('admin.permissions.destroy')
            ->middleware('has-permission:delete-admin-permissions');
    });
});