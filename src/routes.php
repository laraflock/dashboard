<?php

/**
 * Authentication
 */
$this->app['router']->group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Laraflock\Dashboard\Controllers'], function () {
    $this->app['router']->get('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    $this->app['router']->post('login', ['uses' => 'AuthController@authentication']);
    $this->app['router']->get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    $this->app['router']->get('reset', ['as' => 'reset', 'uses' => 'AuthController@reset']);
    $this->app['router']->post('reset', ['uses' => 'AuthController@resetPassword']);
    $this->app['router']->get('register', ['as' => 'register', 'uses' => 'AuthController@register']);
    $this->app['router']->post('register', ['uses' => 'AuthController@registration']);
    $this->app['router']->get('activate', ['as' => 'activate', 'uses' => 'AuthController@activate']);
    $this->app['router']->post('activate', ['uses' => 'AuthController@activation']);
    $this->app['router']->get('unauthorized', ['as' => 'unauthorized', 'uses' => 'AuthController@unauthorized']);
});

/**
 * Dashboard Index
 */
$this->app['router']->get('dashboard', ['as' => 'dashboard.index', 'uses' => 'Laraflock\Dashboard\Controllers\DashboardController@dashboard', 'middleware' => ['user', 'roles:administrator']]);

/**
 * Account management.
 */
$this->app['router']->group(['prefix' => 'dashboard/account', 'as' => 'account.', 'namespace' => 'Laraflock\Dashboard\Controllers', 'middleware' => 'user'], function () {
    $this->app['router']->get('/', ['as' => 'edit', 'uses' => 'AccountController@edit']);
    $this->app['router']->post('/{id}', ['as' => 'update', 'uses' => 'AccountController@update']);
});

/**
 * Roles management.
 */
$this->app['router']->group(['prefix' => 'dashboard/roles', 'as' => 'roles.', 'namespace' => 'Laraflock\Dashboard\Controllers', 'middleware' => ['user', 'roles:administrator']], function () {
    $this->app['router']->get('/', ['as' => 'index', 'uses' => 'RolesController@index']);
    $this->app['router']->get('create', ['as' => 'create', 'uses' => 'RolesController@create']);
    $this->app['router']->post('/', ['uses' => 'RolesController@store']);
    $this->app['router']->get('{id}/edit', ['as' => 'edit', 'uses' => 'RolesController@edit']);
    $this->app['router']->post('{id}/edit', 'RolesController@update');
    $this->app['router']->delete('{id}/delete', ['as' => 'delete', 'uses' => 'RolesController@delete']);
});

/**
 * Users management.
 */
$this->app['router']->group(['prefix' => 'dashboard/users', 'as' => 'users.', 'namespace' => 'Laraflock\Dashboard\Controllers', 'middleware' => ['user', 'roles:administrator']], function () {
    $this->app['router']->get('/', ['as' => 'index', 'uses' => 'UsersController@index']);
    $this->app['router']->get('create', ['as' => 'create', 'uses' => 'UsersController@create']);
    $this->app['router']->post('/', ['uses' => 'UsersController@store']);
    $this->app['router']->get('{id}/edit', ['as' => 'edit', 'uses' => 'UsersController@edit']);
    $this->app['router']->post('{id}/edit', 'UsersController@update');
    $this->app['router']->delete('{id}/delete', ['as' => 'delete', 'uses' => 'UsersController@delete']);
});

/**
 * Permissions management.
 */
$this->app['router']->group(['prefix' => 'dashboard/permissions', 'as' => 'permissions.', 'namespace' => 'Laraflock\Dashboard\Controllers', 'middleware' => ['user', 'roles:administrator']], function () {
    $this->app['router']->get('/', ['as' => 'index', 'uses' => 'PermissionsController@index']);
    $this->app['router']->get('create', ['as' => 'create', 'uses' => 'PermissionsController@create']);
    $this->app['router']->post('/', ['uses' => 'PermissionsController@store']);
    $this->app['router']->get('{id}/edit', ['as' => 'edit', 'uses' => 'PermissionsController@edit']);
    $this->app['router']->post('{id}/edit', 'PermissionsController@update');
    $this->app['router']->delete('{id}/delete', ['as' => 'delete', 'uses' => 'PermissionsController@delete']);
});