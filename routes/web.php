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

    $router->post('users/update-status/{id}/{status}', 'UserController@updateStatus')->name('users.update-status');
    $router->resource('users', 'UserController');
});