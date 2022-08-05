<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('dashboard');
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
                'restaurant_photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'opening_time' => 'required',
                'closing_time' => 'required',
                'business_days' => 'required|string|max:255'
            ],
            []
        );

        if (!empty($request->file('restaurant_photo'))) {
            $path = $request->file('restaurant_photo')->store('public/restaurants/pictures');
            // $var->Picture= substr($path, 6, 3000);
        }

        $restaurant = new Restaurant();
        $restaurant->restaurant_name = $request->restaurant_name;
        $restaurant->restaurant_type = $request->restaurant_type;
        $restaurant->slogan = $request->slogan;
        $restaurant->email = $request->email;
        $restaurant->phone = $request->phone;
        $restaurant->address = $request->address;
        $restaurant->restaurant_photo = substr($path, 7);
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
    public function edit_restaurant($id)
    { //not done
        $staff = User::find($id);
        return view('admin.forms.edit_staffs', compact('staff'));
    }

    public function edit_restaurant_post(Request $request)
    { //not done
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

        if (!empty($request->file('menu_picture'))) {
            $path = $request->file('menu_picture')->store('public/restaurants/menu_pictures');
            // $var->Picture= substr($path, 6, 3000);
        }

        $restaurant = new Menu();
        $restaurant->menu_name = $request->menu_name;
        $restaurant->menu_description = $request->menu_description;
        $restaurant->menu_picture = substr($path, 7);
        $restaurant->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', $request->menu_name)));
        $restaurant->restaurant_id = $request->restaurant_id;
        $restaurant->save();

        return redirect()->route('show_menus', ['slug' => auth()->user()->role]);
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
                'product_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'menu_id' => 'required'
            ],
            []
        );

        if (!empty($request->file('product_picture'))) {
            $path = $request->file('product_picture')->store('public/restaurants/product_pictures');
            // $var->Picture= substr($path, 6, 3000);
        }

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_type = $request->product_type;
        $product->product_picture = substr($path, 7);
        $product->menu_id = $request->menu_id;
        $product->product_status = 'upcoming';
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
            if (Product::where('id', $id)->exists()) {
                $data = Product::where('menu_id', $id)
                    ->get();
                //    $total = $data[0]->market_name;
            }
            return $data;
    }
}
