<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RestaurantController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'restaurant', 'namespace'=> 'api'], function () {
    Route::get('{slug}', [RestaurantController::class, 'restaurantInfo']);
    Route::get('{slug}/menu', [RestaurantController::class, 'menuInfo']);
    Route::get('{slug}/menu/allproducts', [RestaurantController::class, 'all_products_with_menu']);
    Route::get('{slug}/popular/products', [RestaurantController::class, 'popular_products']);
    Route::get('{slug}/{menuID}/products', [RestaurantController::class, 'products_by_menu']);
    Route::get('{slug}/{menuID}/products/{productType}', [RestaurantController::class, 'products_by_menu_and_product_type']);
    Route::get('{slug}/product/{productID}', [RestaurantController::class, 'product_by_id']);
    Route::post('{slug}/order', [RestaurantController::class, 'order']);
});
