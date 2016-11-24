<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function() {
    return (config('vault.splash_page')) ? view('home') : redirect()->route('lockbox.index');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::get('/home', [
        'uses'  => 'LockboxController@index',
        'as'    => 'lockbox.index'
    ]);

    Route::get('lockbox/create', [
        'uses'  => 'LockboxController@create',
        'as'    => 'lockbox.create'
    ]);

    Route::post('lockbox/create', [
        'uses'  => 'LockboxController@store',
        'as'    => 'lockbox.create'
    ]);

    Route::get('lockbox/{uuid}', [
        'uses'  => 'LockboxController@show',
        'as'    => 'lockbox.show'
    ]);

    Route::get('lockbox/{uuid}/edit', [
        'uses'  => 'LockboxController@edit',
        'as'    => 'lockbox.edit'
    ]);

    Route::post('lockbox/{uuid}/edit', [
        'uses'  => 'LockboxController@update',
        'as'    => 'lockbox.edit'
    ]);

    Route::delete('lockbox', [
        'uses'  => 'LockboxController@destroy',
        'as'    => 'lockbox.destroy'
    ]);

    Route::post('secret/update', [
        'uses'  => 'SecretController@update',
        'as'    => 'secret.update'
    ]);


    Route::get('user', [
        'uses'  => 'UserController@edit',
        'as'    => 'user.edit'
    ]);

    Route::post('user', [
        'uses'  => 'UserController@update',
        'as'    => 'user.edit'
    ]);

    Route::get('user/{uuid}/lockboxes', [
        'uses'  => 'UserController@lockboxes',
        'as'    => 'user.lockboxes'
    ]);

    Route::group(['namespace' => 'Vaults'], function() {
        Route::get('vaults', [
            'uses'  => 'VaultController@index',
            'as'    => 'vault.index'
        ]);

        Route::get('vault/create', [
            'uses'  => 'VaultController@create',
            'as'    => 'vault.create'
        ]);

        Route::post('vault/create', [
            'uses'  => 'VaultController@store',
            'as'    => 'vault.create'
        ]);

        Route::get('vault/{uuid}', [
            'uses'  => 'VaultController@show',
            'as'    => 'vault.show'
        ]);

        Route::get('vault/{uuid}/edit', [
            'uses'  => 'VaultController@edit',
            'as'    => 'vault.edit'
        ]);

        Route::post('vault/{uuid}/edit', [
            'uses'  => 'VaultController@update',
            'as'    => 'vault.edit'
        ]);

        Route::delete('vault', [
            'uses'  => 'VaultController@destroy',
            'as'    => 'vault.destroy'
        ]);


        Route::post('vault/{uuid}/user', [
           'uses'   => 'UserController@store',
            'as'    => 'vault.user.add'
        ]);

        Route::delete('vault/{uuid}/user', [
            'uses'   => 'UserController@destroy',
            'as'    => 'vault.user.destroy'
        ]);
    });
});