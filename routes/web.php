<?php

use Illuminate\Support\Facades\Route;

########### FRONT ######################

    Route::get('/welcome', function () {
        return view('welcome');
    });

    Route::get('/', function () {
        echo view('front/header');
        echo view('front/home_page');
        echo view('front/footer');
        return;
    });

    Route::get('/single_post_test', function () {
        echo view('front/header');
        echo view('front/single_post');
        echo view('front/footer');
        return;
    });


    // Route::redirect('/', '/template_index');


    Route::get('/id/{id}', function ($id) {
        return '<h3>Hello world, id is ' . $id . '</h3>';
    });

    Route::get('/test', function () {
        return view('panel/test');
    });

    // Route::get('/dev', function () {
    //     echo view('header_view');
    //     echo view('home_page_view');
    //     echo view('footer_view');
    // });

    // Route::get('/template_index', function () {
    //     return view('templates/template_index');
    // });

    // Route::get('/template_single', function () {
    //     return view('templates/template_single');
    // });

################ PANEL ###################

Route::get('/admin_test', function () {
    echo view('panel/header');
    echo view('panel/home_page');
    echo view('panel/footer');
    return;
});
