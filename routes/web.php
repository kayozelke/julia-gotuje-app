<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/id/{id}', function ($id) {
    return '<h3>Hello world, id is ' . $id . '</h3>';
});

Route::get('/test', function () {
    return view('test');
});



Route::get('/greeting', function () {
    return 'Hello World';
});