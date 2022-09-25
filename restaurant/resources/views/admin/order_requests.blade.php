@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orderDetails.css') }}">
@endpush
@section('title', 'Restaurants')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard', ['slug' => Auth::user()->role]) }}">Admin</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @if (session()->has('message'))
                <p class="alert alert-success"> {{ session()->get('message') }}</p>
            @endif
            @if (session()->has('errMsg'))
                <p class="alert alert-danger"> {{ session()->get('errMsg') }}</p>
            @endif
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        @foreach ($restaurants as $restaurant)
                            <li class="nav-item">
                                @if ($order_status!=null)
                                    
                                    <a class="nav-link @if ($rest_id == $restaurant->id) active @endif"
                                        href="{{ route('getOrders', ['slug' => Auth::user()->role, 'order_status' => $order_status, 'rest_id' => $restaurant->id]) }}">{{ $restaurant->restaurant_name }}</a>
                                    
                                @else
                                    <a class="nav-link @if ($rest_id == $restaurant->id) active @endif"
                                        href="{{ route('getOrders', ['slug' => Auth::user()->role, 'order_status' => 'all', 'rest_id' => $restaurant->id]) }}">{{ $restaurant->restaurant_name }}</a>
                                    
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @foreach ($orders as $order)
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <p>Order No: {{ $order->order_number }}</p>
                                        <p>Order Date: {{ $order->created_at->toDateString() }}</p>
                                        <p>Order Time: {{ date('g:iA', strtotime($order->created_at->toTimeString())) }}
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <p>Order Status: <span
                                                class="@if ($order->status == 'pending') status_pending 
                                                @elseif ($order->status == 'preparing_order') status_confirmed 
                                                @elseif ($order->status == 'delivered') status_delivered
                                                @elseif ($order->status == 'canceled') status_canceled @endif">{{ $order->status }}</span>
                                        </p>
                                        <p>Total Price: {{ $order->total_amount }} ৳</p>
                                        @if ($order->status == 'pending')
                                            <a class="btn btn-primary"
                                                href="{{ route('changeStatus', ['slug' => Auth::user()->role, 'id' => $order->id, 'status' => 2]) }}">Confirm
                                                Order</a>
                                        @endif
                                        @if ($order->status == 'preparing_order')
                                            <a class="btn btn-primary"
                                                href="{{ route('changeStatus', ['slug' => Auth::user()->role, 'id' => $order->id, 'status' => 3]) }}">Confirm
                                                Delivery</a>
                                        @endif
                                        @if ($order->status == 'pending' || $order->status == 'preparing_order')
                                            <a class="btn btn-danger"
                                                href="{{ route('changeStatus', ['slug' => Auth::user()->role, 'id' => $order->id, 'status' => 4]) }}">Cancel
                                                Order</a>
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <h5>Customer Information</h5>
                                        <p>Customer Name: {{ $order->customer_name }}</p>
                                        <p>Customer Email: {{ $order->customer_email }}</p>
                                        <p>Customer Phone: {{ $order->customer_phone }}</p>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- {{dd(json_decode($order->cart, 'true'))}} --}}
                                                @for ($i = 0; $i < count(json_decode($order->cart, 'true')); $i++)
                                                    <tr>
                                                        <th scope="row">{{ $i + 1 }}</th>
                                                        <td>{{ json_decode($order->cart, 'true')[$i]['quantity'] }}</td>
                                                        <td>{{ json_decode($order->cart, 'true')[$i]['name'] }}</td>
                                                        {{-- {{ dd($cart[$i]['attributes']['size']) }} --}}
                                                        <td>{{ json_decode($order->cart, 'true')[$i]['attributes']['size'] }}
                                                        </td>
                                                        <td>{{ json_decode($order->cart, 'true')[$i]['price'] }} ৳</td>
                                                        <td>{{ json_decode($order->cart, 'true')[$i]['quantity'] * json_decode($order->cart, 'true')[$i]['price'] }}
                                                            ৳</td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                        {{-- kkk --}}
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <h6>Payment Method: {{ $order->payment_method }}</h6> --}}
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table">
                                            {{-- <thead class="thead-dark">
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Name</th>
                                          <th scope="col">Price</th>
                                          <th scope="col">Quantity</th>
                                          <th scope="col">Sub Total</th>
                                        </tr>
                                      </thead> --}}
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total: </td>
                                                    <td>
                                                        ৳ {{ $order->total_amount - $order->vat }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Vat: </td>
                                                    <td>
                                                        ৳ {{ $order->vat }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total: </td>
                                                    <td>
                                                        ৳ {{ $order->total_amount }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                    {{-- </ul> --}}
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

            });
        </script>

        {{-- <script src="{{ asset('something.js') }}"></script> --}}
    @endpush
@endsection
