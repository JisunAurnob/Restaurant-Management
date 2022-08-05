<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StaffController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('auth/social', [LoginController::class, 'show'])->name('social.login');
Route::get('oauth/{driver}', [LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('/change-password', [HomeController::class, 'change_pass'])->name('change_pass');
Route::post('/change-password', [HomeController::class, 'change_pass_post'])->name('change_pass_post');
Route::get('reset-pass/{role}/{id}', [AdminController::class, 'reset_pass'])->name('reset_pass');

Route::group(['prefix' => 'admin', 'middleware' => ['AdminIsValid','auth']], function () {
    Route::get('{slug}/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('{slug}/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('{slug}/users/{role}', [AdminController::class, 'show_users'])->name('show_users');
    Route::get('{slug}/add-user/{role}', [RegisterController::class, 'showRegistrationForm'])->name('add_user');
    Route::post('{slug}/add-user', [RegisterController::class, 'register'])->name('add_user_post');
    Route::get('{slug}/edit-staff/{id}', [AdminController::class, 'edit_staff'])->name('edit_staff');
    Route::post('{slug}/edit-staff', [AdminController::class, 'edit_staff_post'])->name('edit_staff_post');
    Route::get('{slug}/{role}/delete/{id}', [AdminController::class, 'delete_user'])->name('delete_user');

    //Restaurant
    Route::get('{slug}/add-restaurant', [AdminController::class, 'add_restaurant'])->name('add_restaurant');
    Route::post('add-restaurant', [AdminController::class, 'add_restaurant_post'])->name('add_restaurant_post');
    Route::get('{slug}/edit-restaurant/{id}', [AdminController::class, 'edit_restaurant'])->name('edit_restaurant');
    Route::post('{slug}/edit-restaurant', [AdminController::class, 'edit_restaurant_post'])->name('edit_restaurant_post');
    Route::get('{slug}/restaurants', [AdminController::class, 'show_restaurants'])->name('show_restaurants');
    //Restaurant

    //Menu & Categorys
    Route::get('{slug}/add-menu', [AdminController::class, 'add_menu'])->name('add_menu');
    Route::post('add-menu', [AdminController::class, 'add_menu_post'])->name('add_menu_post');
    Route::get('{slug}/edit-menu/{id}', [AdminController::class, 'edit_menu'])->name('edit_menu');
    Route::post('{slug}/edit-menu', [AdminController::class, 'edit_restaurant_post'])->name('edit_menu_post');
    Route::get('{slug}/menus', [AdminController::class, 'show_menus'])->name('show_menus');
    Route::get('menus-search/{id}', [AdminController::class, 'menu_search_by_restaurant_id'])->name('search_menu');
    //Menu
    //Product
    Route::get('{slug}/add-product', [AdminController::class, 'add_product'])->name('add_product');
    Route::post('add-product', [AdminController::class, 'add_product_post'])->name('add_product_post');
    Route::get('{slug}/products', [AdminController::class, 'show_products'])->name('show_products');
    Route::get('products-search/{id}', [AdminController::class, 'product_search_by_menu_id'])->name('search_product');
    //Product

});


// Route::group(['prefix' => 'staff', 'middleware' => ['StaffIsValid','auth']], function () {
//     Route::get('dashboard', [StaffController::class, 'dashboard'])->name('staff_dashboard');
//     Route::get('profile', [StaffController::class, 'profile'])->name('staff_profile');
//     Route::get('users/{role}', [StaffController::class, 'show_users'])->name('show_users');
//     Route::get('add-user/{role}', [RegisterController::class, 'showRegistrationForm'])->name('add_user');
//     Route::post('add-user', [RegisterController::class, 'register'])->name('add_user_post');
//     // Route::get('{role}/delete/{id}', [StaffController::class, 'delete_user'])->name('delete_user');
// });
