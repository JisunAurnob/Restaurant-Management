<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Cart;

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
            $customValue['restaurant_photo'] = asset($restaurant['restaurant_photo']);
            $customValue['bg_photo'] = asset($restaurant['bg_photo']);
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
                $customValue['menu_picture'] = asset($menu['menu_picture']);
                $customValue['slug'] = $menu['slug'];
                $customValue['restaurant_id'] = $menu['restaurant_id'];
                $menusCustom->add($customValue);
            }
            return $menusCustom;
        } else {
            $errorMsg['error'] = 'The Restaurant Does Not Exist In Our Database';
            return $errorMsg;
        }
    }

    public function all_products_with_menu($slug)
    {
        if (Restaurant::where('slug', '=', $slug)->exists()) {
            $restaurant_id = Restaurant::where('slug', '=', $slug)->select('id')->first();
            // dd($restaurant_id['id']);
            $menuProducts = collect();
            // $customValue = array();
            $menuWithProducts = Menu::where('restaurant_id', '=', $restaurant_id['id'])->select('id', 'menu_name')->get();
            foreach ($menuWithProducts as $menu) {
                // dd($menu['products']);
                // dd($menu->id);
                $productWithAttributes = Product::where('menu_id', '=', $menu->id)->with('product_attributes')->get();
                if ($productWithAttributes) {
                    $customValue['menu_id'] = $menu->id;
                    $customValue['menu_name'] = $menu->menu_name;
                    // dd($productWithAttributes);

                    $cstmproducts = collect();
                    foreach ($productWithAttributes as $productWithAttribute) {

                        $cstmValue['id'] = $productWithAttribute['id'];
                        $cstmValue['product_name'] = $productWithAttribute['product_name'];
                        $cstmValue['product_description'] = $productWithAttribute['product_description'];
                        $cstmValue['product_picture'] = asset($productWithAttribute['product_picture']);
                        $cstmValue['product_type'] = $productWithAttribute['product_type'];
                        $cstmValue['product_price'] = $productWithAttribute['product_price'];
                        $cstmValue['product_status'] = $productWithAttribute['product_status'];
                        $cstmValue['product_attributes'] = $productWithAttribute['product_attributes'];
                        $cstmproducts->add($cstmValue);
                    }
                    $customValue['products'] = $cstmproducts;
                    // $cstmproducts=null;
                    // dd($customValue);
                    $menuProducts->add($customValue);
                }
            }
            return $menuProducts;
        } else {
            $errorMsg['error'] = 'The Restaurant Does Not Exist In Our Database';
            return $errorMsg;
        }
    }

    public function popular_products($slug)
    {
        if (Restaurant::where('slug', '=', $slug)->exists()) {
            $restaurant_id = Restaurant::where('slug', '=', $slug)->select('id')->first();
            // dd($restaurant_id['id']);
            $popularProducts = collect();
            // $customValue = array();
            $menuWithProducts = Menu::where('restaurant_id', '=', $restaurant_id['id'])->select('id')->get();
            // dd($allProducts);
            foreach ($menuWithProducts as $menu) {
                // dd($menu['products']);
                $productWithAttributes = Product::where('menu_id', '=', $menu->id)->where('product_status', '=', 'popular')->with('product_attributes')->get();
                if (!empty($productWithAttributes)) {
                    foreach ($productWithAttributes as $productWithAttribute) {

                        $customValue['id'] = $productWithAttribute['id'];
                        $customValue['product_name'] = $productWithAttribute['product_name'];
                        $customValue['product_description'] = $productWithAttribute['product_description'];
                        $customValue['product_picture'] = asset($productWithAttribute['product_picture']);
                        $customValue['product_type'] = $productWithAttribute['product_type'];
                        $customValue['product_price'] = $productWithAttribute['product_price'];
                        $customValue['product_status'] = $productWithAttribute['product_status'];
                        $customValue['product_attributes'] = $productWithAttribute['product_attributes'];
                        $popularProducts->add($customValue);
                    }
                }
            }
            // dd($popularProducts[0]);
            return $popularProducts;
        } else {
            $errorMsg['error'] = 'The Restaurant Or Popular Products Does Not Exist';
            return $errorMsg;
        }
    }

    public function products_by_menu($slug, $menuID)
    {
        $productsCustom = collect();
        $customValue = array();

        if (Restaurant::where('slug', '=', $slug)->exists()) {

            if (Menu::where('slug', '=', $menuID)->exists()) {
                $menu = Menu::where('slug', '=', $menuID)->first();
                $products = Product::where('menu_id', '=', $menu->id)->with('product_attributes')->get();
            } else {
                $products = Product::where('menu_id', '=', $menuID)->with('product_attributes')->get();
            }
            foreach ($products as $product) {
                // dd($menu);
                $customValue['id'] = $product['id'];
                $customValue['product_name'] = $product['product_name'];
                $customValue['product_description'] = $product['product_description'];
                $customValue['product_picture'] = asset($product['product_picture']);
                $customValue['product_type'] = $product['product_type'];
                $customValue['product_price'] = $product['product_price'];
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
                $customValue['product_picture'] = asset($product['product_picture']);
                $customValue['product_type'] = $product['product_type'];
                $customValue['product_price'] = $product['product_price'];
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
            $customValue['product_picture'] = asset($product['product_picture']);
            $customValue['product_type'] = $product['product_type'];
            $customValue['product_status'] = $product['product_status'];
            $customValue['product_attributes'] = $product['product_attributes'];
            return $customValue;
        } else {
            $errorMsg['error'] = 'The Restaurant Does Not Exist In Our Database';
            return $errorMsg;
        }
    }

    public function order(Request $request, $slug)
    {
        $restaurant_id = Restaurant::where('slug', '=', $slug)->select('id')->first();

        if ($request->isMethod('post')) {
            $message = "";
            $data = $request->all();


            $rules = [
                'products' => 'required',
            ];
            $customMessages = [
                'products.required' => 'You need to add products to cart for order!'
            ];
            $this->validate($request, $rules, $customMessages);


            Cart::session($restaurant_id);
            $i = 0;
            foreach ($data['products'] as $product) {
                // dd($i);
                // dd($product['id']);
                Cart::add(array(
                    'id' => $i,
                    // 'id' => (int)$product['id'],
                    'name' => $product['product_name'],
                    'price' => $product['product_price'],

                    'quantity' => $product['qty'],
                    'attributes' => array('size' => $product['size']),
                ));
                $i++;
            }
            // dd(Cart::getContent());
            $order = new Order();
            if (!empty($restaurant_id)) {
                $order->restaurant_id = $restaurant_id['id'];
            }
            $order->order_number = Str::random(6) . time();
            $order->cart = Cart::getContent();
            $order->totalQty = Cart::getTotalQuantity();


            if (!empty($data['vat'])) {

                $order->vat = $data['vat'];
                $order->total_amount = Cart::getTotal() + (int)$data['vat'];
            } else {

                $order->vat = 0;
                $order->total_amount = Cart::getTotal();
            }
            $order->status = 1;
            if (!empty($data['order_note'])) {
                $order->order_note = $data['order_note'];
            }
            if (!empty($data['customer_name'])) {
                $order->customer_name = $data['customer_name'];
                $order->customer_email = $data['customer_email'];
                $order->customer_phone = $data['customer_phone'];
            }

            $order->table_number = $data['table_number'];

            $order->save();

            $message = 'Order Placed Successfully!';
            return response()->json($message);
        }
    }

    function orders_by_phone($slug, $phone)
    {
        $ordersCustom = collect();
        $customValue = array();

        if (Restaurant::where('slug', '=', $slug)->exists()) {
            $restaurant_id = Restaurant::where('slug', '=', $slug)->select('id')->first();
            $orders = Order::where([
                'restaurant_id' => $restaurant_id['id'],
                'customer_phone' => $phone,
            ])->latest('id')->get();
        }
        if (!empty($orders)) {
            foreach ($orders as $order) {
                // dd($menu);
                $customValue['id'] = $order['id'];
                $customValue['order_number'] = $order['order_number'];
                $customValue['table_number'] = $order['table_number'];
                $customValue['totalQty'] = $order['totalQty'];
                $customValue['total_amount'] = $order['total_amount'];
                $customValue['time'] = date("g:iA", strtotime($order['created_at']->toTimeString()));
                $customValue['date'] = $order['created_at']->toDateString();
                $customValue['status'] = $order['status'];
                $customValue['products'] = json_decode($order->cart, 'true');
                $ordersCustom->add($customValue);
            }
        }
        return $ordersCustom;
    }

    public function cancelOrder($slug, $id)
    {
        if (Restaurant::where('slug', '=', $slug)->exists()) {
            $restaurant_id = Restaurant::where('slug', '=', $slug)->select('id')->first();
            Order::where([
                'restaurant_id' => $restaurant_id['id'],
                'id' => $id,
         ])->update(['status' => 4]);
        }
        $message = 'Order Canceled!';
        return response()->json($message);
    }
}
