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

    Route::prefix('my-account')->namespace('User')->group(function () {
        Route::get('/', 'MyAccountApiController@getCurrentLoggedUserData');
        Route::put('/', 'MyAccountApiController@saveCurrentLoggedUserData');
    });

    Route::prefix('file-manager')->namespace('FileManager')->group(function () {
        Route::resource('directories', 'ApiDirectoriesController')->only(['index', 'store', 'update', 'destroy']);
        Route::post('directories/{directory}/move', 'ApiDirectoriesController@move');

        Route::prefix('files')->group(function () {
            Route::post('/', 'ApiFilesController@store');

            Route::prefix('{file}')->group(function () {
                Route::put('/', 'ApiFilesController@update');
                Route::delete('/', 'ApiFilesController@destroy');
                Route::get('preview', 'ApiFilesController@getPreviewData');
            });
        });
    });
});