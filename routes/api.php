<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\Controller;
use App\Http\Middleware\ApiAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->as('v1.')->group(function() {
    Route::controller(BusinessController::class)->group(function() {
        Route::group(['prefix' => '/business'], function() {
            Route::get('/search/{search}', 'index');
            Route::post('/', 'store');
            Route::put('/', 'update');
            Route::delete('/{id}', 'destroy');
        });
    })->middleware(ApiAuthentication::class);
});
