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

    // front categories pages
    Route::get('/top_categories', [CategoryController::class, 'FrontListCategoriesWithParentParam'])->name('top_categories');
    Route::get('/categories', [CategoryController::class, 'FrontListCategoriesWithParentParam'])->name('categories');

    
    // front single view
    Route::get('/single_post_test', function () {
        return view('front/single_post');;
    });

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
Route::get('/admin/categories', [CategoryController::class, 'panelList'])->middleware('auth')->name('admin.categories');
Route::post('/admin/categories/add', [CategoryController::class, 'panelAddPost'])->middleware('auth')->name('admin.categories.add');
Route::get('/admin/categories/update', [CategoryController::class, 'panelUpdate'])->middleware('auth')->name('admin.categories.update');
Route::get('/admin/categories/delete', [CategoryController::class, 'panelDelete'])->middleware('auth')->name('admin.categories.delete');
Route::post('/admin/categories/delete', [CategoryController::class, 'panelDeletePost'])->middleware('auth')->name('admin.categories.delete.post');


// admin posts
Route::get('/admin/posts', [PostController::class, 'panelList'])->middleware('auth')->name('admin.posts');
Route::get('/admin/posts/add', [CategoryController::class, 'panelAdd'])->middleware('auth')->name('admin.posts.add');


// ################ TEST #####################

Route::get('/user/{id}', [UserController::class, 'show']);
// Route::get('/categories', [CategoryController::class, 'index']);

