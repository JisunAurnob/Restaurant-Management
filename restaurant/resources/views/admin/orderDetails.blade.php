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
                        <h1>Order</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard', ['slug' => Auth::user()->role])}}">Admin</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @if(session()->has('message'))
                <p class="alert alert-success"> {{ session()->get('message') }}</p>
            @endif
            @if(session()->has('errMsg'))
                <p class="alert alert-danger"> {{ session()->get('errMsg') }}</p>
            @endif
            <div class="card">
                {{-- <div class="card-header">
                          <h3 class="card-title">Bordered Table</h3>
                        </div> --}}
                <!-- /.card-header -->
                {{-- {{ dd($menus) }} --}}
                <div class="card-body">
                    
                    <div id="statusChangeMsgDiv">
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Order Information</h5>
                            <p>Order No: {{ $order->order_number }}</p>
                            <p>Order Date: {{ $order->created_at->toDateString() }}</p>
                            <p>Order Time: {{ date("g:iA", strtotime($order->created_at->toTimeString())) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p>Order Status: <span class="@if ($order->status=='pending') status_pending 
                                @elseif ($order->status=='preparing_order') status_confirmed 
                                @elseif ($order->status=='delivered') status_delivered
                                @elseif ($order->status=='canceled') status_canceled @endif">{{ $order->status }}</span></p>
                            <p>Total Price: {{ $order->total_amount }} ৳</p>
                            @if ($order->status=="pending")
                            <a class="btn btn-primary" href="{{$order->id}}/change-status/2">Confirm Order</a>
                            @endif
                            @if ($order->status=="preparing_order")
                            <a class="btn btn-primary" href="{{$order->id}}/change-status/3">Confirm Delivery</a>
                            @endif
                            @if ($order->status=="pending" || $order->status=="preparing_order")
                            <a class="btn btn-danger" href="{{$order->id}}/change-status/4">Cancel Order</a>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h5>Customer Information</h5>
                            <p>Customer Name: {{ $order->customer_name }}</p>
                            <p>Customer Email: {{ $order->customer_email }}</p>
                            <p>Customer Phone: {{ $order->customer_phone }}</p>
                        </div>
                        
                        {{-- Order No: {{$order->order_number}}<br> --}}
                        <div class="col-md-12">
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
                                    @for ($i = 0; $i < count($cart); $i++)
                                        <tr>
                                            <th scope="row">{{ $i + 1 }}</th>
                                            <td>{{ $cart[$i]['quantity'] }}</td>
                                            <td>{{ $cart[$i]['name'] }}</td>
                                            {{-- {{ dd($cart[$i]['attributes']['size']) }} --}}
                                            <td>{{ $cart[$i]['attributes']['size'] }}</td>
                                            <td>{{ $cart[$i]['price'] }} ৳</td>
                                            <td>{{ $cart[$i]['quantity'] * $cart[$i]['price'] }} ৳</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
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
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">

                        <div class="d-flex justify-content-center">
                        </div>
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div>
            {{-- @else
                <div class="text-info">You Haven't Added Any Restaurant Yet</div>
                @endif --}}
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
