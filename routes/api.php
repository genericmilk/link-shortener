<?php

use App\Http\Controllers\Api\ApiLinksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum', 'abilities:read'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('decode', [ApiLinksController::class, 'decode']);

});

Route::group(['middleware' => 'auth:sanctum', 'abilities:create'], function () {
    Route::post('encode', [ApiLinksController::class, 'encode']);

});
