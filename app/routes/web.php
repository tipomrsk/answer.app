<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-cache-redis', function() {
    \Cache::store('redis')->put('Laradock', 'Awesome', 100);
});
