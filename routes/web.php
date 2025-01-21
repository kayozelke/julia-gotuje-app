<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;

// ########### FRONT ######################

    Route::get('/', function () {
        return view('front/home_page');;
    })->name('home');

    // front categories pages
    Route::get('/main_categories', [CategoryController::class, 'frontListCategoriesWithParentParam'])->name('main_categories');
    Route::get('/categories', [CategoryController::class, 'frontListCategoriesWithParentParam'])->name('categories');

    // front search
    Route::get('/search', [SearchController::class, 'frontSearch'])->name('search');

    
    // front single view
    // Route::get('/single_post_test', function () {
    //     return view('front/posts/single_post');;
    // })->name('single_post');

// ################ PANEL ###################

Route::get('/admin', function () {
    return redirect()->route('admin.home');
})->name("admin");

Route::get('/admin/home', 
    // function () {
    //     return view('panel.auth.home_page');
    // }
    [DashboardController::class, 'dashboardPanel']
)->middleware('auth')->name('admin.home');

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Route::middleware("auth")->group(function () {
// //     // Route::view("admin/home", [AuthController::class, 'index'])->name("admin.home");
//     return redirect()->route('admin.home');
// });

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
Route::get('/admin/posts/add', [PostController::class, 'panelUpdate'])->middleware('auth')->name('admin.posts.add');
Route::post('/admin/posts/add_post', [PostController::class, 'panelUpdatePost'])->middleware('auth')->name('admin.posts.add.post');
Route::get('/admin/posts/update', [PostController::class, 'panelUpdate'])->middleware('auth')->name('admin.posts.update');
Route::post('/admin/posts/update_post', [PostController::class, 'panelUpdatePost'])->middleware('auth')->name('admin.posts.update.post');
Route::get('/admin/posts/show', [PostController::class, 'panelShow'])->middleware('auth')->name('admin.posts.show');
Route::get('/admin/posts/delete', [PostController::class, 'panelDelete'])->middleware('auth')->name('admin.posts.delete');
Route::post('/admin/posts/delete', [PostController::class, 'panelDeletePost'])->middleware('auth')->name('admin.posts.delete.post');

// admin images
Route::get('/admin/images', [ImageController::class, 'panelList'])->middleware('auth')->name('admin.images');
Route::get('/admin/images/add', [ImageController::class, 'panelAdd'])->middleware('auth')->name('admin.images.add');
Route::post('/admin/images/add_post', [ImageController::class, 'panelAddPost'])->middleware('auth')->name('admin.images.add.post');
Route::get('/admin/images/show', [ImageController::class, 'panelShow'])->middleware('auth')->name('admin.images.show');
Route::get('/admin/images/update', [ImageController::class, 'panelUpdate'])->middleware('auth')->name('admin.images.update');
Route::post('/admin/images/update', [ImageController::class, 'panelUpdatePost'])->middleware('auth')->name('admin.images.update.post');
Route::get('/admin/images/delete', [ImageController::class, 'panelDelete'])->middleware('auth')->name('admin.images.delete');
Route::post('/admin/images/delete', [ImageController::class, 'panelDeletePost'])->middleware('auth')->name('admin.images.delete.post');

// admin settings
Route::get('/admin/settings', [SettingsController::class, 'panelList'])->middleware('auth')->name('admin.settings');
Route::get('/admin/settings/update/{id}', [SettingsController::class, 'edit'])->middleware('auth')->name('admin.settings.update.form');
Route::put('/admin/settings/update', [SettingsController::class, 'panelUpdate'])->middleware('auth')->name('admin.settings.update');

// admin search
Route::get('/admin/search', [SearchController::class, 'panelSearch'])->middleware('auth')->name('admin.search');

// api calls
Route::get('/api/generate_page_url', [PostController::class, 'apiGeneratePageUrl'])->middleware('auth');
// Route::get('/api/generate_page_url', [PostController::class, 'apiGeneratePageUrl']);
Route::get('/api/search_panel', [SearchController::class, 'apiSearchPanel'])->middleware('auth');



// ################ TEST #####################

// Route::get('/user/{id}', [UserController::class, 'show']);
// Route::get('/test_kayoz', [CategoryController::class, 'testKayoz']);
Route::get('/debug', [CategoryController::class, 'wrongClassTest']);



// ############################################

// Route for dynamic pages must be at the end
Route::get('/{custom_url}', [PostController::class, 'show'])
    ->where('custom_url', '[a-zA-Z0-9\-]+')
    ->name('posts.show'); 

