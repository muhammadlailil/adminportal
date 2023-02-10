<?php

use Illuminate\Support\Facades\Route;
use Laililmahfud\Adminportal\Controllers\Api\ApiTokenController;

Route::group(['prefix' => 'token', 'as' => 'token-', 'controller' => ApiTokenController::class], function () {
    Route::get('/get', 'getToken')->name('get');
    Route::get('/renew', 'renewToken')->name('renew');
});

if (config('app.debug')) {
    Route::get('app-key', function () {
        return base64_encode(date('Y-m-d') . "|" . portal_config('api.secret_key'));
    });
}
