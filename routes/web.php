<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

// ########### FRONT ######################

    Route::get('/', function () {
        return view('front/home_page');;
    });

    // Route::get('/top_categories', function () {
    //     return view('front/categories_page');;
    // });

    Route::get('/top_categories', [CategoryController::class, 'listCategoriesWithParentParam']);

    Route::get('/categories', function () {
        return view('front/categories_page');;
    });

    Route::get('/single_post_test', function () {
        return view('front/single_post');;
    });

    // Route::redirect('/', '/template_index');

    Route::get('/id/{id?}', function ($id = null) {
        return '<h3>Hello world, id is ' . $id . '</h3>'; //id can be null
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

// ################ PANEL ###################

Route::get('/admin_test', function () {

    // echo view('panel/auth/header');
    // // echo view('panel/auth/home_page');
    // echo view('panel/auth/account_settings');
    // echo view('panel/auth/footer');
    return view('panel/auth/account_settings');
    // return view('panel/auth/form_horizontal');
});

Route::get('/admin', function () {
    return redirect(route('admin.home'));
})->name("admin");

Route::get('/admin/home', function () {
    return view('panel.auth.home_page');
})->middleware('auth')->name('admin.home');

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware("auth")->group(function () {
    // Route::view("admin/home", [AuthController::class, 'index'])->name("admin.home");
    return redirect("/admin");
});

// admin login
Route::get("/login", [AuthController::class, 'login'])->name("login");
Route::post("/login", [AuthController::class, 'loginPost']) ->name("login.post");

// Route::get("/register", function() {
//     return view('panel/unauth/register');
// });

// admin categories
Route::get('/admin/categories/{param?}', [CategoryController::class, 'panelList'])->middleware('auth')->name('admin.categories');
Route::post('/admin/categories/add/{param?}', [CategoryController::class, 'panelAddPost'])->middleware('auth')->name('admin.categories.add');
Route::get('/admin/categories/update/{param?}', [CategoryController::class, 'panelUpdate'])->middleware('auth')->name('admin.categories.update');
Route::get('/admin/categories/delete/{param?}', [CategoryController::class, 'panelDelete'])->middleware('auth')->name('admin.categories.delete');
Route::post('/admin/categories/delete', [CategoryController::class, 'panelDeletePost'])->middleware('auth')->name('admin.categories.delete.post');

// admin posts
Route::get('/admin/posts', [PostController::class, 'panelList'])->middleware('auth')->name('admin.posts');


// ################ TEST #####################

Route::get('/user/{id}', [UserController::class, 'show']);
// Route::get('/categories', [CategoryController::class, 'index']);

