<?php

use Illuminate\Support\Facades\Route;
use Laililmahfud\Adminportal\Controllers\Api\ApiTokenController;

Route::group(['prefix' => 'token', 'as' => 'token-', 'controller' => ApiTokenController::class], function () {
    Route::get('/get', 'getToken')->name('get');
    Route::get('/renew', 'renewToken')->name('renew');
});