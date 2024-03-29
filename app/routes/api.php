<?php

use App\Http\Controllers\{AnswerController, FormController, UserController};
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
    Route::get('/list-by-user/{user_uuid}', [FormController::class, 'listByUser']);
});

Route::prefix('/answer')->group(function () {
    Route::post('/create', [AnswerController::class, 'create']);
    Route::get('/list-by-form/{formUuid}', [AnswerController::class, 'show']);
});

Route::prefix('user')->group(function () {
    Route::post('/create', [UserController::class, 'create']);
    Route::get('/show/{uuid}', [UserController::class, 'show']);
});


