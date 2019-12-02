<?php

Route::prefix('auth')->namespace('Auth\Back')->group(function () {

    Route::post('logout', 'AuthController@postLogout')->middleware('back-auth');

    Route::middleware('back-no-auth')->group(function () {
        Route::post('login', 'AuthController@postLogin');

        Route::prefix('password')->group(function () {
            Route::post('reminder', 'ResetPasswordController@sendPasswordReminder');

            Route::prefix('{code}/{userId}')->group(function () {
                Route::get('check', 'ResetPasswordController@verifyPasswordResetData');
                Route::post('reset', 'ResetPasswordController@resetPassword');
            });
        });
    });
});

Route::middleware('back-auth')->group(function () {
    Route::get('dashboard', 'Dashboard\ApiController@index');

    Route::prefix('log')->namespace('Log')->group(function () {

    });
});