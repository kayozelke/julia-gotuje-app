<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

// ########### FRONT ######################

    Route::get('/welcome', function () {
        return view('welcome');
    });

    Route::get('/', function () {
        // echo view('front/header');
        // echo view('front/home_page');
        // echo view('front/footer');
        return view('front/home_page');;
    });

    Route::get('/single_post_test', function () {
        // echo view('front/header');
        // echo view('front/single_post');
        // echo view('front/footer');
        return view('front/single_post');;
    });


    // Route::redirect('/', '/template_index');


    Route::get('/id/{id}', function ($id) {
        return '<h3>Hello world, id is ' . $id . '</h3>';
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

// ###################################

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ################ PANEL ###################

Route::get('/admin_test', function () {

    // echo view('panel/auth/header');
    // // echo view('panel/auth/home_page');
    // echo view('panel/auth/account_settings');
    // echo view('panel/auth/footer');
    return view('panel/auth/account_settings');
    // return view('panel/auth/form_horizontal');
});

Route::get('/admin_home', function () {
    return view('panel/auth/home_page');;
});


// ################ TEST #####################

Route::get('/user/{id}', [UserController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);