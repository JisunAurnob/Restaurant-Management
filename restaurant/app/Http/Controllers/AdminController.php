<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Product;
use App\Models\Product_attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        // dd(auth()->user());
        $userCount = count(User::all());
        if (auth()->user()->role == 'client') {
            $restaCount = count(Restaurant::where('client_id', '=', auth()->user()->id)->get());
        } else {

            $restaCount = count(Restaurant::all());
        }
        $productCount = count(Product::all());
        $clientCount = count(User::where('role', '=', 'client')->get());
        // dd($userCount);
        return view('dashboard')
            ->with('userCount', $userCount)
            ->with('restaCount', $restaCount)
            ->with('clientCount', $clientCount)
            ->with('productCount', $productCount);
    }
    public function profile()
    {
        return view('profile');
    }
    public function show_users($slug, $role)
    {
        $users = User::where('role', '=', $role)->get();
        return view('admin.tables.users_table', compact('users', 'role'));
    }
    public function edit_staff($id)
    {
        $staff = User::find($id);
        return view('admin.forms.edit_staffs', compact('staff'));
    }

    public function edit_staff_post(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
                // 'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id)],
            ],
            []
        );

        $staff = User::find($request->id);
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->save();

        return redirect()->route('show_staffs');
    }

    public function reset_pass($role, $id)
    {
        // dd($role);
        $staff = User::find($id);
        $staff->password = Hash::make('user1234');
        $staff->save();
        $msg = 'The Password Been Reset';
        return redirect()->route('show_users', ['role' => $role, 'slug' => auth()->user()->role]);
    }

    public function delete_user($role, $id)
    {
        $staff = User::find($id);
        $staff->delete();
        return redirect()->route('show_users', ['role' => $role]);
    }

    public function add_restaurant()
    {
        return view('admin.forms.add_restaurant');
    }

    public function add_restaurant_post(Request $request)
    {
        $request->validate(
            [
                'restaurant_name' => 'required|min:2|string|max:255',
                'email' => 'max:255|unique:restaurants,email,',
                'phone' => 'required|max:22|regex:/^([0-9\s\-\+\(\)]*)$/',
                'address' => 'required|max:255',
                'restaurant_type' => 'required|string',
                'slogan' => 'required|string|max:255',
                'restaurant_photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
                'bg_photo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp',
                'opening_time' => 'required',
                'closing_time' => 'required',
                'business_days' => 'required|string|max:255'
            ],
            []
        );

        // if (!empty($request->file('restaurant_photo'))) {
        //     $path = $request->file('restaurant_photo')->store('public/restaurants/pictures');
        //     // $var->Picture= substr($path, 6, 3000);
        // }

        $restaurant = new Restaurant();
        $restaurant->restaurant_name = $request->restaurant_name;
        $restaurant->restaurant_type = $request->restaurant_type;
        $restaurant->slogan = $request->slogan;
        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->address = $request->address;
        //------------------------------------------

        if ($request->hasFile('restaurant_photo')) {
            $image_tmp = $request->file('restaurant_photo');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imgName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'restaurants/pictures/' . $imgName;
                Image::make($image_tmp)->resize(250, 250)->save($imagePath);
                $restaurant->restaurant_photo = $imagePath;
            }
        }

        if ($request->hasFile('bg_photo')) {
            $image_tmp = $request->file('bg_photo');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imgName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'restaurants/pictures/background/' . $imgName;
                Image::make($image_tmp)->save($imagePath);
                $restaurant->bg_photo = $imagePath;
            }
        } else {
            $restaurant->bg_photo = 'restaurants/pictures/background/default_bg.jpg';
        }

        //-----------------------------------------
        // $restaurant->restaurant_photo = substr($path, 7);
        $restaurant->opening_time = $request->opening_time;
        $restaurant->closing_time = $request->closing_time;
        $restaurant->business_days = $request->business_days;
        $restaurant->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', $request->restaurant_name)));
        $restaurant->client_id = $request->client_id;
        $restaurant->save();

        return redirect()->route('show_restaurants', ['slug' => auth()->user()->role]);
    }

    public function show_restaurants($slug)
    {
        if (auth()->user()->role == 'client') {

            $restaurants = Restaurant::where('client_id', '=', auth()->user()->id)->get();
        } else if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
            $restaurants = Restaurant::all();
        }
        return view('admin.tables.restaurants_table', compact('restaurants'));
    }
    public function edit_restaurant($role, $id)
    {
        $restaurant = Restaurant::find($id);
        return view('admin.forms.edit_restaurant', compact('restaurant'));
    }

    public function edit_restaurant_post(Request $request)
    {
        $request->validate(
            [
                'restaurant_name' => 'required|min:2|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
                'phone' => 'required|max:22|regex:/^([0-9\s\-\+\(\)]*)$/',
                'address' => 'required|max:255',
                'restaurant_type' => 'required|string',
                'slogan' => 'required|string|max:255',
                'restaurant_photo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
                'bg_photo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp',
                'opening_time' => 'required',
                'closing_time' => 'required',
                'business_days' => 'required|string|max:255'
            ],
            []
        );

        $restaurant = Restaurant::find($request->id);
        $restaurant->restaurant_name = $request->restaurant_name;
        $restaurant->restaurant_type = $request->restaurant_type;
        $restaurant->slogan = $request->slogan;
        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->address = $request->address;
        //------------------------------------------

        if ($request->hasFile('restaurant_photo')) {
            File::delete($restaurant->restaurant_photo);
            $image_tmp = $request->file('restaurant_photo');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imgName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'restaurants/pictures/' . $imgName;
                Image::make($image_tmp)->resize(250, 250)->save($imagePath);
                $restaurant->restaurant_photo = $imagePath;
            }
        }

        if ($request->hasFile('bg_photo')) {

            if ($restaurant->bg_photo != 'restaurants/pictures/background/default_bg.jpg') {

                File::delete($restaurant->bg_photo);
            }
            $image_tmp = $request->file('bg_photo');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imgName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'restaurants/pictures/background/' . $imgName;
                Image::make($image_tmp)->save($imagePath);
                $restaurant->bg_photo = $imagePath;
            }
        }

        //-----------------------------------------
        $restaurant->opening_time = $request->opening_time;
        $restaurant->closing_time = $request->closing_time;
        $restaurant->business_days = $request->business_days;
        $restaurant->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', $request->restaurant_name)));
        $restaurant->save();

        return redirect()->route('show_restaurants', ['slug' => auth()->user()->role]);
    }

    public function delete_restaurant($role, $id)
    {
        $restaurant = Restaurant::find($id);
        // dd($restaurant);
        File::delete($restaurant->restaurant_photo);
        if ($restaurant->bg_photo != 'restaurants/pictures/background/default_bg.jpg') {

            File::delete($restaurant->bg_photo);
        }
        $restaurant->delete();
        return redirect()->route('show_restaurants', ['slug' => auth()->user()->role]);
    }


    public function add_menu()
    {
        if (auth()->user()->role == 'client') {

            $restaurants = Restaurant::where('client_id', '=', auth()->user()->id)->get();
        } else if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
            $restaurants = Restaurant::all();
        }

        return view('admin.forms.add_menu', compact('restaurants'));
    }

    public function add_menu_post(Request $request)
    {
        $request->validate(
            [
                'menu_name' => 'required|min:2|string|max:255',
                'menu_description' => 'required|max:1000',
                'menu_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'restaurant_id' => 'required|string'
            ],
            []
        );

        // if (!empty($request->file('menu_picture'))) {
        //     $path = $request->file('menu_picture')->store('public/restaurants/menu_pictures');
        //     // $var->Picture= substr($path, 6, 3000);
        // }

        $restaurant = new Menu();
        $restaurant->menu_name = $request->menu_name;
        $restaurant->menu_description = $request->menu_description;
        //------------------------------------------

        if ($request->hasFile('menu_picture')) {
            $image_tmp = $request->file('menu_picture');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imgName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'restaurants/menu_pictures/' . $imgName;
                Image::make($image_tmp)->resize(250, 250)->save($imagePath);
                $restaurant->menu_picture = $imagePath;
            }
        }

        //-----------------------------------------
        // $restaurant->menu_picture = substr($path, 7);
        $restaurant->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', $request->menu_name)));
        $restaurant->restaurant_id = $request->restaurant_id;
        $restaurant->save();

        return redirect()->route('show_menus', ['slug' => auth()->user()->role]);
    }

    public function edit_menu($role, $id)
    {
        $menu = Menu::find($id);
        return view('admin.forms.edit_menu', compact('menu'));
    }

    public function edit_menu_post(Request $request)
    {
        $request->validate(
            [
                'menu_name' => 'required|min:2|string|max:255',
                'menu_description' => 'required|max:1000',
                'menu_picture' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
            ],
            []
        );

        $menu = Menu::find($request->id);
        $menu->menu_name = $request->menu_name;
        $menu->menu_description = $request->menu_description;
        $menu->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', $request->menu_name)));


        if ($request->hasFile('menu_picture')) {

            File::delete($menu->menu_picture);
            $image_tmp = $request->file('menu_picture');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imgName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'restaurants/menu_pictures/' . $imgName;
                Image::make($image_tmp)->resize(250, 250)->save($imagePath);
                $menu->menu_picture = $imagePath;
            }
        }
        $menu->save();

        return redirect()->route('show_menus', ['slug' => auth()->user()->role]);
    }

    public function delete_menu($role, $id)
    {
        $menu = Menu::find($id);
        // dd($menu);
        File::delete($menu->menu_picture);
        $menu->delete();
        return redirect()->route('show_menus', ['slug' => auth()->user()->role]);
        // return redirect()->route('show_users', ['role' => $role]);
    }

    public function show_menus($slug)
    {
        if (auth()->user()->role == 'client') {
            $restaurants = Restaurant::where('client_id', '=', auth()->user()->id)->get();
            // $menus = Restaurant::where('client_id', auth()->user()->id)
            //     ->with('menus')
            //     ->get()->toArray();

            // dd($menus);
        } else if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
            $restaurants = Restaurant::all();
            // $menus = Restaurant::with('menus')
            //     ->get()->toArray();
        }
        return view('admin.tables.menus_table', compact('restaurants'));
    }

    function menu_search_by_restaurant_id($id)
    {
        // $total = '';
        if (Restaurant::where('id', $id)->exists()) {
            $data = Menu::where('restaurant_id', $id)
                ->get();
            //    $total = $data[0]->market_name;
        }
        return $data;
    }

    public function add_product()
    {
        if (auth()->user()->role == 'client') {

            $restaurants = Restaurant::where('client_id', '=', auth()->user()->id)->get();
        } else if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
            $restaurants = Restaurant::all();
        }

        return view('admin.forms.add_product', compact('restaurants'));
    }

    public function add_product_post(Request $request)
    {
        $request->validate(
            [
                'product_name' => 'required|min:2|string|max:255',
                'product_description' => 'required|max:1000',
                'product_type' => 'required|string',
                'product_price' => 'required',
                'availability' => 'required',
                'product_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
                'menu_id' => 'required'
            ],
            []
        );

        // if (!empty($request->file('product_picture'))) {
        //     $path = $request->file('product_picture')->store('public/restaurants/product_pictures');
        //     // $var->Picture= substr($path, 6, 3000);
        // }

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_type = $request->product_type;
        $product->product_price = $request->product_price;
        $product->product_status = $request->product_status;

        //------------------------------------------

        if ($request->hasFile('product_picture')) {
            $image_tmp = $request->file('product_picture');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imgName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'restaurants/product_pictures/' . $imgName;
                Image::make($image_tmp)->resize(250, 250)->save($imagePath);
                $product->product_picture = $imagePath;
            }
        }

        //-----------------------------------------
        // $product->product_picture = substr($path, 7);
        $product->menu_id = $request->menu_id;
        $product->availability = $request->availability;
        $product->save();

        return redirect()->route('show_products', ['slug' => auth()->user()->role]);
    }

    public function show_products($slug)
    {
        if (auth()->user()->role == 'client') {
            $restaurants = Restaurant::where('client_id', '=', auth()->user()->id)->get();
            // $menus = Restaurant::where('client_id', auth()->user()->id)
            //     ->with('menus')
            //     ->get()->toArray();

            // dd($menus);
        } else if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
            $restaurants = Restaurant::all();
            // $menus = Restaurant::with('menus')
            //     ->get()->toArray();
        }
        return view('admin.tables.products_table', compact('restaurants'));
    }

    function product_search_by_menu_id($id)
    {
        // $total = '';
        $data = Product::where('menu_id', $id)
            ->get();
        //    $total = $data[0]->market_name;
        return $data;
    }

    public function edit_product_post(Request $request)
    {
        $request->validate(
            [
                'product_name' => 'required|min:2|string|max:255',
                'product_description' => 'required|max:1000',
                'product_type' => 'required|string',
                'product_price' => 'required',
                'product_picture' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
                'availability' => 'required|string'
            ],
            []
        );

        $product = Product::find($request->product_id);
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_type = $request->product_type;
        $product->product_price = $request->product_price;

        //------------------------------------------

        if ($request->hasFile('product_picture')) {
            File::delete($product->product_picture);
            $image_tmp = $request->file('product_picture');
            if ($image_tmp->isValid()) {
                $extension = $image_tmp->getClientOriginalExtension();
                $imgName = rand(111, 99999) . '.' . $extension;
                $imagePath = 'restaurants/product_pictures/' . $imgName;
                Image::make($image_tmp)->resize(250, 250)->save($imagePath);
                $product->product_picture = $imagePath;
            }
        }

        //-----------------------------------------
        $product->availability = $request->availability;
        $product->product_status = $request->product_status;
        $product->save();

        return redirect()->route('show_products', ['slug' => auth()->user()->role]);
    }

    public function edit_product_with_attributes($slug, $id)
    {
        //dd($id);
        if (auth()->user()->role == 'client' && Restaurant::where('client_id', '=', auth()->user()->id)->exists()) {

            $product = Product::where('id', '=', $id)->with('product_attributes')->get();
            // dd($product);
        } else if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
            $product = Product::where('id', '=', $id)->with('product_attributes')->get();
        }

        return view('admin.forms.add_product_attributes', compact('product'));
    }

    public function edit_product_with_attributes_post(Request $request)
    {
        $request->validate(
            [
                'product_size' => 'required',
                'product_price' => 'required',
                'product_discount' => 'required',
                'product_id' => 'required'
            ],
            []
        );

        $product = new Product_attribute();
        $product->product_size = $request->product_size;
        $product->product_price = $request->product_price;
        $product->product_discount = $request->product_discount;
        $product->product_id = $request->product_id;
        $product->save();

        return redirect()->route('edit_product_with_attributes', ['slug' => auth()->user()->role, 'id' => $request->product_id]);
    }

    public function delete_product_attribute($role, $pid, $id)
    {
        $pa = Product_attribute::find($id);
        $pa->delete();
        return redirect()->route('edit_product_with_attributes', ['slug' => auth()->user()->role, 'id' => $pid]);
    }

    public function delete_product($role, $id)
    {
        $product = Product::find($id);
        File::delete($product->product_picture);
        $product->delete();
        return redirect()->route('show_products', ['slug' => auth()->user()->role]);
    }

    public function getOrders($slug, $order_status = null, $rest_id = null)
    {
        $ordersCustom = collect();
        $customValue = array();
        if (auth()->user()->role == 'client') {
            $restaurants = Restaurant::where('client_id', '=', auth()->user()->id)->select('id', 'restaurant_name')->get();
            // dd($restaurants[0]->id);
            if ($rest_id == null) {
                if (Restaurant::where('id', $restaurants[0]->id)->exists()) {

                    if ($order_status && $order_status != "all") {
                        $orders = Order::where(['restaurant_id' => $restaurants[0]->id, 'status' => $order_status])
                            ->get();
                    } elseif ($order_status == "all") {
                        $orders = Order::where(['restaurant_id' => $restaurants[0]->id])
                            ->get();
                    } else {
                        $orders = Order::where(['restaurant_id' => $restaurants[0]->id, 'status' => $order_status])
                            ->get();
                    }
                }
            } else {
                if (Restaurant::where('id', $rest_id)->exists()) {
                    if ($order_status && $order_status != "all") {
                        $orders = Order::where(['restaurant_id' => $rest_id, 'status' => $order_status])
                            ->get();
                    } elseif ($order_status == "all") {
                        $orders = Order::where(['restaurant_id' => $rest_id])
                            ->get();
                    } else {
                        $orders = Order::where(['restaurant_id' => $restaurants[0]->id, 'status' => $order_status])
                            ->get();
                    }
                }
            }
            if (!empty($orders)) {
                foreach ($orders as $order) {
                    // dd($menu);
                    $customValue['id'] = $order['id'];
                    $customValue['order_number'] = $order['order_number'];
                    $customValue['table_number'] = $order['table_number'];
                    $customValue['totalQty'] = $order['totalQty'];
                    $customValue['total_amount'] = $order['total_amount'];
                    $customValue['cart'] = $order['cart'];
                    $customValue['time'] = date("g:iA", strtotime($order['created_at']->toTimeString()));
                    $customValue['date'] = $order['created_at']->toDateString();
                    $customValue['status'] = $order['status'];
                    $ordersCustom->add($customValue);
                }

                // dd($orders);
            }
        } else if (auth()->user()->role == 'admin' || auth()->user()->role == 'staff') {
            $restaurants = Restaurant::all();
            if ($order_status) {
                $orders = Order::where(['status' => $order_status])
                    ->get();
            } elseif ($order_status == "all") {
                $orders = Order::all();
            } else {
                $orders = Order::all();
            }
        }
        if ($rest_id == null) {
            $rest_id = $restaurants[0]->id;
        }
        return view('admin.order_requests', compact('restaurants', 'orders', 'order_status', 'rest_id'));
    }

    function orders_by_restaurant_id($id)
    {
        $ordersCustom = collect();
        $customValue = array();

        if (Restaurant::where('id', $id)->exists()) {
            $orders = Order::where('restaurant_id', $id)
                ->get();
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
                $ordersCustom->add($customValue);
            }
        }
        return $ordersCustom;
    }

    public function viewOrderDetails($slug, $id)
    {
        $title = "Order Details";
        // dd($id);
        $cart = array();
        $order = Order::find($id);
        $cart = json_decode($order->cart, 'true');

        // dd($cart);

        return view('admin.orderDetails')->with(compact('order', 'cart', 'title'));
    }

    public function confirmOrder($slug, $id, $status)
    {

        Order::where('id', $id)->update(['status' => $status]);

        // dd($cart);
        $message = "";
        if ($status == 2) {
            $message = "Order Confirmed";
        }
        if ($status == 3) {
            $message = "Order Delivered";
        }
        if ($status == 4) {
            $message = "Order Canceled";
            return redirect()->back()->with('errMsg', "Order Canceled");
        }
        return redirect()->back()->with('message', $message);
    }
}
