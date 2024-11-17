<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/template_index');


Route::get('/id/{id}', function ($id) {
    return '<h3>Hello world, id is ' . $id . '</h3>';
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::get('/template_index', function () {
    return view('template_index');
});

Route::get('/template_single', function () {
    return view('template_single');
});
