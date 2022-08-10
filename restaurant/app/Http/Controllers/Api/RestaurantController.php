<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function restaurantInfo($slug)
    {
        if (Restaurant::where('slug', '=', $slug)->exists()) {
            $restaurant = Restaurant::where('slug', '=', $slug)->first();
            $customValue = array();
            $customValue['id'] = $restaurant['id'];
            $customValue['restaurant_name'] = $restaurant['restaurant_name'];
            $customValue['restaurant_type'] = $restaurant['restaurant_type'];
            $customValue['slogan'] = $restaurant['slogan'];
            $customValue['email'] = $restaurant['email'];
            $customValue['phone'] = $restaurant['phone'];
            $customValue['address'] = $restaurant['address'];
            $customValue['restaurant_photo'] = asset('storage/' . $restaurant['restaurant_photo']);
            $customValue['opening_time'] = date("h:i A", strtotime($restaurant['opening_time']));
            $customValue['closing_time'] = date("h:i A", strtotime($restaurant['closing_time']));
            $customValue['business_days'] = $restaurant['business_days'];
            $customValue['client_id'] = $restaurant['client_id'];
            // $customValue['created_at'] = $restaurant['created_at'];
            // $customValue['updated_at'] = $restaurant['updated_at'];
            // $customValue['slug'] = $restaurant['slug'];

            // dd($customValue);
            return $customValue;
        } else {
            $errorMsg['error'] = 'The Restaurant Does Not Exist In Our Database';
            return $errorMsg;
        }
    }

    public function menuInfo($slug)
    {
        if (Restaurant::where('slug', '=', $slug)->exists()) {
            $menus = Restaurant::where('slug', '=', $slug)->with('menus')->get();
            // dd($menu[0]['menus']);
            $menusCustom = collect();
            $customValue = array();

            foreach ($menus[0]['menus'] as $menu) {
                // dd($menu);
                $customValue['id'] = $menu['id'];
                $customValue['menu_name'] = $menu['menu_name'];
                $customValue['menu_description'] = $menu['menu_description'];
                $customValue['menu_picture'] = asset('storage/' . $menu['menu_picture']);
                $customValue['slug'] = $menu['slug'];
                $customValue['restaurant_id'] = $menu['restaurant_id'];
                $customValue['created_at'] = $menu['created_at'];
                $customValue['updated_at'] = $menu['updated_at'];
                $menusCustom->add($customValue);
            }
            return $menusCustom;
        } else {
            $errorMsg['error'] = 'The Restaurant Does Not Exist In Our Database';
            return $errorMsg;
        }
    }

    public function products_by_menu($slug, $menuID)
    {
        $productsCustom = collect();
        $customValue = array();

        if (Restaurant::where('slug', '=', $slug)->exists()) {

            $products = Product::where('menu_id', '=', $menuID)->with('product_attributes')->get();
            foreach ($products as $product) {
                // dd($menu);
                $customValue['id'] = $product['id'];
                $customValue['product_name'] = $product['product_name'];
                $customValue['product_description'] = $product['product_description'];
                $customValue['product_picture'] = asset('storage/' . $product['product_picture']);
                $customValue['product_type'] = $product['product_type'];
                $customValue['product_status'] = $product['product_status'];
                $customValue['product_attributes'] = $product['product_attributes'];
                $productsCustom->add($customValue);
            }
            return $productsCustom;
        } else {
            $errorMsg['error'] = 'The Restaurant Does Not Exist In Our Database';
            return $errorMsg;
        }
    }

    public function products_by_menu_and_product_type($slug, $menuID, $productType)
    {
        $productsCustom = collect();
        $customValue = array();

        if (Restaurant::where('slug', '=', $slug)->exists()) {

            $products = Product::where([['menu_id', '=', $menuID], ['product_type', '=', $productType]])->with('product_attributes')->get();
            foreach ($products as $product) {
                // dd($menu);
                $customValue['id'] = $product['id'];
                $customValue['product_name'] = $product['product_name'];
                $customValue['product_description'] = $product['product_description'];
                $customValue['product_picture'] = asset('storage/' . $product['product_picture']);
                $customValue['product_type'] = $product['product_type'];
                $customValue['product_status'] = $product['product_status'];
                $customValue['product_attributes'] = $product['product_attributes'];
                $productsCustom->add($customValue);
            }
            return $productsCustom;
        } else {
            $errorMsg['error'] = 'The Restaurant Does Not Exist In Our Database';
            return $errorMsg;
        }
    }

    public function product_by_id($slug, $productID)
    {
        // dd($productID);
        $customValue = array();
        if (Restaurant::where('slug', '=', $slug)->exists()) {

            $product = Product::where('id', '=', $productID)->with('product_attributes')->first();
            $customValue['id'] = $product['id'];
            $customValue['product_name'] = $product['product_name'];
            $customValue['product_description'] = $product['product_description'];
            $customValue['product_picture'] = asset('storage/' . $product['product_picture']);
            $customValue['product_type'] = $product['product_type'];
            $customValue['product_status'] = $product['product_status'];
            $customValue['product_attributes'] = $product['product_attributes'];
            return $customValue;
        } else {
            $errorMsg['error'] = 'The Restaurant Does Not Exist In Our Database';
            return $errorMsg;
        }
    }
}
