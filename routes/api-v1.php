<?php

Route::prefix('auth')->namespace('Auth\Back')->group(function () {

    Route::post('login', 'AuthController@postLogin');
    Route::post('logout', 'AuthController@postLogout');

    Route::prefix('password')->group(function () {
        Route::post('reminder', 'AuthController@sendPasswordReminder');

        Route::prefix('{code}/{userId}')->group(function () {
            Route::get('check', 'AuthController@verifyPasswordResetData');
            Route::post('reset', 'AuthController@resetPassword');
        });
    });
});

Route::middleware('back-auth')->group(function () {
    Route::get('dashboard', 'Dashboard\ApiController@index');

    Route::prefix('log')->namespace('Log')->group(function () {

    });
});