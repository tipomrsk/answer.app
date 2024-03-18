<?php

use App\Http\Controllers\{AnswerController, FormController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return 'Hello World';
});

Route::prefix('/form')->group(function () {
    Route::post('/create', [FormController::class, 'create']);
    Route::get('/show/{uuid}', [FormController::class, 'show']);
});

Route::prefix('/answer')->group(function () {
    Route::post('/create', [AnswerController::class, 'create']);
});


