<?php

/**
 * Authentication
 */
Route::group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Odotmedia\Dashboard\Controllers'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::post('login', ['uses' => 'AuthController@authentication']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    Route::get('reset', ['as' => 'reset', 'uses' => 'AuthController@reset']);
    Route::post('reset', ['uses' => 'AuthController@resetPassword']);
    Route::get('register', ['as' => 'register', 'uses' => 'AuthController@register']);
    Route::post('register', ['uses' => 'AuthController@registration']);
    Route::get('activate', ['as' => 'activate', 'uses' => 'AuthController@activate']);
    Route::post('activate', ['uses' => 'AuthController@activation']);
    Route::get('unauthorized', ['as' => 'unauthorized', 'uses' => 'AuthController@unauthorized']);
});

/**
 * Dashboard Index
 */
Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => 'Odotmedia\Dashboard\Controllers\DashboardController@dashboard']);

/**
 * Account management.
 */
Route::group(['prefix' => 'dashboard/account', 'as' => 'account.', 'namespace' => 'Odotmedia\Dashboard\Controllers'], function () {
    Route::get('/', ['as' => 'edit', 'uses' => 'AccountController@edit']);
});

/**
 * Roles management.
 */
Route::group(['prefix' => 'dashboard/roles', 'as' => 'roles.', 'namespace' => 'Odotmedia\Dashboard\Controllers'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'RolesController@index']);
    Route::get('create', ['as' => 'create', 'uses' => 'RolesController@create']);
    Route::post('/', ['uses' => 'RolesController@store']);
    Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'RolesController@edit']);
    Route::post('{id}/edit', 'RolesController@update');
    Route::delete('{id}/delete', ['as' => 'delete', 'uses' => 'RolesController@delete']);
});

/**
 * Users management.
 */
Route::group(['prefix' => 'dashboard/users', 'as' => 'users.', 'namespace' => 'Odotmedia\Dashboard\Controllers'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'UsersController@index']);
    Route::get('create', ['as' => 'create', 'uses' => 'UsersController@create']);
    Route::post('/', ['uses' => 'UsersController@store']);
    Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'UsersController@edit']);
    Route::post('{id}/edit', 'UsersController@update');
    Route::delete('{id}/delete', ['as' => 'delete', 'uses' => 'UsersController@delete']);
});

/**
 * Permissions management.
 */
Route::group(['prefix' => 'dashboard/permissions', 'as' => 'permissions.', 'namespace' => 'Odotmedia\Dashboard\Controllers'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'PermissionsController@index']);
    Route::get('create', ['as' => 'create', 'uses' => 'PermissionsController@create']);
    Route::post('/', ['uses' => 'PermissionsController@store']);
    Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'PermissionsController@edit']);
    Route::post('{id}/edit', 'PermissionsController@update');
    Route::delete('{id}/delete', ['as' => 'delete', 'uses' => 'PermissionsController@delete']);
});