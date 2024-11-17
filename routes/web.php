<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test/{id}', function ($id) {
    return '<h3>Hello world, id is ' . $id . '</h3>';
});


Route::get('/greeting', function () {
    return 'Hello World';
});